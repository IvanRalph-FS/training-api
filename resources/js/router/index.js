import {createRouter, createWebHistory} from "vue-router";

import UsersIndex from "../Components/UsersIndex.vue";

const routes = [
    {
        path : '/users',
        name : 'users.index',
        component: UsersIndex
    }
];

export default createRouter({
    history : createWebHistory(),
    routes,
});
