import ApiClient from "./ApiClient";

export interface IngredientAttribute {
    id: number;
    name: string;
}

export default class IngredientAttributes extends ApiClient {
    protected url = "/ingredient-attributes";

    public async index(): Promise<IngredientAttribute[]> {
        return super.index() as Promise<IngredientAttribute[]>;
    }
}
