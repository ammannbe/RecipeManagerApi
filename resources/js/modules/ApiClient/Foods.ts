import ApiClient from "./ApiClient";

export interface Food {
    id: number;
    name: string;
}

export default class Foods extends ApiClient {
    protected url = "/foods";

    public async index({ trashed = false }): Promise<Food[]> {
        return super.index({ trashed }) as Promise<Food[]>;
    }

    public async show(id: number): Promise<Food> {
        return super.show(id) as Promise<Food>;
    }

    public async store(data: Food): Promise<any> {
        return super.store(data);
    }
}
