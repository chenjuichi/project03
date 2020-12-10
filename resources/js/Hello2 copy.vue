<template>
<div>
	<div class="toggle" id="toggle" @click.prevent="toggleExpand">
		<i class="fas fa-plus" id="plus"></i>
	</div>
	<!--
		<button type="button" @click.prevent="logout">
			<i class="fas fa-user"></i>
		</button>
		<a type="button" @click.prevent="logout"><i class="fas fa-sign-out-alt"></i></a>
	-->

  	<div class="menu" id="menu">		
		<a href="#" class="btn btn-icon"><i class="fa fa-facebook"></i></a>
		<a href="#" class="btn btn-icon"><i class="fas fa-microphone"></i></a>
		<a href="#" class="btn btn-icon"><i class="fas fa-user"></i></a>
		<a href="#" class="btn btn-icon" @click.stop="logout"><i class="fas fa-sign-out-alt"></i></a>
		<a href="#" class="btn btn-icon"><i class="fas fa-video"></i></a>
		<a href="#" class="btn btn-icon"><i class="fas fa-camera"></i></a>
		<a href="#" class="btn btn-icon"><i class="fas fa-bell"></i></a>
	</div>

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
		toggleExpand() {
			$(".menu").toggleClass("active"); 
			//document.getElementById("menu").
			//document.getElementById("menu").
			if (!this.isExpand) {
				document.getElementById("menu").style.transform="scale(2)";
				document.getElementById("plus").style.transform="rotate(45deg)";
				this.isExpand=true;
			} else {
				document.getElementById("menu").style.transform="scale(0)";
				document.getElementById("plus").style.transform="rotate(0deg)";
				this.isExpand=false;
			}
		},			
    	moment: function (date) {
    	  return moment(date);
    	},
    	date: function (date) {
    	  return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    	}
  	}, //end method
  	filters: {
  	  moment: function (date) {
  	    return moment(date).format('MMMM Do YYYY, h:mm:ss a');
  	  }
  	}
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

.toggle {
	background: #3498db;
	height: 100px;
	width: 100px;
	position: absolute;
	/*top: calc(100% - 100px);*/
	top: -100px;
	bottom: 0;
	left: calc(100% - 400px);
	right: 0;
	margin: auto;
	text-align: center;
	border-radius: 50%;
	cursor: pointer;
}

.toggle i {
	font-size: 60px;
	color: #fff;
	display: block;
	margin-top: 20px;
	transition: 0.7s;
}

.menu {
	background: #fff;
	height: 100px;
	width: 100px;
	border-radius: 50%;
	transform: scale(2);
	position: absolute;
	top: -100px;
	bottom: 0;
	left: calc(100% - 400px);
	right: 0;
	margin: auto;
	
	border: 2px solid #e74c3c;
	transition: 0.7s;
}
/*
.menu.active {
	z-index: 50;
	cursor: pointer;
}
*/
.menu a {
	display: inline-block;
	position: absolute;
	font-size: 15px;
	color: #bbbbbb;
	transition: 0.4s;
}

.menu a:nth-child(1) {
	top: 2px;
	left: 42px;
}

.menu a:nth-child(2) {
	top: 24px;
	left: 77px;
}

.menu a:nth-child(3) {
	top: 58px;
	left: 76px;
}

.menu a:nth-child(4) {
	top: 74px;
	left: 42px;
}

.menu a:nth-child(5) {
	top: 58px;
	left: 10px;
}

.menu a:nth-child(6) {
	top: 23px;
	left: 12px;
}

.menu a:hover {
	color: #3498db;
}
</style>

