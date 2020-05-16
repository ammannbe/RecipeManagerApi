import ApiClient from "./ApiClient";

export interface IngredientGroup {
    id: number;
    name: string;
}

export default class IngredientGroups extends ApiClient {
    protected url = "/ingredient-groups";

    public async index(filter: {
        recipeId: number;
    }): Promise<IngredientGroup[]> {
        return super.get(`/recipes/${filter.recipeId}${this.url}`) as Promise<
            IngredientGroup[]
        >;
    }

    public async store(data: IngredientGroup): Promise<any> {
        return super.store(data);
    }
}
