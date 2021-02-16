<template>
    <v-app>
        <!--<div>HEllo see you on hello131</div>-->        
        <v-data-table 
            :headers="headers" 
            :items="desserts" 
            sort-by="id" 
            class="elevation-1">       
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>Users List</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="800px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                Add Item
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>  
                                        <v-col cols="12" sm="4" md="4" mr-1>
                                            <div class="form-group pt-1">                                                
                                                <label class="border-0 bg-white">Name</label>                                                
                                                <v-text-field v-model="editedItem.name"></v-text-field>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="4" md="4" mr-1>
                                            <div class="form-group pt-1">                                                
                                                <label class="border-0 bg-white">Email</label>                                                
                                                <v-text-field v-model="editedItem.email"></v-text-field>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="4" md="4" mr-1>
                                            <div class="selectdiv form-group pt-1">
                                                <label class="border-0 bg-white">Role</label>  
                                                <select 
                                                    class="form-control mr-1 select_menu" 
                                                    v-model="selectValue"
                                                    @change="selectedOption($event.target.value)">
                                                    <option value="0" disabled selected>--請選擇--<i class="fas fa-arrow-down"></i></option>
                                                    <option :value="num.value" v-for="(num, index) in cardRoleItems" :key="index">{{ num.text }}<i class="fas fa-arrow-down"></i></option>
                                                </select>
                                                <label>商品數量： {{ selectValue }}</label>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
        
            <template v-slot:[getitemcontrols] = "{ item }">        
            <!--<template v-slot:item.actions = "{ item }">-->        
                <i class="fas fa-edit" @click="editItem(item)"></i>        
                <i class="fas fa-trash-alt" @click="deleteItem(item)"></i>
            </template>
        
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>        
        
        </v-data-table>
    </v-app>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
	components: {

    },
	data () {
		return {
		    loading: false,

            dialog: false,
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Name', value: 'name' },
                { text: 'E-Mail', value: 'email', sortable: false},
                { text: 'Role', value: 'roleName', sortable: false},   //add items
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            desserts: [],
            editedIndex: -1,
            editedItem: {
                //id: '',
                name: '',
                email: '',
                roleName: '',       //add items
            },
            defaultItem: {
                //id: '',
                name: '',
                email: '',
                roleName: '',       //add items
            },
            cardRoleSelect:[{text:"Administrator", value: 2}],
            cardRoleItems: [{text:"Project-Manager", value: 1},
                            {text:"Web-Developer", value: 2}, 
                            {text:"Administrator", value: 3}, 
                            {text:"Manager", value: 4}, 
                            {text:"Author", value: 5},
                            {text:"User", value: 6}],
            selectText: "",
            selectValue: 1,
            idList: [],
            idList1: [],
        }
    },
    computed: {
        ...mapState({	//Spread in object literals
            lastSearchComputed: "lastSearch",
            user: "user",
            isLoggedIn: "isLoggedIn",
        }),
        ...mapGetters({
            itemsInBasket: "itemsInBasket"
        }),
        somethingElse() {
            return 1+2;
        },
		allUsers() {
			return this.$store.getters.allUsers;
		},
        users() {
            const nameList = Object.values(this.allUsers).map(item => item.name);
            return nameList;
        },

        formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
        getitemcontrols() {  //solve error: 'v-slot' directive doesn't support any modifier
            return 'item.actions';
        },

    },
    watch: {
        dialog (val) {
            val || this.close()
        },
    	'$store.state.immediate': function() {
            console.log("watch:ListUsers....");
			this.initialize();
        },
    },
    created () {
        this.selectValue = 0;

		this.loading = true;
      	this.$store.dispatch('loadedAllUsers');
        this.loading = false;
        console.log("created:ListUsers....");
    },

    methods: {
        initialize () {
            let temp = this.allUsers.slice();
            console.log("this.desserts1....", temp);

            this.idList1 = Object.values(temp).map(item => item.roles);
            for ( let i = 0; i < this.idList1.length; i++) {
                if (this.idList1[i] === [])
                    this.idList[i] = "";
                else
                    this.idList[i] = this.idList1[i].map(item => Object.values(item)[2]);
            }
            console.log("this.desserts2....", this.idList);
            
            this.desserts = this.allUsers.slice(); 
            this.desserts.forEach(function(v){
                delete v.created_at;
                delete v.email_verified_at;
                delete v.updated_at;
                delete v.roles; //
            });

            for ( let i = 0; i < this.desserts.length; i++) {
                this.desserts[i].roleName = this.idList[i][0];
            }            
        },

        editItem (item) {
            this.editedIndex = this.desserts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            //
            this.cardRoleSelect.text = this.editedItem.roleName;
            for (let i = 0 ; i < this.cardRoleItems.length; i++) {
                if (this.cardRoleItems[i].text.toUpperCase().trim() === this.editedItem.roleName.toUpperCase().trim()) {
                    this.cardRoleSelect.value = this.cardRoleItems[i].value;
                    this.selectText = this.cardRoleSelect.text;
                    this.selectValue = this.cardRoleSelect.value;
                    break;
                }
            }            
            console.log("editItem....", this.cardRoleSelect.text, this.cardRoleSelect.value);
            //console.log("editItem....", this.cardRoleSelect);
            //
            this.dialog = true;

            //var allinputs = document.querySelectorAll('input.vs_search');
            //console.log("allinputs: ", allinputs.length)
            //for (var i = 0; i < allinputs.length; ++i) {
            //    allinputs[i].classList.add(' w-50');
            //}            
        },

        deleteItem (item) {
            const index = this.desserts.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                //console.log("close...", this.defaultItem.roleName);
                this.editedItem = Object.assign({}, this.defaultItem);
                //console.log("close...", this.defaultItem.roleName, this.editedItem.roleName);
                this.editedIndex = -1
            })
        },

        save () {
            if (this.editedIndex > -1) {
                Object.assign(this.desserts[this.editedIndex], this.editedItem)
                //this.$refs.sidebar
            } else {
                this.desserts.push(this.editedItem)
            }
            //
            const roleData = {
      			id: this.editedIndex+1,
      			roleId: this.selectValue,
    		};
            this.$store.dispatch('attatchedRoleIntoUser', roleData);
            this.loading = true;
      	    this.$store.dispatch('loadedAllUsers');
            this.loading = false;

            //
            this.close()
        },
       
        selectedOption(value) {
            console.log("select...", value, this.selectValue);
             
         },
    },
}
</script>

<style scoped>
.fa-edit:hover:before {
    cursor: pointer;
    color: green;
    /*content: "\f02c";*/
}

.fa-trash-alt:hover:before {
    cursor: pointer;
    color: red;
}

.select_menu{
  font-size: 12px;
  outline: none;
  border: thin #ddd solid;
  background-color: #f7f7f7;
}

/*
.style-chooser .vs__dropdown-toggle .vs__selected-options .vs_search {
    width: 50%;
}
*/

.selectdiv {
  position: relative;
  /*Don't really need this just for demo styling*/
  /*
  float: left;
  min-width: 200px;
  margin: 50px 33%;
  */
}

.selectdiv:after {
  content: '<>';
  font: 17px "Consolas", monospace;
  color: #333;
  transform: rotate(90deg);
  right: 11px;
  /*Adjust for position however you want*/
  
  top: 52px;
  padding: 0 0 2px;
  border-bottom: 1px solid #999;
  /*left line */
  
  position: absolute;
  pointer-events: none;
}

.selectdiv select {
  appearance: none;
  /* Add some styling */
  
  display: block;
  width: 100%;
  max-width: 320px;
  height: 50px;
  float: right;
  margin: 5px 0px;
  padding: 0px 24px;
  font-size: 16px;
  line-height: 1.75;
  color: #333;
  background-color: #ffffff;
  background-image: none;
  border: 1px solid #cccccc;
  word-break: normal;
}
</style>
