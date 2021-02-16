<template>
    <v-app>
        <!--<div>HEllo see you on hello131</div>-->        
        <v-data-table 
            :headers="headers" 
            :items="desserts" 
            sort-by="id" 
            class="table-striped elevation-1">       
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
                                            <!--<div class="selectdiv form-group pt-1">-->
                                            <div class="form-group pt-1">
                                                <label class="border-0 bg-white">Role</label>

                                                <!--
                                                <select 
                                                    class="form-control mr-1 select_menu"                                                                                                        
                                                    v-model="selectedRoleValue"
                                                    @change="selectedOption($event.target.value)">
                                                    <option value="0" disabled selected>--請選擇--<i class="fas fa-arrow-down"></i></option>
                                                    <option :value="num.roleValue" v-for="(num, index) in cardRoleItems" :key="index">
                                                        {{ num.roleName }}
                                                    </option>
                                                </select>
                                                -->
                                                
                                                <div 
                                                    class="storeSelecWrap j-store-select selWrap" 
                                                    @click="slideToggleSelector">
                                                    <div v-bind:class="['s-dropdown--styled', {'open': isOpen}]">
                                                        <div class="span store-default">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group span-have-same-height">
                                                                        <span 
                                                                            v-bind:class="[{'badge badge-pill badge-success': isChip}]"
                                                                                style="font-size: 15px;">
                                                                            {{ selectedRoleName }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            <!--
                                                            <span v-bind:class="[{'chip_for_select_style': isChip}]">
                                                                {{ selectedRoleName }}
                                                            </span>
                                                            -->
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <!--<div class="arrow"></div>-->
                                                                        <div class="svg-arrow" @click="isRotateArrow=!isRotateArrow">
                                                                            <svg 
                                                                                v-bind:class="['svg-inline--fa fa-chevron-top fa-w-14', {'svg-arrow-rotate': isRotateArrow}]" 
                                                                                aria-hidden="true" 
                                                                                focusable="false" 
                                                                                data-prefix="fa" 
                                                                                data-icon="chevron-down" 
                                                                                role="img" 
                                                                                xmlns="http://www.w3.org/2000/svg" 
                                                                                viewBox="0 0 448 512" 
                                                                                data-fa-i2svg="">
                                                                                <path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path>
                                                                            </svg>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <vue-slide-up-down 
                                                            :active="isSidebarDropdown" 
                                                            :duration="500"
                                                            class="slide-area">
                                                            <ul class="s-dropdown u-hide">
                                                            <li 
                                                                :value="num.roleValue"
                                                                :data-value="num.roleValue"
                                                                v-bind:class="[ {'selected': isSelected[index]}]"                                                                
                                                                v-for="(num, index) in cardRoleItems" 
                                                                :key="index"
                                                                @click.prevent="setOptionActive($event.target.value, index)">
                                                                {{ num.roleName }}
                                                            </li>
                                                            </ul>
                                                        </vue-slide-up-down>
                                                    </div>
                                                </div>                                                

                                                <!--
                                                <select 
                                                    class="form-control mr-1 select_menu" 
                                                    v-model="selectedRoleValue"
                                                    @change="selectedOption($event.target.value)">
                                                    <option value="0" disabled selected>--請選擇--<i class="fas fa-arrow-down"></i></option>
                                                    <option :value="num.roleValue" v-for="(num, index) in cardRoleItems" :key="index">
                                                        {{ num.roleName }}
                                                    </option>
                                                </select>
                                                -->
                                                <!--<label>商品數量： {{ selectedRoleValue }}</label>-->                                                

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
import VueSlideUpDown from 'vue-slide-up-down';

export default {
	components: {
		VueSlideUpDown,    //vue-slide-up-down
    },
    props: [
        "value"
    ],    
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
            cardRoleselected:[
                {   roleName:"Administrator", 
                    roleValue: 2
                }
            ],
            cardRoleItems: [
                {   roleName:'Project-Manager', 
                    icon: 'fa-book', 
                    roleValue: 1
                },
                {   roleName:'Web-Developer', 
                    icon: 'fa-book', 
                    roleValue: 2
                }, 
                {   roleName:'Administrator', 
                    icon: 'fa-book', 
                    roleValue: 3
                }, 
                {   roleName:'Manager', 
                    icon: 'fa-book', 
                    roleValue: 4
                }, 
                {   roleName:'Author', 
                    icon: 'fa-book', 
                    roleValue: 5
                },
                {   roleName:'User', 
                    icon: 'fa-book', 
                    roleValue: 6
                }
            ],
            selectedRoleName: "--請選擇--",
            selectedRoleValue: 1,
            idList: [],
            idList1: [],

            isSidebarDropdown: false,
            isSelected: [],
            isChip: false,
            isOpen: false,
            isRotateArrow: false,
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
        for (let i = 0; i < 6; i++) {
            this.isSelected.push(false);
        }

        this.selectedRoleValue = 0;

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
            console.log("editIndex... ", this.editedIndex);
            if (typeof(this.editedItem.roleName) != "undefined") {
                console.log("editedItem.roleName... ", this.editedItem.roleName);
                this.cardRoleselected.roleName = this.editedItem.roleName;

                for (let j = 0; j < this.cardRoleItems.length; j++) {
                    this.isSelected[j]=false;
                }
                this.isSidebarDropdown = false;
                this.isChip = true;

                for (let i = 0 ; i < this.cardRoleItems.length; i++) {
                    if (this.cardRoleItems[i].roleName.toUpperCase().trim() === this.editedItem.roleName.toUpperCase().trim()) {
                        this.cardRoleselected.roleValue = this.cardRoleItems[i].roleValue;
                        this.selectedRoleName = this.cardRoleselected.roleName;
                        this.selectedRoleValue = this.cardRoleselected.roleValue;
                        this.isSelected[i] = true;
                        break;
                    }
                }            
                console.log("editItem....", this.cardRoleselected.roleName, this.cardRoleselected.roleValue);
            }
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
            this.editedItem.roleName = this.cardRoleItems[this.selectedRoleValue-1].roleName;
            if (this.editedIndex > -1) {
                Object.assign(this.desserts[this.editedIndex], this.editedItem) //deep copy this.editedItem物件 into this.desserts[this.editedIndex]物件
            } else {
                this.desserts.push(this.editedItem)
            }
            //
            const roleData = {
      			id: this.editedIndex+1,
      			roleId: this.selectedRoleValue,
    		};
            this.$store.dispatch('attatchedRoleIntoUser', roleData);
            //
            this.close()
        },
       
        selectedOption(e) {
            this.selectedRoleValue = event.target.value;
            console.log("select event.target.value...", this.selectedRoleValue);
            let targetHTML = event.target.options[event.target.selectedIndex];
            let inner = targetHTML.innerHTML.trim();
            console.log("children1...", targetHTML);
            console.log("inner...", inner);
            //var newDiv = document.createElement('span');
            //newDiv.innerHTML = inner;
            //targetHTML.appendChild(newDiv);

            ///targetHTML.innerHTML="<span class='chip_style'>" + inner + "</span>";
            ///console.log("children2...", targetHTML);
        },

        slideToggleSelector() {
        //console.log("event.target.find...", event.target.children[1].children);
        this.isSidebarDropdown=!this.isSidebarDropdown;
        this.isOpen=!this.isOpen;
        // this.isSelected[this.selectedRoleValue] = true;
        },

        setOptionActive(e, index) {
            for (let i = 0; i < 6; i++) {
                this.isSelected[i]=false;
            }
            console.log("select index...", index);
            this.isSelected[index] = true;

            this.selectedRoleValue = event.target.value;
            this.selectedRoleName = this.cardRoleItems[index].roleName;
            this.isChip = true;
            console.log("select event.target.value...", this.selectedRoleValue);
            let targetHTML = event.target;
            let inner = targetHTML.innerHTML.trim();
            console.log("children1...", targetHTML);
            console.log("inner...", inner);
        },                
    },
}
</script>

<style scoped>
/*
  .table-striped tbody tr:nth-of-type(even) {
    background-color: rgb(39, 204, 204);
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgb(250 ,250, 250);
  }
*/

.fa-edit:hover:before {
    cursor: pointer;
    color: green;
    /*content: "\f02c";*/
}

.fa-trash-alt:hover:before {
    cursor: pointer;
    color: red;
}

/*
.select_menu{
  font-size: 12px;
  outline: none;
  border: thin #ddd solid;
  background-color: #f7f7f7;
}
*/

/*
.style-chooser .vs__dropdown-toggle .vs__selected-options .vs_search {
    width: 50%;
}
*/

/*
.selectdiv {
  position: relative;
}

.selectdiv:after {
  content: '<>';
  font: 17px "Consolas", monospace;
  color: #333;
  transform: rotate(90deg);
  right: 11px;
    
  top: 52px;
  padding: 0 0 2px;
  border-bottom: 1px solid #999;
    
  position: absolute;
  pointer-events: none;
}

.selectdiv select {
  appearance: none;
    
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
*/

/*
.chip_style::after {
    color: #1e1e;
}

.chip_style {
    color: #1e1e;
}
*/

.mySelectTag .dropdown li {
  border-bottom: 1px solid rgba(112, 128, 144, 0.1)
}

.mySelectTag .dropdown li:last-child {
  border-bottom: none;
}

.mySelectTag .dropdown li a {
  padding: 10px 20px;
  display: flex;
  width: 100%;
  align-items: center;
  font-size: 1.25em;
}

.mySelectTag .dropdown li a .fa {
  padding-right: 0.5em;
}

/*    */
.selWrap {
  border: 1px solid grey;
  width: 250px;
  border-radius: 3px;
  margin: auto;
  /*margin-top: 100px;*/
}

/*
.u-hide {
  display: none;
}
*/

.s-dropdown--styled {
  border-radius: 3px;
  padding: 10px 0px;
  box-sizing: border-box;
  width: 100%;
  text-align: left;
  font-size: 15px;
  font-family: "nnReg", Helvetica, Arial, sans-serif;
}

.store-default {
  /*display: inline;*/
  margin: 0 1em 0 1em;
}

.s-dropdown--styled .span {
  color: grey;
  padding-left: 13px;
  cursor: pointer;
  display: block;
  position: relative;
}

.s-dropdown--styled .span::before {
  position: absolute;
  right: 10px;
}

.s-dropdown--styled ul {
  box-sizing: border-box;
  list-style-type: "";
  padding-top: 10px;
  padding-left: 0px;
}
.s-dropdown--styled ul li {
  box-sizing: border-box;
  padding: 15px 13px 15px 53px;
  position: relative;
  line-height: 20px;
  cursor: pointer;
  color: grey;
}

.s-dropdown--styled ul li::before {
  content: "";
  border: grey solid 1px;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 13px;
  height: 24px;
  width: 24px;
  border-radius: 50%;
  cursor: pointer;
}

.s-dropdown--styled ul li.selected {
  background-color: #3deb4b;
}

.s-dropdown--styled ul li.selected::after {
  content: "";
  border: grey solid 1px;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 18.5px;
  height: 13px;
  width: 13px;
  border-radius: 50%;
  background-color: grey;
}

.s-dropdown--styled ul li:hover {
  background-color: #e2c8e6;
}

.chip_for_select_style {
    padding: 10px 10px;   
    vertical-align: middle;
    display: inline-block;
    height: 40px;
    font-size: 16px;
  /*line-height: 40px;*/
    border-radius: 20px;
    background-color: #f19191;
}

.slide-area {
    padding-top: 10px;

    box-sizing: border-box;
    border: 5px solid blue;
    border-radius: 10px;
}

/*  */

.arrow {
    position: relative;
    /*
    left: 200px;
    top: -25px;
*/              
    height: 15px;
    width: 15px;
}
 .arrow::before, .arrow::after {
     content: "";
     position: absolute;
     bottom: 0px;
     width: 0.15rem;
     height: 100%;
     transition: all 0.5s;
}
 .arrow::before {
     left: -5px;
     transform: rotate(45deg);
     background-color: #394a6d;
}
 .arrow::after {
     left: 5px;
     transform: rotate(-45deg);
     background-color: #394a6d;
}
 .open .arrow::before {
     left: -5px;
     transform: rotate(-45deg);
}
 .open .arrow::after {
     left: 5px;
     transform: rotate(45deg);
}

.span-have-same-height {
    height: 100%;
    margin: auto;
}

div.svg-arrow {
    position: absolute;
    top: 50%;
    left: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    transform: translate(-50%, -50%);
}

.svg-arrow-rotate {
    transform: rotate(180deg);
}

div svg {
    width: 1.5rem;
    transition: transform .3s ease-in-out;  
}
</style>
