import VueRouter from 'vue-router';
import env from './env';

let routes = [
    {
        path: '/',
        name: 'home',
        component: require('./views/Home/Index').default
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
        props: route => ({ params: { ...route.query, ...route.params } })
    },
    {
        path: '/account',
        name: 'account',
        component: require('./views/Account/Index').default
    },
    {
        path: '/recipes/:id/:slug',
        name: 'recipes',
        component: require('./views/Recipe/Index').default,
        props: true
    },
    {
        path: '/recipes/add',
        name: 'recipes.add',
        component: require('./views/Recipe/Add/Index').default
    },
    {
        path: '/admin',
        name: 'admin',
        component: require('./views/Admin/Index').default
    }
];

if (!env.DISABLE_COOKBOOK) {
    routes.push({
        path: '/cookbooks/add',
        name: 'cookbooks.add',
        component: require('./views/Cookbook/Add').default
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
