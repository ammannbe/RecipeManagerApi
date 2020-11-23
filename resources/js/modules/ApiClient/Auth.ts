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

    public logout(): Promise<void> {
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
        return this.post(`${this.url}/forgot-password`, data);
    }

    public resetPassword(data: {
        token: string;
        email: string;
        password: string;
        password_confirmation: string;
    }): Promise<void> {
        return this.post(`${this.url}/reset-password`, data);
    }

    public resendVerificationEmail(): Promise<void> {
        return this.post(`${this.url}/email/verification-notification`);
    }

    public verifyEmail(url: string): Promise<void> {
        const segments = url.split('/');
        const hash = segments.pop();
        const id = segments.pop();

        return this.get(`${this.url}/email/verify/${id}/${hash}`);
    }
}
