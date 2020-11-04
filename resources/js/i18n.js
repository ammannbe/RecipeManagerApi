import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import VueI18n from 'vue-i18n';
import Locale from './modules/Locale';

export default new VueI18n({
    locale: Locale.get(),
    messages: languageBundle
});
