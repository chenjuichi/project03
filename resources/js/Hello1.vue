<template>
<div>
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
	    <a href="#" class="navbar-brand"><strong>Hello</strong></a>

	    <!-- Collection of nav links, forms, and other content for toggling -->
	    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">

			<div
				v-bind:class="['icon-search-container', { 'active': searchTrigger }]"
                @click.prevent="selectSearch">

                <span class="fa fa-search"></span>
                <input
					ref="search"
                    @blur="selectInputBlur"
                    @focus="searchTrigger=true"
  					v-model="valueForSearch"
                    type="text"
                    class="search-input"
                    placeholder="Search"/>
                <span class="fa fa-times-circle"></span>
            </div>

            <div class="navbar-nav ml-auto">
                <a href="#" class="nav-item nav-link active"><i class="fa fa-home"></i><span>Home</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-cogs"></i><span>Projects</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-users"></i><span>Team</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-chart-pie"></i><span>Reports</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-briefcase"></i><span>Careers</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-envelope"></i><span>Messages</span></a>
                <a href="#" class="nav-item nav-link"><i class="fa fa-bell"></i><span>Notifications</span></a>
                <div class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle user-action"><img src="https://www.tutorialrepublic.com/examples/images/avatar/3.jpg" class="avatar" alt="Avatar"> {{ user.name }} <b class="caret"></b></a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item"><i class="fa fa-user-o"></i> Profile</a>
                        <a href="#" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendar</a>
                        <a href="#" class="dropdown-item"><i class="fa fa-sliders"></i> Settings</a>
                        <div class="divider dropdown-divider"></div>
                        <a href="#" @click.prevent="logout" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
	    </div>
    </nav>

    <div class="links">
        <!-- 建立 Vue Router 連結-->
        <router-link to="/hello1/hello11"></router-link>
        <router-link to="/hello1/hello12"></router-link>
        <router-link to="/hello1/hello131"></router-link>
        <router-link to="/hello1/hello132"></router-link>
        <router-link to="/hello1/hello133"></router-link>
        <router-link to="/hello1/hello134"></router-link>
        <router-link to="/hello1/hello135"></router-link>
        <router-link to="/hello1/hello136"></router-link>
    </div>
    <router-view></router-view> <!-- Vue Router 代入的內容 -->
</div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import CountryFlag from 'vue-country-flag';

//import vClickOutside from "v-click-outside";
export default {
	components: {
        CountryFlag,
        //vClickOutside,
    },
   // props: ['imgurLink'],
  //name: 'router-view',
    //directives: {
    //  clickOutside: vClickOutside.directive
    //},
    mounted() {
        //
        //let span =  document.getElementById("spanIcon");
        //span.addEventListener('click', this.spanEven);
    },
	data() {
		return {
			flagMsgEn: "EN",
			flagMsgJp: "JP",
			flagMsgTw: "TW",

            lists: [],

			valueForSearch: "",
            searchTrigger: false,
            myClick: false,
        };
    },
	created() {
	    //
	},
	computed: {
        //
		...mapState({	//Spread in object literals
			lastSearchComputed: "lastSearch",
			user: "user",
			isLoggedIn: "isLoggedIn",
			allUsers: "allUsers",
		}),
		...mapGetters({
			itemsInBasket: "itemsInBasket"
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
		async logout() {
			try {
				axios.post("/logout");
				this.$store.dispatch("logout");
                this.$router.push('/');
                console.log("click logout dropdown-item.....")

			} catch (error) {
				this.$store.dispatch("logout");
			}
		},
        selectSearch(e) {
            this.myClick = true;
			this.$refs.search.focus();
            console.log("click search icon.....")
        },
        selectInputBlur(e) {
            console.log("blur function is on...");
            this.searchTrigger = false;
        },
        /*
        spanClick() {
            console.log("span click...");
            //if (this.myClick)
            //    this.spanClick();
            this.myClick = false;

            return;
        },
        */
/*
        spanEven(e) {
            console.log("... span click even ...");

            var button = e.target;
            console.log(e); // logs MouseEvent object with currentTarget:null
            console.log(e.currentTarget); // logs a value
            console.log(e.target.tagName);
            console.log(e.type);
            console.log(e.key);
            console.log(e.target.value);

            if(!button.classList.contains("active"))
                button.classList.add("active");
            else
                button.classList.remove("active");
            return;
        },
*/
	},
};
</script>

<style scoped>
/* begin navbar */
@import '../css/hello1.css';
/* end navbar */

/* begin search icon */
@import '../css/search.css';
/* end search icon */

/*
.active {
  background: red;
}
*/

span.flagClass.flag.f-us.normal-flag {
	font-size: 2rem;
	padding-left: 60px;
	font-weight: bold;
}

span.flagClass.flag.f-tw.normal-flag {
	font-size: 1.7rem;
	padding-left: 60px;
	font-weight: bold;
}

span.flagClass.flag.f-jp.normal-flag {
	font-size: 2rem;
	padding-left: 60px;
	font-weight: bold;
}

ul.sidebar-panel-nav {
   	list-style-type: none;
    padding: 10px 0;
 }

 ul.sidebar-panel-nav > li > a {
    display: block;
    position: relative;
    font-size: 14px;
    padding: 15px;
    height: 50px;
    color: #9ca0a5;
    font-weight: 600;
    transition: all 1s ease;
}

ul.sidebar-panel-nav li a .icon {
    margin-right: 10px;
}

ul.sidebar-panel-nav li a > span {
    display: inline-block;
}

ul.sidebar-panel-nav a:hover {
background: #19b3d3;
color: white;
font-weight: 800;
}

a.active .icon, a:hover .icon {
    color: #ffad41;
}

a.active .title_2, a:hover .title_2 {
    color: #374049;
    font-weight: 800;
}

ul.sidebar-panel-nav li:nth-child(2) > a:hover .icon {
    color: royalblue;
}

ul.sidebar-panel-nav li:nth-child(3) > a:hover .icon {
    color: #01ec3f;
}

ul.sidebar-panel-nav li:nth-child(4) > a:hover .icon {
    color: #ff375c;
}

ul.sidebar-panel-nav li:nth-child(5) > a:hover .icon {
    color: #41ffed;
}

ul.sidebar-panel-nav li:nth-child(6) > a:hover .icon {
    color: #ff5100;
}

ul.sidebar-panel-nav li:nth-child(7) > a:hover .icon {
    color: #e65aff;
}

ul.sidebar-panel-nav li:nth-child(8) > a:hover .icon {
    color: #ff4141;
}
</style>

