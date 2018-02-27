import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

Vue.use(Router);

const router = new Router({
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
        },
        {
            name: 'dashboard',
            path: '/dashboard',
            component: require('../pages/dashboard/Home.vue'),
        },
        {
            name: 'users',
            path: '/users',
            component: require('../pages/users/Users.vue'),
        },
        {
            name: 'files',
            path: '/files',
            component: require('../pages/files/Files.vue'),
        },
        {
            name: 'settings',
            path: '/settings',
            component: require('../pages/settings/Settings.vue'),
        }
    ],
});

router.beforeEach((to, from, next) => {
    store.commit('showLoader');
    next();
});

router.afterEach((to, from) => {
    setTimeout(()=>{
        store.commit('hideLoader');
    },1000);
});

export default router;