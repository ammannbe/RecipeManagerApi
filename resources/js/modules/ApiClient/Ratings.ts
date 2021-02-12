import ApiClient from "./ApiClient";

export interface Recipe {
    id: number,
    recipe_id: number,
    user_id: number,
    rating_criterion_id: number,
    comment: string,
    stars: number,
}

export default class Ratings extends ApiClient {
    protected url = "/ratings";
    protected rawResponse: boolean;

    constructor(rawResponse = false) {
        super();
        this.rawResponse = rawResponse;
    }

    public async index(data?: object): Promise<Recipe[]> {
        return super.index(data) as Promise<Recipe[]>;
    }

    public async show(id: number): Promise<any> {
        return super.show(id) as Promise<any>;
    }

    public async store(data: Recipe): Promise<any> {
        return super.store(data, false);
    }
}
