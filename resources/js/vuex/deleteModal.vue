<template>
    <div>
        <!-- delete alert modal -->
        <Modal 
			:value="getDeleteModalObj.showDeleteModal"
			:mask-closable="false"
			:closable="false" 
			width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation!</span>
        </p>
        <div style="text-align:center">
            <p>Are you sure you want to delete category?</p>
        </div>
        <div slot="footer">
            <Button type="default" size="large" @click="closeModal">
                Close
            </Button>
            <Button type="error" size="large" :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">
                Delete
            </Button>
        </div>
        </Modal>
        <!-- category delete alert modal -->
    </div>
</template>

<script>

import { mapState, mapGetters } from 'vuex';

export default {
	components: {
	
	},
	
    mounted() {

    },
	
	data() {
		return {
            isDeleting: false,

		};
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

	},

	methods: {
		async deleteTag(){
            //this.$store.dispatch('setDeleteModal', false);            
			this.isDeleting = true;
			const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
			if (res.status===200) {
				//this.tags.splice(this.deletingIndex, 1);
				this.s('Tag has been deleted successfully!');
            	this.$store.dispatch('setDeleteModal', true);
			} else {
				this.swr();
            	this.$store.dispatch('setDeleteModal', false);
			}
			
			this.isDeleting = false;            
		}, 
        closeModal(){
            this.$store.dispatch('setDeleteModal', false)
        }	

	},	//end methods
};
</script>
