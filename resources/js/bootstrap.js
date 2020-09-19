import Vue from 'vue';
import VueRouter from 'vue-router';
import MavonEditor from 'mavon-editor';
import Vuex from 'vuex'
import Buefy from 'buefy'
import VueInternationalization from 'vue-i18n';
import VueRx from 'vue-rx'
import VuejsClipper from 'vuejs-clipper'

import './nav';
import env from './env';
import moment from 'moment';
import Loading from './modules/Loading';
import Locale from './modules/Locale';

Locale.init();

window.Vue = Vue;
window.moment = moment;
window.Loading = Loading;

Vue.use(VueRouter);
Vue.use(MavonEditor);
Vue.use(Vuex);
Vue.use(Buefy, { defaultIconPack: 'fas' });
Vue.use(VueInternationalization);
Vue.use(VueRx);
Vue.use(VuejsClipper, {
    components: {
        clipperBasic: true,
        clipperPreview: true,
        clipperUpload: true
    }
});

Vue.prototype.$env = env;
Vue.prototype.$markdownIt = MavonEditor.markdownIt;
Vue.prototype.$moment = moment;
Vue.prototype.$loading = Loading;

Vue.prototype.$autofocus = function (selector = '[autofocus]') {
    const input = document.querySelector(selector);
    if (input) {
        setTimeout(() => {
            input.focus();
        }, 100);
    }
}


Vue.filter('name', function (obj) {
    if (obj == undefined || obj == null || !Object.keys(obj).length) return '';
    return obj.name;
});

Vue.filter('hyphenate', function (value) {
    if (value == undefined || value == null || value == '') {
        return '-';
    }
    return value;
})

Vue.filter('humanReadablePreparationTime', function (value) {
    if (!value) {
        value = '00:00';
    }

    let [hours, minutes] = value.split(":");
    let string = "";
    if (hours > 0) {
        string += `${hours}h`;
    }
    if (minutes > 0) {
        string += ` ${minutes}min`;
    }
    return string;
})
