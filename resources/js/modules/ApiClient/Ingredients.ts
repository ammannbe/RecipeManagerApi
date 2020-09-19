import ApiClient from "./ApiClient";
import { Unit } from "./Units";
import { Food } from "./Foods";
import { IngredientGroup } from "./IngredientGroups";

export interface Ingredient {
    id: number;
    recipe_id: number;
    amount: number;
    amount_max: number;
    unit_id: number;
    unit: Unit;
    food_id: number;
    food: Food;
    ingredient_group_id: number;
    ingredient_group: IngredientGroup;
    ingredient_id: number;
    ingredient: Ingredient;
    position: number;
}

export default class Ingredients extends ApiClient {
    protected url = "/ingredients";
    protected recipeId: number;
    protected rawResponse: boolean;

    constructor(recipeId: number, rawResponse = false) {
        super();
        this.rawResponse = rawResponse;
        this.recipeId = recipeId;
    }

    public async index(filter?: object): Promise<Ingredient[]> {
        return super.get(`/recipes/${this.recipeId}${this.url}`, filter);
    }

    public async store(data: Ingredient): Promise<any> {
        return super.post(`/recipes/${this.recipeId}${this.url}`, data);
    }

    public async remove(id: number): Promise<any> {
        return super.remove(id);
    }
}
