import VueRouter from 'vue-router';
import env from './env';

let routes = [
    {
        path: '/',
        name: 'home',
        component: require('./views/Home').default
    },
    {
        path: '/login',
        name: 'login',
        component: require('./views/Auth/Login').default
    },
    {
        path: '/email/verify',
        name: 'email.verify',
        component: require('./views/Auth/VerifyEmail').default
    },
    {
        path: '/password/reset',
        name: 'password.forgot',
        component: require('./views/Auth/ForgotPassword').default
    },
    {
        path: '/password/reset/:token',
        name: 'password.reset',
        component: require('./views/Auth/ResetPassword').default,
        props: true
    },
    {
        path: '/account',
        name: 'account',
        component: require('./views/Account').default
    },
    {
        path: '/recipes/:id/:slug',
        name: 'recipes',
        component: require('./views/Recipe').default,
        props: true
    },
    {
        path: '/recipes/add',
        name: 'recipes.add',
        component: require('./views/AddRecipe/Index').default
    }
];

if (!env.DISABLE_COOKBOOK) {
    routes.push({
        path: '/cookbook/add',
        name: 'cookbooks.add',
        component: require('./views/AddCookbook').default
    });
}

if (!env.DISABLE_REGISTRATION) {
    routes.push({
        path: '/register',
        name: 'register',
        component: require('./views/Auth/Register').default
    });
}

export default new VueRouter({
    routes,
    linkActiveClass: 'is-active',
    mode: 'history'
});
