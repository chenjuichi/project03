<template>
    <v-app id="inspire">
        <v-card
            color="blue-grey darken-1"
            dark
            :loading="isUpdating">
            <template v-slot:progress>
                <v-progress-linear
                    absolute
                    color="green lighten-3"
                    height="4"
                    indeterminate>
                </v-progress-linear>
            </template>
            <v-row>
                <v-col class="text-right" cols="12">
                    <v-menu bottom left transition="slide-y-transition">
                        <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item @click="isUpdating = true">
                                <v-list-item-action>
                                    <v-icon>mdi-settings</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        Update
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
                <v-row class="pa-4" align="center" justify="center">
                    <v-col class="text-center">
                        <h3 class="headline">{{ name }}</h3>
                        <span class="grey--text text--lighten-1">
                            {{ title }}
                        </span>
                    </v-col>
                </v-row>
            </v-row>
            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="name"
                                :disabled="isUpdating"
                                filled
                                color="blue-grey lighten-2"
                                label="Name">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="title"
                                :disabled="isUpdating"
                                filled
                                color="blue-grey lighten-2"
                                label="Title">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-autocomplete
                                v-model="friends"
                                :disabled="isUpdating"
                                :items="people"
                                solo
                                outlined
                                chips
                                color="blue-grey lighten-2"
                                label="Select"
                                item-text="name"
                                item-value="name"
                                multiple>
                                <template v-slot:selection="data">
                                    <v-chip
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        close
                                        @click="data.select"
                                        @click:close="remove(data.item)">
                                        <v-avatar left>
                                            <v-img :src="data.item.avatar"></v-img>
                                        </v-avatar>
                                        {{ data.item.name }}
                                    </v-chip>
                                </template>
                                <template v-slot:item="data">
                                    <template v-if="typeof data.item !== 'object'">
                                        <v-list-item-content v-text="data.item"></v-list-item-content>
                                    </template>
                                    <template v-else>
                                        <v-list-item-avatar>
                                            <img :src="data.item.avatar">
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                            <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </template>
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
            <v-divider></v-divider>
            <v-card-actions>
                <v-switch
                v-model="autoUpdate"
                :disabled="isUpdating"
                class="mt-0"
                color="green lighten-2"
                hide-details
                label="Auto Update"
                ></v-switch>
                <v-spacer></v-spacer>
                <v-btn
                :disabled="autoUpdate"
                :loading="isUpdating"
                color="blue-grey darken-3"
                depressed
                @click="isUpdating = true"
                >
                <v-icon left>mdi-update</v-icon>
                Update Now
                </v-btn>
            </v-card-actions>
        </v-card>
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
        const srcs = {
            1: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
            2: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
            3: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
            4: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
            5: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
        }

		return {
		    loading: false,

            isUpdating: false,
            autoUpdate: true,
            friends: ['Sandra Adams', 'Britta Holt'],
      
            name: 'Midnight Crew',
            people: [
                { header: 'Group 1' },
                { name: 'Sandra Adams', group: 'Group 1', avatar: srcs[1] },
                { name: 'Ali Connors', group: 'Group 1', avatar: srcs[2] },
                { name: 'Trevor Hansen', group: 'Group 1', avatar: srcs[3] },
                { name: 'Tucker Smith', group: 'Group 1', avatar: srcs[2] },
                { divider: true },
                { header: 'Group 2' },
                { name: 'Britta Holt', group: 'Group 2', avatar: srcs[4] },
                { name: 'Jane Smith ', group: 'Group 2', avatar: srcs[5] },
                { name: 'John Smith', group: 'Group 2', avatar: srcs[1] },
                { name: 'Sandra Williams', group: 'Group 2', avatar: srcs[3] },
            ],
            title: 'The summer breeze',
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

        console.log("created:ListRoles....");
    },

    methods: {         
        remove (item) {
            const index = this.friends.indexOf(item.name)
            if (index >= 0) 
                this.friends.splice(index, 1)
        },      
    },
}
</script>

<style scoped>

</style>
