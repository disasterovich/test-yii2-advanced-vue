//require('./bootstrap');
//window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';

import App from './components/App.vue';
import ApplesList from './components/ApplesList.vue';

Vue.component('ApplesList',ApplesList);

Vue.use(VueRouter);

const routes = [
    {
        path : '/',
        component : ApplesList
    },
    {
        path : '*',
        component : ApplesList
    }
];

const router = new VueRouter ({
    mode: 'history',
    routes
});

//import axios from 'axios';
//axios.defaults.headers.common['Authorization'] = 'Bearer 1111111111111';

new Vue({
    router,
    el: '#app',
    render: h => h(App)
})