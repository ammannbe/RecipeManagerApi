import ApiClient from "./ApiClient";

export interface User {
    id: number;
    email: string;
    name: string;
    admin: boolean;
    created_at: Date;
    updated_at: Date;
}

export default class Users extends ApiClient {
    protected url = "/user";

    public show(): Promise<User> {
        return this.get(this.url) as Promise<User>;
    }
}
