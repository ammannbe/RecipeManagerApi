export default class LocalStorage {
    protected static storage: Storage = localStorage;

    public static get(key: string): any {
        return JSON.parse(this.storage.getItem(key) || "null");
    }

    public static set(key: string, value: any): void {
        this.storage.setItem(key, JSON.stringify(value));
    }

    public static update(key: string, property: string, value: any): void {
        let el = this.get(key);
        if (typeof el === "object" && el !== null) {
            el[property] = value;
        }
        if (el === null) {
            el = { [property]: value };
        }
        this.set(key, el);
    }

    public static exists(key: string): boolean {
        return !!this.get(key);
    }

    public static remove(keys: string[]): void {
        keys.forEach(key => {
            this.storage.removeItem(key);
        });
    }
}
