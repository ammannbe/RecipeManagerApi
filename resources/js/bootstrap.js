import Vue from 'vue';
import VueRouter from 'vue-router';
import MavonEditor from 'mavon-editor';
import Vuex from 'vuex'

import './nav';
import env from './env';
import jQuery from 'jquery';
import moment from 'moment';
moment.locale('de');

window.Vue = Vue;
window.$ = jQuery;
window.moment = moment;

Vue.use(VueRouter);
Vue.use(MavonEditor);
Vue.use(Vuex)

Vue.prototype.$env = env;
Vue.prototype.$markdownIt = MavonEditor.markdownIt;
Vue.prototype.$Laravel = Laravel;
Vue.prototype.$moment = moment;

Vue.prototype.$autofocus = function (selector = '[autofocus]') {
    const input = document.querySelector(selector);
    if (input) {
        input.focus();
    }
}
