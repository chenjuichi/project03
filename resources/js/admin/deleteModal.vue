<template>
    <div>
        <!-- delete alert modal -->
        <Modal :value="getDeleteModalObj.showDeleteModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation!</span>
            </p>
            <div style="text-align:center">
                <p>{{getDeleteModalObj.msg}}</p>
            </div>
            <div slot="footer">
                <Button type="default" size="large" @click="closeModal">
                    Close
                </Button>
                <Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">
                    Delete
                </Button>
            </div>
        </Modal>
    </div>
</template>


<script>
import { mapState, mapGetters } from 'vuex';

export default {
	components: {
        //
    },
    //directives: {
    //  clickOutside: vClickOutside.directive
    //},
    mounted() {
        //
    },
	data() {
		return {
            isDeleting: false,
        };
    },
	created() {
	    //
	},
	computed: {
		...mapState({	//Spread in object literals
			lastSearchComputed: "lastSearch",
			user: "user",
			isLoggedIn: "isLoggedIn",
            allUsers: "allUsers",
		}),
		...mapGetters({
			itemsInBasket: "itemsInBasket",
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
	methods: {
        async deleteTag() {
            this.$store.dispatch('setDeleteModal', true);
/*
            this.isDeleting = true;
            const res = await this.callApi("post", getDeleteModalObj.deleteUrl, getDeleteModalObj.data);
            console.log(res.data);
            if (res.status === 200) {
                this.tags.splice(this.deletingIndex, 1);
                this.s("Tag has been deleted successfully!");
            } else {
                this.swr();
            }
            this.isDeleting = false;
*/            
        }
    },
};
</script>

