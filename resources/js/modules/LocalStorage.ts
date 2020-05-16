export default class LocalStorage {
    protected static storage: Storage = localStorage;

    public static get(key: string): string | null {
        return this.storage.getItem(key);
    }

    public static set(key: string, value: string): void {
        this.storage.setItem(key, value);
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
