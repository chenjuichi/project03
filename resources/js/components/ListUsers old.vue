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
                    <v-dialog v-model="dialog" max-width="750px">
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
                                        <v-col cols="12" sm="4" md="4">
                                            <v-text-field
                                                v-model="editedItem.name"
                                                label="Name">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="4" md="4">
                                            <v-text-field
                                                v-model="editedItem.email"
                                                label="Email">
                                            </v-text-field>
                                        </v-col>
                                        <!--
                                        <v-col cols="12" sm="4" md="4">
                                            <v-text-field
                                                v-model="editedItem.roleName"
                                                label="Role">
                                            </v-text-field>
                                        </v-col>
                                        -->
      <v-col cols="12" sm="4" md="4">
        <v-select
          :items="cardRoleItems"
          v-model="cardRoleSelect"          
          ref="vSelect"          
          label="Role"
          small-chips
          item-text="text"
          item-value="value"
          single-line
          
        ></v-select>
      </v-col>

    <!--
        <v-col cols="12" sm="4" md="4">
            <v-combobox
                v-model="select"
                :items="roleItems"
                label="Role"
                multiple
                chips>
                <template v-slot:selection="data">
                    <v-chip
                        :key="JSON.stringify(data.item)"
                        v-bind="data.attrs"
                        :input-value="data.selected"
                        :disabled="data.disabled"
                        @click:close="data.parent.selectItem(data.item)">
                        <v-avatar
                            class="accent white--text"
                            left
                            v-text="data.item.slice(0, 1).toUpperCase()"
                        ></v-avatar>
                        {{ data.item }}
                    </v-chip>
                </template>
            </v-combobox>
        </v-col>
    -->
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
            <!--<template v-slot: [&#x60;item.actions&#x60;]= "{ item }">-->
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
                name: '',
                email: '',
                roleName: '',       //add items
            },
            defaultItem: {
                name: '',
                email: '',
                roleName: '',       //add items
            },
            cardRoleSelect:[{text:"Administrator", value: 2}],
            cardRoleItems: [{text:"Project-Manager", value: 0},
                            {text:"Web-Developer", value: 1}, 
                            {text:"Administrator", value: 2}, 
                            {text:"Manager", value: 3}, 
                            {text:"Author", value: 4},
                            {text:"User", value: 5}],
            selectText: this.cardRoleSelect.text,
            selectValue: this.cardRoleSelect.value,
            
            idList: [],
            idList1: [],
        }
    },
    computed: {
        ...mapState({	//Spread in object literals
            lastSearchComputed: "lastSearch",
            user: "user",
            isLoggedIn: "isLoggedIn",
            //allUsers: "allUsers",
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
        countItemsInBasket() {
            console.log("countItemsInBasket: ", this.itemsInBasket);
            return 22;
        },

        formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
        getitemcontrols() {  //solve error: 'v-slot' directive doesn't support any modifier
            return 'item.actions';
        },
        changeRoute(a) {
            console.log("v-select....", a);
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
            //console.log("editItem function...", this.$refs.vSelect);
            this.cardRoleSelect.text = this.editedItem.roleName;
            for (let i = 0 ; i < this.cardRoleItems.length; i++) {
                if (this.cardRoleItems[i].text.toUpperCase().trim() === this.editedItem.roleName.toUpperCase().trim()) {
                    this.cardRoleSelect.value = this.cardRoleItems[i].value; 
                    break;
                }
            }            
            console.log("editItem....", this.cardRoleSelect.text, this.cardRoleSelect.value);
            //console.log("editItem function...", this.$refs.vSelect);
            //
            this.dialog = true;
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
            this.close()
        },
        //getKeyByValueForObject(object, value) {
        //    return Object.keys(object).find(key => object[key] === value);
        //},
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
</style>
