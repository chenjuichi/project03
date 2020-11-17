<template>
    <v-app>
        <v-main>
            <v-container id="signinup-form" class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col class="col-12 col-sm-8 col-md-8 col-lg-8">
                        <v-card class="evelation-12 card">
                            <v-window v-model="step">
                                <!--SignIn-->
                                <v-window-item :value="1">
                                <v-row>
                                    <v-col class="col-12 col-md-8 col-lg-8 pt-6 pb-6">
                                        <v-card-text class="mt-12">
                                            <h1 class="text-center display-2 mb-10">
                                                Sign in
                                            </h1>
                                            <div class="text-center mt-4">
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-facebook</v-icon>
                                                </v-btn>
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-google-plus</v-icon>
                                                </v-btn>
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-linkedin</v-icon>
                                                </v-btn>
                                            </div>
                                            <h4 class="text-center mt-4 ml-4">
                                                Enter your email for registration
                                            </h4>
                                            <v-form>
                                                <v-text-field
                                                    id="loginEmail"
                                                    label="Email"
                                                    name="Email"
                                                    prepend-icon="mdi-email"
                                                    type="email"
                                                    color="teal accent-3"
                                                    v-model='loginEmail' />

                                                <v-text-field
                                                    id="loginPassword"
                                                    label="Password"
                                                    name="Password"
                                                    color="teal accent-3"
                                                    prepend-icon="mdi-lock"
                                                    :append-icon="eyeShow ? 'mdi-eye' : 'mdi-eye-off'"
                                                    @click:append="() => (eyeShow = !eyeShow)"
                                                    :type="eyeShow ? 'password' : 'text'"
                                                    v-model='loginPassword' />
                                            </v-form>
                                            <h3 class="text-center mt-3">
                                                Forget your email?
                                            </h3>
                                        </v-card-text>
                                        <div class="text-center mt-3">
                                            <v-btn
                                                rounded
                                                color="teal accent-3"
                                                dark
                                                @click.prevent="signin">
                                                SIGN IN
                                            </v-btn>
                                        </div>
                                    </v-col>
                                    <!--<v-col class="col-12 col-md-4 col-lg-4 teal accent-3 vcenter">-->
                                    <v-col class="col-12 col-md-4 col-lg-4 teal accent-3">
                                        <v-card-text class="white-text mt-12">
                                            <h1 class="text-center display-2">
                                                Hello, Friends!
                                            </h1>
                                            <h5 class="text-center">
                                                Enter personal information and start contacting us!
                                            </h5>
                                        </v-card-text>
                                        <div class="text-center">
                                            <v-btn rounded outlined="" dark @click="step++">
                                                SIGN UP
                                            </v-btn>
                                        </div>
                                    </v-col>
                                </v-row>
                                </v-window-item>

                                <!--SignUp-->
                                <v-window-item :value="2">
                                <v-row class="fill-height">
                                    <!--<v-col class="col-12 col-md-4 col-lg-4 teal accent-3 vcenter">-->
                                    <v-col class="col-12 col-md-4 col-lg-4 teal accent-3">
                                        <v-card-text class="mt-12">
                                            <h1 class="text-center display-1">
                                                Welcome Back!
                                            </h1>
                                            <h5 class="text-center">
                                                To keep connected with us. Please login with your personal information!
                                            </h5>
                                        </v-card-text>
                                        <div class="text-center">
                                            <v-btn rounded outlined="" dark @click="step--">
                                                SIGN IN
                                            </v-btn>
                                        </div>
                                    </v-col>
                                    <v-col class="col-12 col-md-8 col-lg-8">
                                        <v-card-text class="mt-12">
                                            <h1 class="text-center display-2 teal--text text--accent-3 mb-10">
                                                Create Account
                                            </h1>
                                            <div class="text-center mt-4">
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-facebook</v-icon>
                                                </v-btn>
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-google-plus</v-icon>
                                                </v-btn>
                                                <v-btn class="mx-2" fab color="black" outlined>
                                                    <v-icon>fab fa-linkedin</v-icon>
                                                </v-btn>
                                            </div>
                                            <h4 class="text-center mlt-4">
                                                Enter your email for registration
                                            </h4>
                                            <v-form>
                                                <v-text-field
                                                    id="registerName"
                                                    label="Name"
                                                    name="Name"
                                                    prepend-icon="mdi-account"
                                                    type="text"
                                                    color="teal accent-3"
                                                    required
                                                    :rules="[v => !!v || 'field is required']"
                                                    v-model='registerUser.name' />

                                                <v-text-field
                                                    id="registerEmail"
                                                    label="Email"
                                                    name="Email"
                                                    prepend-icon="mdi-email"
                                                    type="email"
                                                    color="teal accent-3"
                                                    required
                                                    :rules="[v => !!v || 'field is required']"
                                                    v-model='registerUser.email' />
                                                <small id="idMarkForEmail" class="text-danger">
                                                    <!-- {{ ErrMsg }} -->
                                                </small>

                                                <v-text-field
                                                    id="registerPassword"
                                                    label="Password"
                                                    name="Password"
                                                    color="teal accent-3"
                                                    prepend-icon="mdi-lock"
                                                    required
                                                    :rules="[v => !!v || 'field is required']"
                                                    :append-icon="eyeShow1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    @click:append="() => (eyeShow1 = !eyeShow1)"
                                                    :type="eyeShow1 ? 'password' : 'text'"
                                                    v-model='registerUser.password' />
                                                <small id="idMarkForPassword" class="text-danger">
                                                        <!-- {{ ErrMsg }} -->
                                                </small>

                                                <v-text-field
                                                    id="registerConfirmPassword"
                                                    label="Confirm"
                                                    name="Confirm"
                                                    color="teal accent-3"
                                                    prepend-icon="mdi-account-check"
                                                    required
                                                    :append-icon="eyeShow2 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    @click:append="() => (eyeShow2 = !eyeShow2)"
                                                    :type="eyeShow2 ? 'password' : 'text'"
                                                    :rules="[passwordConfirmationRule]"
                                                    v-model='registerUser.confirmPassword' />
                                                <small id="idMarkForConfirmPassword" class="text-danger">
                                                        <!-- {{ ErrMsg }} -->
                                                </small>
                                            </v-form>
                                        </v-card-text>
                                        <div class="text-center mt-n5">
                                            <v-btn rounded color="teal accent-3" dark>
                                                SIGN UP
                                            </v-btn>
                                        </div>
                                    </v-col>
                                </v-row>
                                </v-window-item>
                            </v-window>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
<!--
    <div>
        <router-view></router-view>
    </div>
-->

</template>

<script>
import validationErrors from "./shared/mixins/validationErrors";
import { logIn } from "./utils/auth";
import { mapState, mapGetters } from 'vuex';

export default {
    components: {

    },
    props: {

    },
    computed: {
        passwordConfirmationRule() {
            return () => (this.registerUser.password === this.registerUser.confirmPassword) || 'Password must match'
        },
		...mapState({	//Spread in object literals
			lastSearchComputed: "lastSearch",
            user: "user",
            userWithRoles: "userWithRoles",
			isLoggedIn: "isLoggedIn",
            allUsers: "allUsers",
        }),

        doneRolesGet () {
        //    console.log("hello doneRolesGet: ", this.$store.getters.currentLoginUserRoles)
            return this.$store.getters.currentLoginUserRoles;
            //return this.$store.getters.currentLoginUserData;
        }
    },
	data() {
		return {
            step: 1,

			loading: false,

			emailColor: 'black',
			passwordColor: 'black',
			emailErrMsg: '',
            passwordErrMsg: '',
            roles: [],

			loginEmail: null,
            loginPassword: null,

			registerUser: {
				name: null,
				email: null,
				password: null,
				confirmPassword: null,
			},

            valid: true,
            eyeShow: true,
            eyeShow1: true,
            eyeShow2: true,
/*
            rules: {
                required: value => !!value || "Required.",
                password: value => {
                    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
                    return (
                        pattern.test(value) ||
                        "Min. 8 characters with at least one capital letter, a number and a special character."
                    );
                }
            }
*/
        }
    },
    watch: {
//        'userWithRoles': function() {
        'user': function() {
            console.log("watch roles....")
            console.log("watch doneRolesGet....", this.doneRolesGet);
            //console.log("a. watch for roles: ", this.userWithRoles.roles);
            this.routePage();
        },
        'registerUser.email': function () {
			//Regular expression Testing
			let isEmailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
			//let isEmailRule = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            this.emailErrMsg = '';
            let result = this.loginEmail.search(isEmailRule);

			if (result != -1) {
            	this.emailErrMsg = '';
            	this.emailColor = 'black';
			} else {
            	this.emailErrMsg = 'Please provide a valid email!';
            	this.emailColor = 'red';
			}
            $('#idMarkForEmail').text(this.emailErrMsg);
        },	//end 'email': function()

        'registerUser.password': function () {
			//Regular expression Testing
			/* Here is an explanation:
			/^
                (?=.*\d)            // should contain at least one digit
                (?=.*[0-9])
			    (?=.*[a-z])         // should contain at least one lower case
                (?=.*[A-Z])         // should contain at least one upper case
                (?=.*[!@#\$%\^&\*]) // should contain at least one special character
                (?=.{8,})
			  (?=.*[a-zA-Z0-9]{8,30} // should contain 8 ~ 30 from the mentioned characters
			$/
			*/
            let isPasswordRule = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,30}$/;

            this.passwordErrMsg = '';
            let result = this.loginPassword.search(isPasswordRule);
            console.log("password regular: ", result);

			if (result != -1) {
            	this.passwordErrMsg = '';
            	this.passwordColor =  'black';
			} else {
            	this.passwordErrMsg = 'Please provide a valid password!';
            	this.passwordColor = 'red';
			}
            $('#idMarkForPassword').text(this.passwordErrMsg);
        },	//end 'loginPassword': function()
    },
    methods: {
		async signin() {
			this.loading = true;
			this.errors = null;

			try {
  				await axios.get('sanctum/csrf-cookie');
  				await axios.post("/login", {
  					email: this.loginEmail,
  					password: this.loginPassword
  				});

                logIn();

                //this.$store.dispatch('loadUser');
                //this.$store.dispatch('loadUserWithRoles');

                const loginData = {
      			    username: this.loginEmail,
      				password: this.loginPassword
    			};
                this.$store.dispatch('loadUserWithRoles', loginData);

                this.$store.dispatch('loadUserToken');

                console.log("welcome..., ", this.$route.path);
			} catch (error) {
				this.errors = error.response && error.response.data.errors;

          		const key = Object.keys(error.response.data.errors)[0];
          		this.errorMessage = error.response.data.errors[key][0];
			}

			this.loading = false;
        },

        routePage() {
            //console.log("routePage->role is: ", this.userWithRoles.roles);
            //if (this.userWithRoles.roles.includes("administrator")) {
            if (this.doneRolesGet.includes("administrator")) {
                console.log("role is administrator....");
                this.$router.push("hello1");
            } else {
                console.log("role is NOT administrator....");
                this.$router.push("hello2");
            }
        }

    },
};
</script>

<style scoped>
#signinup-form {
  max-width: 75rem;
}

.card {
  overflow: hidden;
}

.vcenter {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
