import ApiClient from "./ApiClient";

export interface Cookbook {
    id: number;
    name: string;
}

export default class Cookbooks extends ApiClient {
    protected url = "/cookbooks";
    protected rawResponse: boolean;

    constructor(rawResponse = false) {
        super();
        this.rawResponse = rawResponse;
    }

    public async index(filter?: object): Promise<Cookbook[]> {
        return super.index(filter);
    }

    public async show(id: number): Promise<Cookbook> {
        return super.show(id);
    }

    public async store(data: Cookbook): Promise<string> {
        return super.store(data);
    }
}
