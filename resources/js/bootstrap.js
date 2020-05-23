import Vue from 'vue';
import VueRouter from 'vue-router';
import MavonEditor from 'mavon-editor';

import './nav';
import env from './env';
import jQuery from 'jquery';

window.$ = jQuery;

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(MavonEditor);

Vue.prototype.$env = env;
Vue.prototype.$markdownIt = MavonEditor.markdownIt;
Vue.prototype.$Laravel = Laravel;

Vue.prototype.$autofocus = function (selector = '[autofocus]') {
    const input = document.querySelector(selector);
    if (input) {
        input.focus();
    }
}
