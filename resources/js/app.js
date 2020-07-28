import './bootstrap';
import router from './routes';
import store from './store'
import VueI18n from 'vue-i18n';
import messages from './vue-i18n-locales.generated';
import Locale from './modules/Locale';

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const i18n = new VueI18n({
    locale: Locale.get(),
    messages
});

new Vue({ el: '#app', router, store, i18n });
