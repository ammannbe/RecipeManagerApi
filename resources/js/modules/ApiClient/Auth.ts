import ApiClient from "./ApiClient";
import LocalStorage from "../LocalStorage";

export default class Auth extends ApiClient {
    protected url = "/auth";

    public async login(data: {
        email: string;
        password: string;
    }): Promise<any> {
        try {
            await this.get("/airlock/csrf-cookie");
            await this.post(`${this.url}/login`, data);
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    }

    public async logout(): Promise<void> {
        return this.post(`${this.url}/logout`);
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
