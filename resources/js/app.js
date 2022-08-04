require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import router from './router'

import UsersIndex from "./Components/UsersIndex.vue";

createApp({
    components : {
        UsersIndex
    }
}).use(router).mount('#app');
