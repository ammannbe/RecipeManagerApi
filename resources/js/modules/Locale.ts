import LocalStorage from "./LocalStorage";
import moment from "moment";

export default class Locale {
    protected static locale = navigator.language;

    public static init() {
        let locale = LocalStorage.get("locale");
        if (!locale) {
            locale = this.locale;
        }

        this.set(locale);
    }

    public static get(): string {
        return this.locale;
    }

    public static set(locale: string) {
        this.locale = locale;
        LocalStorage.set("locale", locale);
        document.getElementsByTagName("html")[0].lang = locale;
        moment.locale(locale);
    }
}
