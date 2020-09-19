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
    protected url = "/users";

    public show(): Promise<User> {
        const url = "/user";
        return this.get(url) as Promise<User>;
    }

    public patch(key: string, value: string | number | boolean): Promise<User> {
        return this.patch(key, value);
    }
}
