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

    constructor(authorize = true, recipeId: number) {
        super(authorize);
        this.recipeId = recipeId;
    }

    public async index(): Promise<Ingredient[]> {
        return super.get(`/recipes/${this.recipeId}${this.url}`);
    }

    public async store(data: Ingredient): Promise<any> {
        return super.post(`/recipes/${this.recipeId}${this.url}`, data);
    }
}
