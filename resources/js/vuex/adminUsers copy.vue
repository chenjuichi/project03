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
					
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>User type</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
								<tr v-for="(user, i) in allUsers" :key="i">
									<td>{{ user.id }}</td>
									<td class="_table_name">{{ user.name }}</td>
									<td>{{ user.email }}</td>
									<td>{{ user.userType }}</td>
									<td>{{ user.created_at }}</td>
									<td>
										<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
										<Button type="error" size="small" @click="showDeletingModal(user, i)"  :loading="user.isDeleting">Delete</Button>
									</td>
								</tr>
								<!-- ITEMS -->
						</table>
					</div>
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
				<Modal v-model="editModal" title="Edit tag" :mask-closable="false" :closable="false">
					<Input v-model="editData.tagName" placeholder="Edit tag name" />
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit tag'}}</Button>
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
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Name', value: 'name' },
                { text: 'E-Mail', value: 'email', sortable: false},
                { text: 'User type', value: 'roleName', sortable: false},   
				{ text: 'Created at', value: 'createdAt', sortable:false}, 	//add item
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            desserts: [],

			data : {
				fullName: '',
				email: '',
				password: '',
				role_id: null
			}, 			
			addModal: false,
			editModal: false,
			isAdding: false,
			roles: [],
			editData: {
				tagName: '',

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

		//const [res, resRole] = await Promise.all([
		//	this.callApi('get', 'app/get_users'), 
		//	this.callApi('get', 'app/get_roles')
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
	
	watch : {

	},
	
	methods: {
		async addTag() {
			const res = await this.callApi('post', '/api/create_tag', this.data);
			if (res.status===201) {
				this.tags.unshift(res.data);
				this.s('Tag has been added successfully!');
				this.addModal = false;
				this.data.tagName = '';
			} else {
				if (res.status==422) {
					if (res.data.errors.tagName) {
						this.e(res.data.errors.tagName[0]);
					}					
				} else {
					this.swr();
				}				
			}
		},
		async editTag(){
			if (this.editData.tagName.trim()=='') 
				return this.e('Tag name is required');
			const res = await this.callApi('post', '/api/edit_tag', this.editData);
			if (res.status===200) {
				this.tags[this.index].tagName = this.editData.tagName;
				this.s('Tag has been edited successfully!');
				this.editModal = false;			
			} else {
				if (res.status==422) {
					if (res.data.errors.tagName) {
						this.e(res.data.errors.tagName[0]);
					}					
				} else {
					this.swr();
				}				
			}
		},
		showEditModal(tag, index) {
			let obj = {
				id : tag.id, 
				tagName : tag.tagName,
			}
			this.editData = obj;
			this.editModal = true;
			this.index = index;
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
			console.log("tags.vue showDeletingModal function is called...")

			console.log('delete method called');
		},
		showEditModal(tag, index){
			let obj = {
				id : tag.id, 
				tagName : tag.tagName
			}
			this.editData = obj;
			this.editModal = true;
			this.index = index;
		},
		
		handleSuccess (res, file) {

		},
	},
};
</script>

<style scoped>
@import "../../css/fullstack.css";
</style>
