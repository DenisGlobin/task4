/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Gate from './policies/Gate';
import App from './components/App';
import DocumentsList from './components/DocumentsList';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Profile from './components/Profile';
import DocumentShow from './components/DocumentShow';
import DocumentEdit from './components/DocumentEdit';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
axios.defaults.baseURL = 'http://task4.local/api/v1';

Vue.prototype.$gate = new Gate();

const router = new VueRouter({
    routes: [
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        },
        {
            path: '/user',
            name: 'user',
            component: Profile,
            meta: {
                auth: true
            }
        },
        {
            path: '/documents/page=:page&perPage=:perPage',
            name: 'api.documents.index',
            component: DocumentsList
        },
        {
            path: '/document/:id',
            name: 'api.documents.show',
            component: DocumentShow
        },
        {
            path: '/document/:id/edit',
            name: 'api.documents.edit',
            component: DocumentEdit,
            meta: {
                auth: true
            }
        },
    ],
    mode: 'history'
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.router = router;
Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});
App.router = Vue.router;
new Vue(App).$mount('#app');