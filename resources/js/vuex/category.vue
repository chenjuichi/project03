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
								<th>Icon image</th>
								<th>Category Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
								<tr v-for="(category, i) in categoryLists" :key="i">
									<td>{{ category.id }}</td>
									<td class="table_image">
										<img :src="category.iconImage" />
									</td>
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
						<img :src="data.iconImage" />
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
				<Modal 
					v-model="editModal" 
					title="Edit Category" 
					:mask-closable="false" 
					:closable="false">
					
					<Input v-model="editData.categoryName" placeholder="Edit category name" />

					<div class="space"></div>

					<Upload
						v-show="isIconImageNew"
						ref="editDataUploads"						
						type="drag"
						:headers="{
							'x-csrf-token' : token,
							'X-Requested-With' : 'XMLHttpRequest',							
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

					<div class="demo-upload-list" v-if="editData.iconImage">
						<img :src="editData.iconImage" />
						<div class="demo-upload-list-cover">
							<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
						</div>													
					</div>

					<div slot="footer">
						<Button type="default" @click="closeEditModal=false">Close</Button>
						<Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Category'}}</Button>
					</div>
				</Modal>
				<!-- category editing modal -->

				<!-- delete alert modal -->
				<!--
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
				-->
				<!-- category delete alert modal -->
				<delete-modal></delete-modal>
            </div>
        </div>        
    </div>
</template>

<script>
//import PostCreate from './PostCreate';

import { mapState, mapGetters } from 'vuex';
import deleteModal from './deleteModal';
import Cookies from 'js-cookie';
import DeleteModal from '../admin/deleteModal.vue';

export default {
	components: {
		deleteModal
//DeleteModal,
		//PostCreate		
	},
	
    //directives: {
    //  clickOutside: vClickOutside.directive
	//},
	
    mounted() {
        //this.imgurLink = window.imgurLink;
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

			websiteSettings: [],
			  
            image: '',
            file_name: '',
			csrf: '',		  

			imgurLink: [],

			//image: null,
    		fs: {
      			name: '', 			// input的圖檔名稱
      			thumbnail: null, 	// input的圖片縮圖
      			size: null 			// input的圖片大小
			},
			//title: '', 				// 圖片標題
			//des: 'hello',				// 圖片描述
			//apiKey: 'e6088d4d7383c59',
    
			imagepreview: null,

			//csrf: document.getElementsByTagName('input').item(name="_token").value,


		};
	},
	
	async created() {
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
			if (obj.isDeleted) {
				this.categoryLists.splice(obj.deletingIndex, 1);
			}
		}
	},	//end watch
*/
	methods: {
		async addCategory() {
			if (this.data.categoryName.trim()=='')
				return this.e('Category name is required');
			if (this.data.iconImage.trim()=='')
				return this.e('Icon image is required');

			console.log("addCategory: ", this.data.iconImage);

			const res = await this.callApi('post', '/api/create_category', this.data);
			if (res.status===201) {
				console.log("res.data: ", res.data);
				this.categoryLists.unshift(res.data);
				this.s('Category has been added successfully!');
				this.addModal = false;
				this.data.CategoryName = '';
			} else {
				if (res.status==422) {
					if (res.data.errors.categoryName) {
						this.e(res.data.errors.categoryName[0]);
					}					
					if (res.data.errors.iconImage) {
						this.e(res.data.errors.iconImage[0]);
					}					
				} else {
					this.swr();
				}				
			}
		},
		async editCategory(){
			if (this.editData.categoryName.trim()=='') 
				return this.e('Category name is required');
			if (this.editData.iconImage.trim()=='')
				return this.e('Icon image is required');

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
					if (res.data.errors.iconImage) {
						this.e(res.data.errors.iconImage[0]);
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
			const deleteModalObj  =  {
				showDeleteModal: true, 
				deleteUrl : '/api/delete_category', 
				data : category, 
				deletingIndex: i, 
				isDeleted : false,
			}
            this.$store.dispatch('setDeletingModalObj', deleteModalObj);
			console.log("category.vue showDeletingModal function is called...")
			//this.deleteItem = category;
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
		showEditModal(category, index) {
			console.log("showEditModal return category: ", category);
			console.log("showEditModal return index: ", index);

			this.editData = category;				
			//this.editData.iconImage = category.iconImage;				
			//this.editData.categoryName = category.categoryName;

			this.editModal = true;
			this.index = index;
			this.isEditingItem = true;
		},

		closeEditModal() {
			this.isEditingItem = false;
			this.editModal = false;
		},

		handleSuccess(res, file) {			
			console.log("handleSuccess return: ", res);
		
			if (this.isEditingItem) {
				console.log("inside");
				return (this.editData.iconImage = res);
			}
			console.log("handleSuccess post: ", res);
			this.data.iconImage = res;
		},

getProfilePhoto(){
	let photo = "/public/14625.jpg";
	console.log("1...photo is on public");

    if (this.data.iconImage) {
        if (this.data.iconImage.indexOf('base64') != -1) {
			photo = this.data.iconImage;
			console.log("2...photo is ok");
        } else {
            photo = 'storage/app/public/14625.jpg';
			console.log("2...photo is on storage");
        }
    }
    return photo;
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
			console.log("deleteImage, step1: ", this.data.iconImage);

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
			console.log("deleteImage, step2: ", image);
/*
			const res = await this.callApi("post", "/api/delete_image", {
				imageName: image
			});

			if (res.status != 200) {
				this.data.iconImage = image;
				this.swr();
			}
*/			
		},

        onFileSelected(e) {
			this.image = e.target.files[0];	// input type="file" 的值
			/*
      		this.fs.name = this.image.name; // input的圖檔名稱
      		this.fs.size = Math.floor(this.image.size * 0.001) + 'KB'; // input的圖片大小
      		this.fs.thumbnail = window.URL.createObjectURL(this.image); // input的圖片縮圖			  
			this.title = this.fs.name; // 預設 input 的圖檔名稱為圖片上傳時的圖片標題
			console.log("thumbnail: ", this.fs.thumbnail);
			*/
			let reader = new FileReader();
            reader.readAsDataURL(this.image);
            reader.onload = e => {
            	this.imagepreview = e.target.result;
            };
		},
		
		onFileChange(e) {
			let file    = document.querySelector('input[type=file]').files[0];
			let reader  = new FileReader();
			let vm =this;
			//vm.file_name=file;
			reader.addEventListener("load", function () {
				//vm.image = reader.result;
				vm.data.iconImage = reader.result;
			}, false);

			if (file) {
				reader.readAsDataURL(file);
			}
			//vm.file_name=file;
			//console.log(vm.file_name);
			//console.log(this.image);
			console.log(vm.data.iconImage);

		},

		onSubmine() {

		},
		onFormSubmit(e) {
			e.preventDefault();
			let currentObj = this;

			const config = {
				headers: { 'content-type': 'multipart/form-data' }
			}

			let formData = new FormData();
			formData.append('file', this.image);

			axios.post('/api/upload', formData, config)
			.then(function (response) {
				consol.log("response...: ", response);
			})
			.catch(function (error) {
				//currentObj.output = error;
			});
		}		

	},	//end methods
};
</script>

<style scoped>
@import "../../css/fullstack.css";

.btn.r {
  box-shadow:0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.2), 0 20px 20px rgba(0,0,0,.15);
}


</style>
