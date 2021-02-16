<template>
    <div>
        <div class="content">
            <div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">		
					<p class="_title0">
						Tags
						<Button @click="addModal=true"><Icon type="md-add" size="small" />&nbsp;Add tag</Button>
					</p>         		
					
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
							<!--<div v-if="tags.length" class="_table_vif">-->								
								<tr v-for="(tag, i) in tags" :key="i">
									<td>{{ tag.id }}</td>
									<td class="_table_name">{{ tag.tagName }}</td>
									<td>{{ tag.created_at }}</td>
									<td>
										<Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
										<Button type="error" size="small" @click="showDeletingModal(tag, i)"  :loading="tag.isDeleting">Delete</Button>
									</td>
								</tr>
							<!--</div>-->
								<!-- ITEMS -->
						</table>
					</div>
				</div>

				<!-- tag adding modal -->
				<!--
				<Modal 
					v-model="addModal" 
					title="Add tag" 
					:mask-closable="false" 
					:closable="false">
					<Input v-model="data.tagName" placeholder="Add tag name" />
					<div slot="footer">
						<Button 
							type="default" 
							@click="addModal=false">
							Close
						</Button>
						<Button 
							type="primary" 
							@click="addTag"
							:disabled="isAdding" 
							:loading="isAdding">
							{{isAdding ? 'Adding..' : 'Add tag'}}
						</Button>						
					</div>
				</Modal>
				-->
				<!-- tag adding modal -->

				<!-- tag adding modal for category -->
				<Modal 
					v-model="addModal" 
					title="Add category" 
					:mask-closable="false" 
					:closable="false">
					<Input v-model="data.tagName" placeholder="Add category name" />
				<!--	
					<div class="space"></div>
					<Upload
						
						type="drag"
						:headers="{'x-csrf-token' : token}"
						action="/api/upload"

						:on-success="handleSuccess"
						:format="['jpg','jpeg','png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"						
						>
						<div style="padding: 20px 0">
							<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
							<p>Click or drag files here to upload</p>
						</div>
					</Upload>					
				-->
					<div slot="footer">
						<Button 
							type="default" 
							@click="addModal=false">
							Close
						</Button>
						<Button 
							type="primary" 
							@click="addTag"
							:disabled="isAdding" 
							:loading="isAdding">
							{{isAdding ? 'Adding..' : 'Add tag'}}
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

				<!-- delete alert modal -->
				<!--
				<Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation!</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete tag?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">
							Delete
						</Button>
					</div>
				</Modal>
				-->
				<!-- tag delete alert modal -->
				<delete-modal></delete-modal>
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
	
    //directives: {
    //  clickOutside: vClickOutside.directive
	//},
	
    mounted() {
        //
	},
	
	data() {
		return {
			data: {
				tagName: '',

			},			
			addModal: false,
			editModal: false,
			isAdding: false,
			tags: [],
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
		//this.token = Cookies.get('XSRF-TOKEN');		
		this.token = window.Laravel.csrfToken;		
		//console.log("token: ", this.token);

		const res = await this.callApi('get', '/api/get_tags');
		if (res.status === 200) {
			this.tags = res.data;
		} else {
			this.swr();
		}
	},

	computed: {
		...mapState({	//Spread in object literals
			lastSearchComputed: "lastSearch",
			user: "user",
			isLoggedIn: "isLoggedIn",
			allUsers: "allUsers",
		}),
		/*
		...mapGetters({
            getDeleteModalObj: "getDeleteModalObj",
		}),
		*/
		somethingElse() {
			return 1+2;
		},
		users() {
			const nameList = Object.values(this.allUsers).map(item => item.name);
			return nameList;
        },
	},
	/*
	watch : {
		getDeleteModalObj(obj) {
			console.log("watch: ", obj);
			if (obj.isDeleted) {
			console.log("inside if...");
				this.tags.splice(obj.deletingIndex, 1);
			}
		}
	},
	*/
	methods: {
		async addTag() {
			//if (this.data.tagName.trim()=='') 
			//	return this.e('Tag name is required');
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
			//this.deleteItem = tag;
			//this.deletingIndex = i;
			//this.showDeleteModal = true;
			/*
			const deleteModalObj  =  {
				showDeleteModal: true, 
				deleteUrl : '/api/delete_tag', 
				data : tag, 
				deletingIndex: i, 
				isDeleted : false,
			}
			*/
			//this.$store.commit('setDeletingModalObj', deleteModalObj);
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
