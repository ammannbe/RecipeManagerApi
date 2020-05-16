import ApiClient from "./ApiClient";

export interface Cookbook {
    id: number;
    name: string;
}

export default class Cookbooks extends ApiClient {
    protected url = "/cookbooks";

    public async index(): Promise<Cookbook[]> {
        return super.index();
    }

    public async show(id: number): Promise<Cookbook> {
        return super.show(id);
    }

    public async store(data: Cookbook): Promise<string> {
        return super.store(data);
    }
}
