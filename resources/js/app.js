/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//=== import from node_modules directory
import Vuetify from  "vuetify";
import Vuex from "vuex";
import VueRouter from "vue-router";
import VueI18n from "vue-i18n";
//import moment from "moment";
//var moment = require('moment');
//===

//=== import from resources/js
import router from "./routers";
import ValidationErrors from "./shared/components/ValidationErrors";
import storeDefinition from "./store";
import Hello from "./Hello";
import Welcome from "./Welcome";
import { getLang } from "./utils/tool";
import LangCn from "./i18n/zh-cn";
import LangEn from "./i18n/en";
import LangTw from "./i18n/zh-tw";
//===

window.Vue = require('vue');
//===
Vue.use(Vuex);
Vue.use(VueRouter);
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err)
}
Vue.use(Vuetify);
Vue.use(VueI18n);
const i18n = new VueI18n({
  locale: getLang(),  //讀取语言配置
  messages: {
    'cn': LangCn,
    'en': LangEn,
    'tw': LangTw,
  }
});
console.log("i18n: ", i18n);
//===

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//===
Vue.component("hello", Hello);
Vue.component("v-errors", ValidationErrors);
//Vue.filter("formatDate", function(date) {               //Filter 代入的參數 formatDate
//    return moment(date).format('MMMM Do YYYY');
//});
//===

//===
const store = new Vuex.Store(storeDefinition);
//===

const app = new Vue({
  vuetify: new Vuetify(),
  el: '#app',
  router,
  store,

  components: {   //local registration
    'hello': Hello,
  },

  async beforeCreate() {
      this.$store.dispatch('loadStoredState');
      console.log("hello----");
      this.$store.dispatch('loadUser');

      //the following code is for testing
      /*
      await axios.get('sanctum/csrf-cookie');
      await axios.post("/login", {
        email: 'howell.reinger@example.net',
        password: 'password'
      });
      await axios.get("/user");
      */
  },

});

