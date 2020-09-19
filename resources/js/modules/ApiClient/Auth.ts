import ApiClient from "./ApiClient";

export default class Auth extends ApiClient {
    protected url = "/auth";

    public async login(data: {
        email: string;
        password: string;
    }): Promise<any> {
        await this.get("/airlock/csrf-cookie");
        await this.post(`${this.url}/login`, data);
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

    public forgotPassword(data: { email: string }): Promise<void> {
        return this.post(`${this.url}/password/email`, data);
    }

    public resetPassword(data: {
        token: string;
        email: string;
        password: string;
        password_confirmation: string;
    }): Promise<void> {
        return this.post(`${this.url}/password/reset`, data);
    }
}
