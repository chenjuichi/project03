<template>
<div>
	<div class="action">
		<div class="profile" @click.prevent="menuToggle">
			<img src="../images/S__11960383.jpg">
		</div>
		<div class="menu">
			<h3 v-if="isEmpty">Welcome, Guest!</h3>
			<h3 v-else>{{ user.name }}</h3>
			<ul>
				<li><i class="fab fa-facebook"></i><a href="#">Facebook</a></li>
				<li><i class="fas fa-microphone"></i><a href="#">Microphone</a></li>
				<li><i class="fas fa-user"></i><a href="#">Profile</a></li>
				<li><i class="fas fa-sign-out-alt"></i><a href="#" class="btn btn-icon" @click="logout">Signout</a></li>
				<li><i class="fas fa-video"></i><a href="#">Video</a></li>
				<li><i class="fas fa-camera"></i><a href="#">Camera</a></li>
			</ul>

		</div>
	</div>

	<!-- reference sidebar-02 directory -->
	<div class="wrapper d-flex align-items-stretch">
		<!-- Side Bar-->
		<nav id="sidebar" v-bind:class="[{'active': isActive}]">
			<div class="custom-menu">
				<button type="button" id="sidebarCollapse" @click.prevent="toggleSideBar" class="btn btn-primary">
					<i class="fa fa-bars"></i>
					<span class="sr-only">Toggle Menu</span>
				</button>
			</div>
			<div class="p-4 pt-5">
				<h1><a href="#" class="logo">Splash</a></h1>
				<ul class="list-unstyled components mb-5">
					<li class="active">
						<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
						<ul class="collapse list-unstyled" id="homeSubmenu">
							<li><a href="#">Home 1</a></li>
							<li><a href="#">Home 2</a></li>
							<li><a href="#">Home 3</a></li>
						</ul>
					</li>
					<li><a href="#">About</a></li>
					<li>
						<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
						<ul class="collapse list-unstyled" id="pageSubmenu">
							<li><a href="#">Page 1</a></li>
							<li><a href="#">Page 2</a></li>
							<li><a href="#">Page 3</a></li>
						</ul>
					</li>
					<li><a href="#">Portfolio</a></li>
					<li><a href="#">Contact</a></li>
				</ul>

				<div class="mb-5">
					<h3 class="h6">Subscribe for newsletter</h3>
					<form action="#" class="colorlib-subscribe-form">
						<div class="form-group d-flex">
							<div class="icon"><span class="icon-paper-plane"></span></div>
							<input type="text" class="form-control" placeholder="Enter Email Address">
						</div>
					</form>
				</div>
			</div>
		</nav>
		
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5 pt-5">
				hell 2
			<section class="section has-text-centered">
				<h1 class="title is-1">
					Your Window
				</h1>
				<h3>
					Width: {{ window.width }} px<br/>
					Height: {{ window.height }} px
				</h3>
				<p>
					&uarr;<br/>
					&larr; resize window &rarr;<br/>
					&darr;
				</p>
			</section>

			<div class="footer">
				<p>
					Copyright {{moment().format()}} 
					<i class="fas fa-heart"></i>
				</p>
			</div>			
		</div>
	</div>
</div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import moment from "moment";

export default {
	components: {
    },
    //directives: {
    //},
    mounted() {
        //
    },
	data() {
		return {
        	window: {
        	    width: 0,
        	    height: 0
			},	
			isActive: false,
			isExpand: true,		
        };
    },
	created() {
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
  	},
	destroyed() {
        window.removeEventListener('resize', this.handleResize);
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
        isEmpty() {
              return $.isEmptyObject(this.user)
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
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
		toggleSideBar() {
			this.isActive = !this.isActive;
		},
		menuToggle() {
			$(".menu").toggleClass("active"); 
		},		
    	moment: function (date) {
    	  return moment(date);
    	},
    	date: function (date) {
    	  return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    	}
  	},    //end method
  	filters: {
  	  moment: function (date) {
  	    return moment(date).format('MMMM Do YYYY, h:mm:ss a');
  	  }
  	},    //end filters
};
</script>

<style lang="scss" scoped >
@import "./sidebar-02/scss/style";

section.section {
	display: flex;
  	flex-flow: column;
  	justify-content: center;
  	align-items: center;
}

.action {
	position: fixed;
	top: 20px;
	right: 30px;
}

.action .profile {
	position: relative;
	width: 60px;
	height: 60px;
	border-radius: 50%;
	overflow: hidden;
	cursor: pointer;
}

.action .profile img {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.action .menu {
	position: absolute;
	top: 120px;
	right: -10px;
	padding: 10px 20px;
	background: #ba7bb4;
	width: 200px;
	box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
	border-radius: 15px;
	transition: 0.5s;
	visibility: hidden;
	opacity: 0;
}

.action .menu.active {
	top: 80px;
	visibility: visible;
	opacity: 1;
}

.action .menu::before {
	content: '';
	position: absolute;
	top: -5px;
	right: 28px;
	width: 20px;
	height: 20px;
	background: #ba7bb4;
	transform: rotate(45deg);
}

.action .menu h3 {
	width: 100%;
	text-align: center;
	font-size: 18px;
	padding:20px 0;
	font-weight: 500;
	color: #555;
	line-height: 1.2em;
}

.action .menu ul li {
	list-style: none;
	padding: 10px 0;
	border-top: 1px solid rgba(0, 0, 0, 0.05);
	display: flex;
	align-items: center;
}

.action .menu ul li i {
	max-width: 20px;
	margin-right: 10px;
	opacity: 0.5;
	transition: 0.5s;
}

.action .menu ul li:hover i {
	opacity: 1;
}

.action .menu ul li a {
	display: inline-block;
	text-decoration: none;
	color: #555;
	font-weight: 500;
	transition: 0.5s;
}	

.action .menu ul li:hover a {
	color: #130e6e;
}
</style>

