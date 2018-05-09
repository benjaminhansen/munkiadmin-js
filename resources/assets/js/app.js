
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.plist = require('plist');

window.moment = require('moment');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('catalogs', require('./components/Catalogs.vue'));
Vue.component('manifests', require('./components/Manifests.vue'));
Vue.component('packages', require('./components/Packages.vue'));

const app = new Vue({
    el: '#app'
});
