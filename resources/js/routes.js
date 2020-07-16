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
        component: require('./views/Login').default
    },
    {
        path: '/registrieren',
        name: 'register',
        component: require('./views/Register').default
    },
    {
        path: '/email/verifizieren',
        name: 'email.verify',
        component: require('./views/VerifyEmail').default
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
