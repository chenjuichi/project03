import { isLoggedIn, logOut, xsrfToken } from "./utils/auth";

export default {
/* == vuex state == */
	state: {
        enableShowImage: false,

		lastSearch: {
			from: null,
			to: null,
		},
		basket: {
			items: []
		},
		isLoggedIn: false,
        user: {},
        token: {},
        userWithRoles: {},
		isPanelOpen: false,
		isLoginOrRegisterPanel: false,	//false:Login, true:Register
		immediate: false,
        allUsers: [],
        allUsersAndUserRoles: [],
    },	//end state

/* == vuex actions == */
	actions: {
        setEnableShowImage({ commit }, payload) {
            commit('SET_ENABLE_SHOW_IMAGE', payload);
        },

		setLastSearch({commit}, payload) {
			commit('SET_LAST_SEARCH', payload);
			localStorage.setItem('lastSearch', JSON.stringify(payload));
		},

		loadStoredState({commit}) {
			const lastSearch = localStorage.getItem('lastSearch');

			if (lastSearch) {
				commit('SET_LAST_SEARCH', JSON.parse(lastSearch));
			}

			const basket = localStorage.getItem('basket');
			console.log("localStorage.getItem: ", basket);

			if (basket) {
				var obj = JSON.parse(basket);
				console.log("obj: ", obj);

				let currentObjs = [];
      			for (let i = 0; i < obj.length; i++) {
      				if (Object.keys(obj[i]).length !== 0) {
      					currentObjs.push(obj[i]);
      				}
      			}
				console.log("currentObjs: ", currentObjs);
				commit('SET_BASKET', currentObjs);
			}

			commit('SET_LOGGED_IN', isLoggedIn());
		},

  		async loadedAllUsers({ commit }) {
			try {
				commit('SET_IMMEDIATE', false);

				const temp = (await axios.get("/api/admin/users")).data;
				let allUsers = temp.users;
				commit('SET_LOADED_ALL_USERS', allUsers);

				commit('SET_IMMEDIATE', true);
			}
			catch (error) {
				console.log("team member loading is error: ", error.response.status);
			}
  		},

  		async loadedAllUsersWithRoles({ commit }) {
			try {
				commit('SET_IMMEDIATE', false);

				const temp = (await axios.get("/api/customer/admin/users")).data;
				let allUsersAndUserRoles = temp.allUsersAndUserRoles;
				commit('SET_LOADED_allUsersAndUserRoles', allUsersAndUserRoles);

				commit('SET_IMMEDIATE', true);
			}
			catch (error) {
				console.log("allUsersAndUserRoles function loading is error: ", error.response.status);
			}
  		},

		addToBasket({commit, state}, payload) {
	      	commit('addToBasket', payload);
			localStorage.setItem('basket', JSON.stringify(state.basket.items));
		},

		removeFromBasket({commit, state}, payload) {
	      	commit('removeFromBasket', payload);
			localStorage.setItem('basket', JSON.stringify(state.basket.items));
		},

		clearBasket({commit, state}, payload) {
	      	commit('SET_BASKET', { item: [] });
			localStorage.setItem('basket', JSON.stringify(state.basket.items));
		},

		async loadUser({ commit,dispatch }) {
			if (isLoggedIn()) {
				try {
					const user = (await axios.get("/user")).data;
					console.log("loggedIn user: ", user);

					commit('SET_USER', user);
					commit('SET_LOGGED_IN', true);
				}
				catch (error) {
					dispatch("logout");
				}
			}
		},
/*
		async loadUserWithRoles({ commit,dispatch }) {
			if (isLoggedIn()) {
				try {
                    //commit('SET_IMMEDIATE', false);
                    const userWithRoles = (await axios.get("/api/customer/roles/2")).data;

                    console.log("1. loggedIn user and roles: ", userWithRoles.userAndUserRoles);
                    const rolesList = userWithRoles.userAndUserRoles.roles.map(item => Object.values(item)[2]);    //get role name
                    userWithRoles.userAndUserRoles.roles = rolesList;
                    //console.log("loggedIn user'roles: ", userWithRoles.userAndUserRoles.roles);
                    //console.log("2. loggedIn user and roles: ", userWithRoles.userAndUserRoles);

					commit('SET_UserWithRoles', userWithRoles.userAndUserRoles);
                    commit('SET_LOGGED_IN', true);

                    //commit('SET_IMMEDIATE', true);
                    //console.log("2. loggedIn user and roles: ", userWithRoles.userAndUserRoles);

				}
				catch (error) {
					dispatch("logout");
				}
			}
		},
*/
        loadUserToken({commit,dispatch}, payload) {
            if (isLoggedIn()) {
                const lastUserToken = xsrfToken();

                if (lastUserToken) {
                    console.log("localStorage.getItem XSRF-TOKEN: ", lastUserToken);
                    commit('SET_LAST_USER_TOKEN', JSON.parse(lastUserToken));
                }
            }
        },

		async loadUserWithRoles({commit,dispatch}, payload) {
			if (isLoggedIn()) {
				try {
                    const userWithRoles = (await axios.post("/api/customer/rolesList",
                    {
						email: payload.email,
						password: payload.password
					})).data;

                    console.log("loggedIn user's roles: ", userWithRoles.userAndUserRoles);
                    const rolesList = userWithRoles.userAndUserRoles.roles.map(item => Object.values(item)[2]);    //get role name
                    userWithRoles.userAndUserRoles.roles = rolesList;

					//commit('SET_UserWithRoles', userWithRoles.userAndUserRoles);
					commit('SET_USER', userWithRoles.userAndUserRoles);
                    commit('SET_LOGGED_IN', true);
				}
				catch (error) {
					dispatch("logout");
				}
			}
		},


		logout({ commit }) {
			commit('SET_USER', {});
			commit('SET_LOGGED_IN', false);
			logOut();
		},

		panelSwitch({ commit }, payload) {
			console.log("setPanel action-burger is: ", payload);
			commit('setPanel', payload);
		},

		slideSwitch({ commit }, payload) {
			console.log("setSlide is: ", payload);
			commit('setSlide', payload);
		},
    },	//end actions

/* == vuex mutations == */
	mutations: {
        SET_ENABLE_SHOW_IMAGE(state, payload) {
            state.enableShowImage = payload;
        },

		SET_LAST_SEARCH(state, payload) {
			state.lastSearch = payload;
        },

        SET_LAST_USER_TOKEN(state, payload) {
			state.token = payload;
        },

		SET_BASKET(state, payload) {
			state.basket.items = payload;
        },

		SET_LOGGED_IN(state, payload) {
			state.isLoggedIn = payload;
        },

		SET_IMMEDIATE(state, payload) {
			state.immediate = payload;
		},

        SET_LOADED_ALL_USERS(state, payload) {
            state.allUsers = payload.slice(0);
        },

        SET_LOADED_allUsersAndUserRoles(state, payload) {
            state.allUsersAndUserRoles = payload.slice(0);
        },

		SET_USER(state, payload) {
			state.user = payload;
		},

		SET_UserWithRoles(state, payload) {
			state.userWithRoles = payload;
		},

		addToBasket(state, payload) {
			state.basket.items.push(payload);	//Object array keys is the following:
												// id:
												// title:
												// description:
												// date_from:
												// date_to:
												// price_breakdown:
												// price_breakdown_total:
		},

		removeFromBasket(state, payload) {
			state.basket.items = state.basket.items.filter(item => item.id !== payload);
		},

		setUserDataReady(state, payload) {
			state.userDataReady = payload;
		},

		setPanel(state, payload) {
			state.isPanelOpen = payload;
		},

		setSlide(state, payload) {
			state.isLoginOrRegisterPanel = payload;
		},
	},	//end mutations
/* == vuex getters == */
	getters: {
        getEnableShowImage: (state) => state.enableShowImage,

		itemsInBasket: (state) => state.basket.items.length,

		inBasketAlready(state) {
			return function(id) {
				return state.basket.items.reduce(
					(result, item) => result || item.id === id,
					false
				);
			}
	  	},

	  	allUsers(state) {
    		return state.allUsers;
	  	},

	  	currentLoginUserData(state) {
    		return state.user;
          },

        currentLoginUserRoles(state) {
//            console.log("getters for roles: ", state.userWithRoles.roles)
//            return state.userWithRoles.roles;
            console.log("getters for roles: ", state.user.roles)
            return state.user.roles;
        },

        currentLoginUserToken(state) {
    		return state.token;
        },
	},	//end getters
};

