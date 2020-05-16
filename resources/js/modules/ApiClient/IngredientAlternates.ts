import ApiClient from "./ApiClient";

export interface IngredientAlternate {
    id: number;
    name: string;
}

export default class IngredientAlternates extends ApiClient {
    protected url = "/ingredient-alternates";

    public async index(filter: {
        recipeId: number;
    }): Promise<IngredientAlternate[]> {
        return super.get(`/recipes/${filter.recipeId}${this.url}`) as Promise<
            IngredientAlternate[]
        >;
    }

    public async store(data: IngredientAlternate): Promise<any> {
        return super.store(data);
    }
}
