require('./bootstrap');

import Vue from 'vue'
import App from './app/App'

import { routes } from './app/routes'
import VueRouter from 'vue-router'
import { store } from './app/store'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css'
import moment from 'moment'

Vue.use(ElementUI, { locale });

Vue.filter('timeFormat', (arg)=>{
    return moment().format("MMM Do YYYY")
})

// window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router : router,
    store: store,
    render : app => app(App),
});
