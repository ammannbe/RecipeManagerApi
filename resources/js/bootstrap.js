import Vue from 'vue';
import VueRouter from 'vue-router';
import './nav';
import env from './env';
import jQuery from 'jquery';
import MavonEditor from 'mavon-editor';
import Auth from './modules/ApiClient/Auth'

window.$ = jQuery;

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(MavonEditor);

Vue.prototype.$env = env;
Vue.prototype.$markdownIt = MavonEditor.markdownIt;

Vue.prototype.$autofocus = function (selector = '[autofocus]') {
    const input = document.querySelector(selector);
    if (input) {
        input.focus();
    }
}

Vue.prototype.$isLoggedIn = false;
setInterval(() => {
    Vue.prototype.$isLoggedIn = Auth.isValid();
}, 60000);
