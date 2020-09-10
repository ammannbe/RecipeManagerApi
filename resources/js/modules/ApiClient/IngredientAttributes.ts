import ApiClient from "./ApiClient";

export interface IngredientAttribute {
    id: number;
    name: string;
}

export default class IngredientAttributes extends ApiClient {
    protected url = "/ingredient-attributes";

    public async index({ trashed = false }): Promise<IngredientAttribute[]> {
        return super.index({ trashed }) as Promise<IngredientAttribute[]>;
    }
}
