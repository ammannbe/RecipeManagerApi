import Vue from "vue";

export default class Loading {
    private static loader: any = null;

    public static open(container = null) {
        if (this.loader) {
            return;
        }
        this.loader = Vue.prototype.$buefy.loading.open({ container });
    }

    public static close() {
        if (!this.loader) {
            return;
        }

        this.loader.close();
        this.loader = null;
    }
}
