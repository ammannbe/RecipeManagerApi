import ApiClient from "./ApiClient";

export interface IngredientGroup {
    id: number;
    name: string;
}

export default class IngredientGroups extends ApiClient {
    protected url = "/ingredient-groups";

    protected recipeId: number;

    protected rawResponse = false;

    constructor(recipeId: number, rawResponse = false) {
        super();
        this.rawResponse = rawResponse;
        this.recipeId = recipeId;
    }

    public async index(): Promise<IngredientGroup[]> {
        const url = `/recipes/${this.recipeId}${this.url}`;
        return super.get(url) as Promise<IngredientGroup[]>;
    }

    public async store(data: IngredientGroup): Promise<any> {
        const url = `/recipes/${this.recipeId}${this.url}`;
        return super.post(url, data);
    }
}
