<template>
<div>
	<!-- reference sidebar-pro directory -->
        <div 
            id="page-wrapper"
            v-bind:class="[ 'page-wrapper toggled',
                            themeArray[themeIndex],
                            bgImageArray[bgImageIndex],
                            {'pinned': isPin},                             
                            {'sidebar-hovered': isSidebarHovered},
                            {'sidebar-bg': toggleBackgroundImage} ]">                    
            <nav 
                id="sidebar" 
                ref="sidebar" 
                v-bind:class="['sidebar-wrapper', {'active': toggleBackgroundImage}]">
                <div
                    v-bind:class="[ 'sidebar-content', {'desktop': isDesktop}]">
                    <!-- sidebar-brand  -->
                    <div class="sidebar-item sidebar-brand">
                        <a href="#">pro sidebar</a>
                    </div>
                    <!-- sidebar-header  -->
                    <div class="sidebar-item sidebar-header d-flex flex-nowrap">
                        <div v-bind:class="['user-pic', {'active': toggleBorderRadius}]">
                            <img class="img-responsive img-rounded" src="/images/sidebar-pro/user.jpg" alt="User picture">
                        </div>
                        <div class="user-info">
                            <span class="user-name">Jhon
                                <strong>Smith</strong>
                            </span>
                            <span class="user-role">Administrator</span>
                            <span class="user-status">
                                <i class="fa fa-circle"></i>
                                <span>Online</span>
                            </span>
                        </div>
                    </div>
                    <!-- sidebar-search  -->
                    <div class="sidebar-item sidebar-search">
                        <div>
                            <div class="input-group">
                                <input type="text" class="form-control search-menu" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sidebar-menu  -->
                    <div class="sidebar-item sidebar-menu">
                        <ul id="sidebar-menu-items">
                            <li class="header-menu">
                                <span>General</span>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchListUsers" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">List Users</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchListRoles" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">List Roles</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchListRolesTemp" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">List RolesTemp</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchTags" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">Tags</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchCategories" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">Categories</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a @click="watchAdminUsers" style="cursor: pointer;">
                                    <i class="fas fa-users"></i>
                                    <span class="menu-text">Admin users</span>
                                </a>
                            </li>

                            <li 
                                class="sidebar-dropdown" 
                                v-bind:class="[{'active': isSidebarDropdown[0]}]">  
                                <a href="#" @click="clickSidebarDropdown(0)">
                                    <i class="fa fa-tachometer-alt"></i>
                                    <span class="menu-text">Dashboard</span>
                                    <span v-bind:class="['badge-pill badge-warning badge', {'active': toggleBorderRadius}]">
                                        New
                                    </span>
                                </a>
                                <vue-slide-up-down 
                                    :active="isSidebarDropdown[0]" 
                                    :duration="200"
                                    class="sidebar-submenu" 
                                    :style="[{ 'display': display_style[0] }]">                               
                                <!--<div class="sidebar-submenu" :style="[{ 'display': display_style }]">-->
                                    <ul>
                                        <li>
                                            <a href="#">Dashboard 1
                                                <span 
                                                    v-bind:class="['badge-pill badge-success badge', {'active': toggleBorderRadius}]">
                                                    Pro
                                                </span>
                                            </a>
                                        </li>
                                        <li><a href="#">Dashboard 2</a></li>
                                        <li><a href="#">Dashboard 3</a></li>
                                    </ul>
                                <!--</div>-->
                                </vue-slide-up-down>
                            </li>
                            <li v-bind:class="['sidebar-dropdown', {'active': isSidebarDropdown[1]}]">
                                <a href="#" @click="clickSidebarDropdown(1)">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-text">E-commerce</span>
                                    <span 
                                        v-bind:class="['badge-pill badge-danger badge', {'active': toggleBorderRadius}]">
                                        3
                                    </span>
                                </a>
                                <vue-slide-up-down 
                                    :active="isSidebarDropdown[1]" 
                                    :duration="200"
                                    class="sidebar-submenu" 
                                    :style="[{ 'display': display_style[1] }]">                               
                                <!--<div class="sidebar-submenu" :style="[{ 'display': display_style }]">-->
                                    <ul>
                                        <li><a href="#">Products</a></li>
                                        <li><a href="#">Orders</a></li>
                                        <li><a href="#">Credit cart</a></li>
                                    </ul>
                                <!--</div>-->
                                </vue-slide-up-down>
                            </li>
                            <li 
                                v-bind:class="['sidebar-dropdown', {'active': isSidebarDropdown[2]}]">
                                <a 
                                    href="#" 
                                    @click="clickSidebarDropdown(2)">
                                    <i class="far fa-gem"></i>
                                    <span class="menu-text">Components</span>
                                </a>
                                <vue-slide-up-down 
                                    :active="isSidebarDropdown[2]" 
                                    :duration="200"
                                    class="sidebar-submenu" 
                                    :style="[{ 'display': display_style[2] }]">                               
                                <!--<div class="sidebar-submenu">-->
                                    <ul>
                                        <li><a href="#">General</a></li>
                                        <li><a href="#">Panels</a></li>
                                        <li><a href="#">Tables</a></li>
                                        <li><a href="#">Icons</a></li>
                                        <li><a href="#">Forms</a></li>
                                    </ul>
                                <!--</div>-->
                                </vue-slide-up-down>
                            </li>
                            <li v-bind:class="['sidebar-dropdown', {'active': isSidebarDropdown[3]}]">
                                <a href="#" @click="clickSidebarDropdown(3)">
                                    <i class="fa fa-chart-line"></i>
                                    <span class="menu-text">Charts</span>
                                </a>
                                <vue-slide-up-down 
                                    :active="isSidebarDropdown[3]" 
                                    :duration="200"
                                    class="sidebar-submenu" 
                                    :style="[{ 'display': display_style[3] }]">                               
                                <!--<div class="sidebar-submenu">-->
                                    <ul>
                                        <li><a href="#">Pie chart</a></li>
                                        <li><a href="#">Line chart</a></li>
                                        <li><a href="#">Bar chart</a></li>
                                        <li><a href="#">Histogram</a></li>
                                    </ul>
                                <!--</div>-->
                                </vue-slide-up-down>
                            </li>
                            <li 
                                v-bind:class="['sidebar-dropdown', {'active': isSidebarDropdown[4]}]">
                                <a 
                                    href="#" 
                                    @click="clickSidebarDropdown(4)">
                                    <i class="fa fa-globe"></i>
                                    <span class="menu-text">Maps</span>
                                </a>
                                <vue-slide-up-down 
                                    :active="isSidebarDropdown[4]" 
                                    :duration="200"
                                    class="sidebar-submenu" 
                                    :style="[{ 'display': display_style[4] }]">                               
                                <!--<div class="sidebar-submenu">-->
                                    <ul>
                                        <li><a href="#">Google maps</a></li>
                                        <li><a href="#">Open street map</a></li>
                                    </ul>
                                <!--</div>-->
                                </vue-slide-up-down>
                            </li>
                            <li class="header-menu">
                                <span>Extra</span>
                            </li>
                            <li> 
                                <a href="#">
                                    <i class="fa fa-book"></i>
                                    <span class="menu-text">Documentation</span>
                                    <span 
                                        v-bind:class="['badge-pill badge-primary badge', {'active': toggleBorderRadius}]">                                        
                                        Beta
                                    </span>
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-calendar"></i>
                                <span class="menu-text">Calendar</span>
                            </li>
                            <li>
                                <i class="fa fa-folder"></i>
                                <span class="menu-text">Examples</span>
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
                <!-- sidebar-footer  -->
                <div class="sidebar-footer">
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span 
                                v-bind:class="['badge-pill badge-warning notification badge', {'active': toggleBorderRadius}]">                                        
                                3
                            </span>
                        </a>
                        <div class="dropdown-menu notifications" aria-labelledby="dropdownMenuMessage">
                            <div class="notifications-header">
                                <i class="fa fa-bell"></i>
                                Notifications
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="fas fa-check text-success border border-success"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                        <div class="notification-time">
                                            6 minutes ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="fas fa-exclamation text-info border border-info"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                        <div class="notification-time">
                                            Today
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="fas fa-exclamation-triangle text-warning border border-warning"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                        <div class="notification-time">
                                            Yesterday
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all notifications</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                            <span v-bind:class="['badge-pill badge-success notification badge', {'active': toggleBorderRadius}]">                                        
                                7
                            </span>
                        </a>
                        <div class="dropdown-menu messages" aria-labelledby="dropdownMenuMessage">
                            <div class="messages-header">
                                <i class="fa fa-envelope"></i>
                                Messages
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="/images/sidebar-pro/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong> Jhon doe</strong>
                                        </div>
                                        <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                    </div>
                                </div>

                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="/images/sidebar-pro/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong> Jhon doe</strong>
                                        </div>
                                        <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                    </div>
                                </div>

                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="/images/sidebar-pro/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong> Jhon doe</strong>
                                        </div>
                                        <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit. In totam explicabo</div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all messages</a>

                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                            <span class="badge-sonar"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                            <a class="dropdown-item" href="#">My profile</a>
                            <a class="dropdown-item" href="#">Help</a>
                            <a class="dropdown-item" href="#">Setting</a>
                        </div>
                    </div>
                    <div>
                        <a href="#"><i class="fa fa-power-off"></i></a>
                    </div>
                    <div class="pinned-footer">
                        <a href="#"><i class="fas fa-ellipsis-h"></i></a>
                    </div>
                </div>
            </nav>
            <!-- page-content  -->
            <div class="page-content pt-2">                                                 
                <!--
                <div id="overlay" class="overlay" @click.prevent="toggleSidebar">
                    HELLO
                </div>
                -->
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h2>Pro Sidebar</h2>
                            <p>
                                This is a responsive sidebar template with dropdown menu based on bootstrap framework.
                            </p>
                        </div>

                        <div class="form-group col-md-12">
                            <iframe
                                src="https://ghbtns.com/github-btn.html?user=azouaoui-med&repo=pro-sidebar-template&type=star&count=true&size=small"
                                frameborder="0" scrolling="0" width="100px" height="30px">
                            </iframe>
                            <iframe
                                src="https://ghbtns.com/github-btn.html?user=azouaoui-med&repo=pro-sidebar-template&type=fork&count=true&size=small"
                                frameborder="0" scrolling="0" width="100px" height="30px">
                            </iframe>
                        </div>

                        <div class="form-group col-md-12">
                            <a  id="toggle-sidebar" 
                                @click.prevent="toggleSidebar" 
                                class="btn btn-secondary rounded-0" 
                                href="#">
                                <span>Toggle Sidebar</span>
                            </a>
                            <a  id="pin-sidebar" 
                                @click.prevent="isPin=!isPin" 
                                class="btn btn-outline-secondary rounded-0" 
                                href="#">
                                <span>Pin Sidebar</span>
                            </a>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h3>Themes</h3>
                            <p>Here are more themes that you can use</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="default-theme" 
                                class="theme default-theme selected">
                            </a>
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="chiller-theme" 
                                class="theme chiller-theme">
                            </a>
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="legacy-theme" 
                                class="theme legacy-theme"></a>
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="ice-theme" 
                                class="theme ice-theme"></a>
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="cool-theme" 
                                class="theme cool-theme"></a>
                            <a 
                                href="#" 
                                @click.prevent="switchThemes"
                                data-theme="light-theme" 
                                class="theme light-theme">
                            </a>
                        </div>
                        <div class="form-group col-md-12">
                            <p>You can also use background image </p>
                        </div>
                        <div class="form-group col-md-12">
                            <a  href="#"
                                @click.prevent="switchBackgroundImages"
                                data-bg="bg1" 
                                class="theme theme-bg selected"
                                :style="{ backgroundImage: 'url(' + bgImage1 + ')'}">
                            </a>
                            <a  href="#"
                                @click.prevent="switchBackgroundImages"
                                data-bg="bg2" 
                                class="theme theme-bg"
                                :style="{ backgroundImage: 'url(' + bgImage2 + ')'}">
                            </a>
                            <a  href="#"
                                @click.prevent="switchBackgroundImages"
                                data-bg="bg3" 
                                class="theme theme-bg"
                                :style="{ backgroundImage: 'url(' + bgImage3 + ')'}">
                            </a>
                            <a  href="#"
                                @click.prevent="switchBackgroundImages"
                                data-bg="bg4" 
                                class="theme theme-bg"
                                :style="{ backgroundImage: 'url(' + bgImage4 + ')'}">
                            </a>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-switch">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="toggle-bg"
                                    v-model="toggleBackgroundImage">
                                <label class="custom-control-label" for="toggle-bg">Background image</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-switch">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="toggle-border-radius"
                                    v-model="toggleBorderRadius">
                                <label class="custom-control-label" for="toggle-border-radius">Border radius</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <div>
                                Made with <i class="fa fa-heart text-danger" aria-hidden="true"></i> by 
                                <span
                                    class="text-secondary font-weight-bold">Mohamed Azouaoui
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <a href="https://github.com/azouaoui-med" target="_blank"
                                class="btn btn-sm bg-secondary shadow-sm rounded-0 text-light mr-3 mb-3">
                                <i class="fab fa-github" aria-hidden="true"></i>
                            </a>
                            <a href="https://twitter.com/azouaoui_med" target="_blank"
                                class="btn btn-sm bg-secondary shadow-sm rounded-0 text-light mr-3 mb-3">
                                <i class="fab fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.instagram.com/azouaoui_med/" target="_blank"
                                class="btn btn-sm bg-secondary shadow-sm rounded-0 text-light mr-3 mb-3">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/mohamed-azouaoui/" target="_blank"
                                class="btn btn-sm bg-secondary shadow-sm rounded-0 text-light mr-3 mb-3">
                                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
</div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import VueSlideUpDown from 'vue-slide-up-down';

// Highly customizable custom scrollbar jQuery plugin
import "malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css";
import "malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js";

//import moment from "moment";

export default {
	components: {
		VueSlideUpDown,    //vue-slide-up-down
    },
    //directives: {
    //},
    beforeMount() { 
        console.log('vue beforeMount()...'); 
    },
    mounted() {
        console.log("vue mounted()...")

        //
        let vm = this;
        $(this.$el).find('.sidebar-content').mCustomScrollbar({
            axis: 'y',
            autoHideScrollbar: true,
            scrollInertia: 300,
        });
        //
        
        this.$nextTick(() => {
            this.addEvent();
            //this.$refs.sidebar.addEventListener('mouseover', this.handleMouseover);
            //this.$refs.sidebar.addEventListener('mouseout', this.handleMouseout);
        });

        let sidebarMenuItems = document.getElementById('sidebar-menu-items');
        //console.log("sidebarMenuItems: ",sidebarMenuItems);
        this.childItems = sidebarMenuItems.children;
        //console.log(this.childItems);

        let themes =['default-theme', 'legacy-theme', 'chiller-theme', 'ice-theme', 'cool-theme', 'light-theme'];
        this.themeArray = themes;
        let bgs =['bg1', 'bg2', 'bg3', 'bg4'];
        this.bgImageArray = bgs;

        //this.customScrollBar();
    },
	data() {
		return {
            myHandle: null,
        	window: {
        	    width: 0,
        	    height: 0
			},	

			isPin: false,		
            isSidebarHovered: false,
            isSidebarDropdown: [],
			isActive: false,
            isDesktop: true,
            childItems: [],
            display_style: [],
            toggleBorderRadius: false,
            toggleBackgroundImage: false,
            bgImage1: "/images/sidebar-pro/bg1.jpg",
            bgImage2: "/images/sidebar-pro/bg2.jpg",
            bgImage3: "/images/sidebar-pro/bg3.jpg",
            bgImage4: "/images/sidebar-pro/bg4.jpg",
            themeIndex: 0,
            bgImageIndex: 0,
            themeArray: [],
            bgImageArray: [],
        };
    },
    //watch: {
    //            
    //},
    beforeCreate() {
        console.log('vue beforeCreate()...'); 
    },    
	created() {
        console.log("vue created()...")

        //windowd.addEventListener('mouseover', this.handleMouseover);
        //this.handleMouseover();
        //window.addEventListener('mouseout', this.handleMouseout);        
  	    //this.handleMouseout();
        ///let sidebarMenuItems = document.getElementById('sidebar-menu-items');
        ///console.log("sidebarMenuItems: ",sidebarMenuItems);
        //this.childItems = sidebarMenuItems.children;
        //console.log(this.childItems);
        let sidebar_dropdown_items = 5;
        this.setSidebarDropdownClose(sidebar_dropdown_items);

        /*
        let themes =['default-theme', 'legacy-theme', 'chiller-theme', 'ice-theme', 'cool-theme', 'light-theme'];
        this.themeArray = themes;
        let bgs =['bg1', 'bg2', 'bg3', 'bg4'];
        this.bgImageArray = bgs;
        */
    },
	destroyed() {
        console.log("vue destroyed()...")

        this.removeEvent();
        //this.myHandle.removeEventListener('mouseover', this.handleMouseover);
        //this.myHandle.removeEventListener('mouseout', this.handleMouseout);

        //$(this.$el).find('.sidebar-content').mCustomScrollbar("destroy");

	},	
	computed: {
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
    beforeUpdate() { 
        console.log('vue beforeUpdate()...'); 
    },
    updated() {
        console.log("vue update()...", );
        $('.mCSB_dragger_bar').css({"background-color":"rgba(240, 52, 52, 1)"});
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
        addEvent() {
            let vm = this;
            this.myHandle = vm.$refs.sidebar;
            this.$refs.sidebar.addEventListener('mouseover', vm.handleMouseover);
            this.$refs.sidebar.addEventListener('mouseout', vm.handleMouseout);
        },
        removeEvent() {
            //let vm = this;
            //vm.$refs.sidebar.removeEventListener('mouseover', vm.handleMouseover);
            //vm.$refs.sidebar.removeEventListener('mouseout', vm.handleMouseout);
            this.myHandle.removeEventListener('mouseover', this.handleMouseover);
            this.myHandle.removeEventListener('mouseout', this.handleMouseout);
        },
        handleMouseover() {
            console.log('mouse enter...');
            this.isSidebarHovered = true;
        },
        handleMouseout() {
            console.log('mouse out...');
            this.isSidebarHovered = false;
        },
        toggleSidebar() {    //toggle sidebar
            $('.page-wrapper').toggleClass('toggled');
		},  
        pinSidebar() {  //Pin sidebar
            if (this.isPin) {
                // unpin sidebar when hovered
                //this.addEvent();
                this.isPin = false;
            } else {
                //this.removeEvent();
                this.isPin = true;
            }
        },
        setSidebarDropdownClose(index) {
            this.isSidebarDropdown=[];
            this.display_style=[];
            for (let i = 0; i < index; i++) {
                this.isSidebarDropdown.push(false);
                this.display_style.push("none");
            }
        },
        clickSidebarDropdown0(e) {
            console.log("clickSidebarDropdown click function.....")            
            console.log("this.isSidebarDropdown: ", this.isSidebarDropdown);
            this.isSidebarDropdown[0] = !this.isSidebarDropdown[0];
            console.log("this.isSidebarDropdown: ", this.isSidebarDropdown);            
            if (this.isSidebarDropdown[0]) {
                this.display_style = "block";
            } else {
                this.display_style = "none";
            }
        },
        clickSidebarDropdown(index) {
            console.log("clickSidebarDropdown(index): ", index);
            let temp = this.isSidebarDropdown[index];
            let tt = 5;
            this.setSidebarDropdownClose(tt);
            this.isSidebarDropdown[index] = !temp;
            //console.log("this.isSidebarDropdown: ", this.isSidebarDropdown);            
            if (this.isSidebarDropdown[index]) {
                this.display_style[index] = "block";
            } else {                
                this.display_style[index] = "none";
            }
        },
        switchBackgroundImages(e) {
            console.log("switchBackgroundImages click function.....");
            //console.log("switchBackgroundImages click function.....", e.target.className);
            $('[data-bg]').removeClass('selected'); //clear all 'selected'
            let newAttr=e.currentTarget.getAttribute('data-bg');  //get '[data-bg]' attribute value
            //console.log("switchBackgroundImages click function....., new Attr", newAttr);
            e.target.classList.toggle('selected');  //set target 'selected'
            //console.log("switchBackgroundImages click function.....", e.target.className);
            
            let xId = document.getElementById("page-wrapper").classList;
            const ff = this.bgImageArray.length;
            for (let i =0; i < ff; i++) {
  		        if (xId.contains(this.bgImageArray[i])) {
                    xId.toggle(this.bgImageArray[i]);
                    //console.log("switchBackgroundImages click function....., old Attr", bgs[i]);
        	        break;
  		        }
            }
            xId.add(newAttr);

            for (let j =0; j < ff; j++) {
  		        if (this.bgImageArray[j] === newAttr) {
                    this.bgImageIndex = j;
        	        break;
  		        }
            }
        },
        switchThemes(e) {
            console.log("switchThemes click function.....");
            $('[data-theme]').removeClass('selected'); //clear all 'selected'
            let newAttr=e.currentTarget.getAttribute('data-theme');  //get '[data-bg]' attribute value
            e.target.classList.toggle('selected');  //set target 'selected'
            
            let xId = document.getElementById("page-wrapper").classList;
            const ff = this.themeArray.length;
            for (let i =0; i < ff; i++) {
  		        if (xId.contains(this.themeArray[i])) {
                    xId.toggle(this.themeArray[i]);
                    //console.log("switchBackgroundImages click function....., old Attr", bgs[i]);
        	        break;
  		        }
            }
            xId.add(newAttr);

            for (let j = 0; j < ff; j++) {
  		        if (this.themeArray[j] === newAttr) {
                    this.themeIndex = j;
        	        break;
  		        }
            }
        },
        watchListUsers() {
                this.$router.push('/hello1/hello131');
        },  
        watchListRoles() {
                this.$router.push('/hello1/hello132');
        },  
        watchListRolesTemp() {
                this.$router.push('/hello1/hello133');
        },  
        watchTags() {
                this.$router.push('/hello1/hello134');
        },  
        watchCategories() {
                this.$router.push('/hello1/hello135');
        },  
        watchAdminUsers() {
                this.$router.push('/hello1/hello136');
        },  
/*
        clickSidebarDropdown(e) {
            console.log("clickSidebarDropdown click function.....")
            console.log("children classname: ", e.target.children[0].className);
            
            console.log("this.isSidebarDropdown: ", this.isSidebarDropdown);
            if (e.target.children[0].className === "fa fa-tachometer-alt")
                this.isSidebarDropdown[0] = !this.isSidebarDropdown[0];
            if (e.target.children[0].className === "fa fa-shopping-cart")
                this.isSidebarDropdown[1] = !this.isSidebarDropdown[1];
            if (e.target.children[0].className === "far fa-gem")
                this.isSidebarDropdown[2] = !this.isSidebarDropdown[2];
            if (e.target.children[0].className === "fa fa-chart-line")
                this.isSidebarDropdown[3] = !this.isSidebarDropdown[3];
            if (e.target.children[0].className === "fa fa-globe")
                this.isSidebarDropdown[4] = !this.isSidebarDropdown[4];
            console.log("this.isSidebarDropdown: ", this.isSidebarDropdown);
            
            //if (this.display_style === "none") {
            //    this.display_style = "block";
            //} else {
            //    this.display_style = "none";
            //}
        },
*/        
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
  	  },
    beforeRouteEnter(to, from, next) {
        next(vm => {
        vm.prevRoute = from;
    })
},
  	},    //end filters
};
</script>

<style lang="scss" scoped >
@import "./sidebar-pro/main";
@import "./sidebar-pro/sidebar-themes";

/*
#mCSB_1_dragger_vertical >>> .mCSB_dragger_bar {
    background-color: rgba(240, 52, 52, 1); 
}
*/
</style>

