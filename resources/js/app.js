import './bootstrap';
import router from './routes';
import store from './store'

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('multiselect', require('vue-multiselect').default);

new Vue({
    el: '#app',
    router,
    store
});
