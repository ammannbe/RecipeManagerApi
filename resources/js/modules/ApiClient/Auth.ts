import ApiClient from "./ApiClient";
import LocalStorage from "../LocalStorage";

export default class Auth extends ApiClient {
    protected url = "/auth";

    public async login(data: {
        email: string;
        password: string;
    }): Promise<any> {
        try {
            const auth = await this.post(`${this.url}/login`, data);
            LocalStorage.set("auth.access_token", auth.access_token);
            LocalStorage.set("auth.expires_at", auth.expires_at);
            LocalStorage.set("auth.issued_at", auth.issued_at);
            return Promise.resolve(auth);
        } catch (error) {
            return Promise.reject(error);
        }
    }

    public async logout(): Promise<void> {
        try {
            await this.post(`${this.url}/logout`);
        } catch (error) {}

        LocalStorage.remove([
            "auth.access_token",
            "auth.access_token",
            "auth.issued_at"
        ]);
    }

    public static isValid(): boolean {
        // Both dates are converted to UTC
        var auth = new Date(LocalStorage.get("auth.expires_at") || 0);
        var now = new Date();
        return (
            LocalStorage.exists("auth.access_token") &&
            LocalStorage.exists("auth.expires_at") &&
            now < auth
        );
    }

    public register(data: {
        name: string;
        email: string;
        password: string;
        password_confirmation: string;
    }): Promise<void> {
        return this.post(`${this.url}/register`, data);
    }
}
