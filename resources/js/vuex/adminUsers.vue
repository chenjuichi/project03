<template>
    <div>
        <div class="content">
            <div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">		
					<p class="_title0">
						Tags
						<Button @click="addModal=true"><Icon type="md-add" size="small" />&nbsp;Add Admin</Button>
					</p>         		
					

					<v-data-table :headers="headers" :items="usersData">
					<template v-slot:item="row">
						<!-- ITEMS -->
						<tr>
							<td class="">{{row.item.id}}</td>
							<td class="">{{row.item.name}}</td>
							<td class="">{{row.item.email}}</td>
							<td class="">{{row.item.roleName}}</td>
							<td class="">{{row.item.created_at}}</td>
							<td>
								<Button type="info" size="small" @click="showEditModal(row.item)">Edit</Button>
								<Button type="error" size="small" @click="showDeletingModal(row.item)"  :loading="user.isDeleting">Delete</Button>
							</td>
						</tr>
						<!-- ITEMS -->
					</template>
					</v-data-table>
				</div>

				<!-- tag adding modal -->
				<Modal 
					v-model="addModal" 
					title="Add admin" 
					:mask-closable="false" 
					:closable="false">
					<div class="space">					
						<Input v-model="data.fullName" placeholder="Add name" />
					</div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Add email"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Add password"  />
                    </div>

                    <div class="space">
                        <Select v-model="data.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i">{{r.name}}</Option>
                        </Select>
                    </div>

					<div slot="footer">
						<Button 
							type="default" 
							@click="addModal=false">
							Close
						</Button>
						<Button 
							type="primary" 
							@click="addAdmin"
							:disabled="isAdding" 
							:loading="isAdding">
							{{isAdding ? 'Adding..' : 'Add admin'}}
						</Button>						
					</div>
				</Modal>
				<!-- tag adding modal -->				

				<!-- tag editing modal -->
				<Modal 
					v-model="editModal" 
					title="Edit admin" 
					:mask-closable="false" 
					:closable="false">
                    <div class="space">
                        <Input type="text" v-model="editData.fullName" placeholder="Full name"  />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Email"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Password"  />
                    </div>
                    <div class="space">
                        <Select v-model="editData.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i">{{r.name}}</Option>
                        </Select>
                    </div> 
	
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Admin'}}</Button>
					</div>
				</Modal>
				<!-- tag editing modal -->

				<!-- tag delete alert modal -->
				<delete-modal></delete-modal>
				<!-- tag delete alert modal -->
            </div>
        </div>        
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import deleteModal from './deleteModal';
import Cookies from 'js-cookie';

export default {
	components: {
		deleteModal,		
	},	
	
    mounted() {
        //
	},
	
	data() {
		return {
			// TABLE TITLE
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Name', value: 'name' },
                { text: 'E-Mail', value: 'email', sortable: false},
                { text: 'User type', value: 'roleName'},   
				{ text: 'Created at', value: 'createdAt', sortable:false}, 	//add item
                { text: 'Actions', value: 'actions', sortable: false },
            ],
			// TABLE TITLE

			data : {
				fullName: '',
				email: '',
				password: '',
				role_id: 0,
			}, 			
			addModal: false,
			editModal: false,
			isAdding: false,

			roles: [],
			usersData: [],
            idList: [],
			idList1: [],

			editData: {
				fullName: '',
				email: '',
				password: '',
				role_id: 0,

			},
			index: -1,
			showDeleteModal: false,
			isDeleting: false,
			deleteItem: {}, 
			deletingIndex: -1,
			token: '',  
			
			websiteSettings: [],			
		};
	},
	
	async created() {
		this.token = window.Laravel.csrfToken;
		
		const resRole = await this.callApi('get', '/api/get_roles');
		if (resRole.status === 200) {
			this.roles = resRole.data;
		} else {
			console.log("role error: ", resRole.status);
			this.swr();
		}

		this.loading = true;
      	this.$store.dispatch('loadedAllUsers');
        this.loading = false;
        console.log("created() : list users....");

		//const [res, resRole] = await Promise.all([
		//	this.callApi('get', '/api/get_users'), 
		//	this.callApi('get', '/api/get_roles')
		//])
		//if(res.status==200){
		//	this.users = res.data
		//}else{
		//	this.swr()
		//}
		//if(resRole.status==200){
		//	this.roles = resRole.data
		//}else{
		//	this.swr()
		//}
	},

	computed: {
		...mapState({	//Spread in object literals
			lastSearchComputed: "lastSearch",
			user: "user",
			isLoggedIn: "isLoggedIn",
			allUsers: "allUsers",
		}),
		
		...mapGetters({
            
		}),
		
		//somethingElse() {
		//	return 1+2;
		//},
		users() {
			const nameList = Object.values(this.allUsers).map(item => item.name);
			return nameList;
        },
	},
	
    watch: {
    	'$store.state.immediate': function() {
            console.log("watch:ListUsers....");
			this.initialize();
        },
    },	
	
	methods: {
        initialize () {
            let temp = this.allUsers.slice();
            console.log("this.allUsers....", temp);

            this.idList1 = Object.values(temp).map(item => item.roles);
            for ( let i = 0; i < this.idList1.length; i++) {
                if (this.idList1[i] === [])
                    this.idList[i] = "";
                else
                    this.idList[i] = this.idList1[i].map(item => Object.values(item)[1]);	//get role's name
            }
            console.log("this.idList....", this.idList);
            
            this.usersData = this.allUsers.slice(); 
            this.usersData.forEach(function(v){
                //delete v.created_at;
                delete v.email_verified_at;
                delete v.updated_at;
                delete v.roles;
            });

            for ( let i = 0; i < this.usersData.length; i++) {
                this.usersData[i].roleName = this.idList[i][0];
            }            
            console.log("this.usersData....", this.usersData);
        },

		async addAdmin() {
            if (this.data.fullName.trim()=='') return this.e('Full name is required')
            if (this.data.email.trim()=='') return this.e('Email is required')
			if (this.data.password.trim()=='') return this.e('Password is required')
			
            if (!this.data.role_id) return this.e('User type is required')
            
			const res = await this.callApi('post', '/api/create_user', this.data)

			if (res.status===201) {
				this.users.unshift(res.data)
				this.s('Admin user has been added successfully!')
				this.addModal = false;

				this.data.fullName = '';
				this.data.email = '';
				this.data.password = '';
				this.data.role_id = 0;
			} else {
				if (res.status==422) {	//error 422：請求是正確的，但可能不符合操作流程（check 後端的回應以找到問題）
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0])
                    }
				} else {
					this.swr()
				}
				
			}
		},
		async editAdmin() {
			if (this.editData.fullName.trim()=='') return this.e('Full name is required')
            if (this.editData.email.trim()=='') return this.e('Email is required')
            if (!this.editData.role_id) return this.e('User type  is required')
			const res = await this.callApi('post', '/api/edit_user', this.editData)
			if (res.status===200) {
				this.users[this.index] = this.editData
				this.s('User has been edited successfully!')
				this.editModal = false;				
			} else {
				if (res.status==422){
					for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }					
				} else {
					this.swr();
				}				
			}
		},
		showEditModal(user){
			this.index = this.usersData.indexOf(user);

			//console.log ("showEditModal, user, index: ", user);
			let i = 0;		
			while ((this.roles[i].name != user.roleName) && (i < this.roles.length)) {
				console.log ("showEditModal, loop: ", this.roles[i].name, user.roleName);
				i++;	
			}	
			//console.log ("showEditModal, orig selected role_id: ", i);

			let obj = {
				id : user.id, 
				fullName : user.name, 
				email : user.email,
				role_id : i + 1, 
			};
			this.editData = obj;
			this.editModal = true;
			//this.index = index;
		}, 		
		async deleteTag(){
			this.isDeleting = true;
			const res = await this.callApi('post', '/api/delete_tag', this.deleteItem)
			if (res.status===200) {
				this.tags.splice(this.deletingIndex, 1);
				this.s('Tag has been deleted successfully!');
			} else {
				this.swr();
			}
			this.isDeleting = false;
			this.showDeleteModal = false;
		}, 
		showDeletingModal(tag, i) {
			const deleteModalObj  =  {
				showDeleteModal: true, 
				deleteUrl : '/api/delete_tag', 
				data : tag, 
				deletingIndex: i, 
				isDeleted : false,
			}
            this.$store.dispatch('setDeletingModalObj', deleteModalObj);
			console.log("adminUsers.vue showDeletingModal function is called...")
		},
	},
};
</script>

<style scoped>
@import "../../css/fullstack.css";
</style>
