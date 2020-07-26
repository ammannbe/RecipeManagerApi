import VueRouter from 'vue-router';

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
        path: '/registrieren',
        name: 'register',
        component: require('./views/Auth/Register').default
    },
    {
        path: '/email/verifizieren',
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
        path: '/rezepte/:id/:slug',
        name: 'recipes',
        component: require('./views/Recipe').default,
        props: true
    },
    {
        path: '/rezepte/neu',
        name: 'recipes-add',
        component: require('./views/AddRecipe/Index').default
    },
    {
        path: '/kochbuch/neu',
        name: 'cookbooks-add',
        component: require('./views/AddCookbook').default
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: 'is-active',
    mode: 'history'
});
