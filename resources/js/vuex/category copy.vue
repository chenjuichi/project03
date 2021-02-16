<template>
    <div>
        <div class="content">
            <div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">		
					<p class="_title0">
						Category
						<Button @click="addModal=true"><Icon type="md-add" size="small" />&nbsp;Add Category</Button>
					</p>         		
					
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
								<tr v-for="(category, i) in categoryLists" :key="i">
									<td>{{ category.id }}</td>
									<td class="_table_name">{{ category.categoryName }}</td>
									<td>{{ category.created_at }}</td>
									<td>
										<Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
										<Button type="error" size="small" @click="showDeletingModal(category, i)"  :loading="category.isDeleting">Delete</Button>
									</td>
								</tr>
							<!--</div>-->
								<!-- ITEMS -->
						</table>
					</div>
				</div>

				<!-- category adding modal -->
				<Modal v-model="addModal" title="Add category" :mask-closable="false" :closable="false">
					<Input v-model="data.categoryName" placeholder="Add category name" />
					
					<div class="space"></div>
					<Upload
						ref="uploads"						
						type="drag"
						:headers="{
							'x-csrf-token' : token,
							'X-Requested-With' : 'XMLHttpRequest',
							'content-type': 'multipart/form-data',
						}"
						action="/api/upload"

						:on-success="handleSuccess"
						:on-error="handleError"
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

					<div class="demo-upload-list" v-if="data.iconImage">
						<img :src="'/public/upload/${data.iconImage}'" />
						<div class="demo-upload-list-cover">
							<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
						</div>						
          			</div>					

					<div slot="footer">
						<Button 
							type="default" 
							@click="addModal=false">
							Close
						</Button>
						<Button 
							type="primary" 
							@click="addCategory"
							:disabled="isAdding" 
							:loading="isAdding">
							{{isAdding ? 'Adding..' : 'Add Category'}}
						</Button>						
					</div>
				</Modal>
				<!-- category adding modal -->				

				<!-- category editing modal -->
				<Modal v-model="editModal" title="Edit Category" :mask-closable="false" :closable="false">
					<Input v-model="editData.categoryName" placeholder="Edit category name" />
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Category'}}</Button>
					</div>
				</Modal>
				<!-- category editing modal -->

				<!-- delete alert modal -->
				<Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation!</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete category?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">
							Delete
						</Button>
					</div>
				</Modal>
				<!-- category delete alert modal -->
            </div>
        </div>        
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
//import deleteModal from '../admin/deleteModal';
import Cookies from 'js-cookie';

export default {
	components: {
		//deleteModal,		
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
				iconImage: "",
				categoryName: "",
			},			
			addModal: false,
			editModal: false,
			isAdding: false,
			categoryLists: [],
			editData: {
				iconImage: "",
				categoryName: "",
			},
			index: -1,
			showDeleteModal: false,
			isDeleting: false,
			deleteItem: {}, 
			deletingIndex: -1,
			token: "", 
			
			isIconImageNew: false,
      		isEditingItem: false,
		};
	},
	
	async created() {
		//this.token = Cookies.get('XSRF-TOKEN');		
		this.token = window.Laravel.csrfToken;		
		//console.log("token: ", this.token);

		const res = await this.callApi('get', '/api/get_category');
		if (res.status === 200) {
			this.categoryLists = res.data;
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
		...mapGetters({
            getDeleteModalObj: "getDeleteModalObj",
		}),
		somethingElse() {
			return 1+2;
		},
		users() {
			const nameList = Object.values(this.allUsers).map(item => item.name);
			return nameList;
        },
	},

	watch : {
		getDeleteModalObj(obj) {
			if (obj.isDeleted) {
				this.categoryLists.splice(obj.deletingIndex, 1);
			}
		}
	},	//end watch

	methods: {
		async addCategory() {
			//if (this.data.categoryName.trim()=='') 
			//	return this.e('Category name is required');
			const res = await this.callApi('post', '/api/create_category', this.data);
			if (res.status===201) {
				this.categoryLists.unshift(res.data);
				this.s('Category has been added successfully!');
				this.addModal = false;
				this.data.CategoryName = '';
			} else {
				if (res.status==422) {
					if (res.data.errors.categoryName) {
						this.e(res.data.errors.categoryName[0]);
					}					
				} else {
					this.swr();
				}				
			}
		},
		async editCategory(){
			if (this.editData.categoryName.trim()=='') 
				return this.e('Category name is required');
			const res = await this.callApi('post', '/api/edit_category', this.editData);
			if (res.status===200) {
				this.categoryLists[this.index].categoryName = this.editData.categoryName;
				this.s('Category has been edited successfully!');
				this.editModal = false;			
			} else {
				if (res.status==422) {
					if (res.data.errors.categoryName) {
						this.e(res.data.errors.categoryName[0]);
					}					
				} else {
					this.swr();
				}				
			}
		},
		async deleteCategory(){
			this.isDeleting = true;
			const res = await this.callApi('post', '/api/delete_category', this.deleteItem)
			if (res.status===200) {
				this.tags.splice(this.deletingIndex, 1);
				this.s('Category has been deleted successfully!');
			} else {
				this.swr();
			}
			this.isDeleting = false;
			this.showDeleteModal = false;
		}, 		

		showDeletingModal(category, i) {
			this.deleteItem = category;
			this.deletingIndex = i;
			this.showDeleteModal = true;
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
		showEditModal(category, index){
			//let obj = {
			//	id : tag.id, 
			//	tagName : tag.tagName
			//}
			this.editData = category;
			this.editModal = true;
			this.index = index;
			this.isEditingItem = true;
			console.log("showEditModal function.....isEditingItem: ", this.isEditingItem);
		},

		closeEditModal() {
			this.isEditingItem = false;
			this.editModal = false;
			console.log("closeEditModal function.....isEditingItem: ", this.isEditingItem);
		},

		handleSuccess(res, file) {
			/*
			console.log("handleSuccess return res: ", res);
			
			res = '/public/upload/' + res;
			//res = res.file;
			if (this.isEditingItem) {
				console.log("inside");
				return (this.editData.iconImage = res);
			}
			console.log(res);
			*/
			//let resFile = '/public/upload/' + res;
			//this.data.iconImage = resFile;			
			this.data.iconImage = res;			
		},
		handleError(res, file) {
			//console.log("handleError res: ", res)
			//console.log("handleError file: ", file)
			//console.log("handleError error: ", file.errors, file.errors.file)
			let errorString = file.errors.file.length ? file.errors.file[0] : "Something went wrong!"
			//console.log("handleError: ", errorString);
			this.$Notice.warning({
				title: "The file format is incorrect",
				desc: errorString,
			});
		},
		handleFormatError (file) {
			let errorString = 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: errorString,
			});
		},
		handleMaxSize (file) {
			this.$Notice.warning({
				title: "Exceeding file size limit",
				desc: "File  " + file.name + " is too large, no more than 2M."
            });		
		},

		async deleteImage(isAdd = true) {
			let image;
			if (!isAdd) {
				// for editing....
				this.isIconImageNew = true;
				image = this.editData.iconImage;
				this.editData.iconImage = "";
				this.$refs.editDataUploads.clearFiles();
			} else {
				image = this.data.iconImage;
				this.data.iconImage = "";
				this.$refs.uploads.clearFiles();
			}

			const res = await this.callApi("post", "/api/delete_image", {
				imageName: image
			});
			if (res.status != 200) {
				this.data.iconImage = image;
				this.swr();
			}
		},		
	},	//end methods
};
</script>

<style scoped>
@import "../../css/fullstack.css";
</style>
