<?php

namespace Database\Factories;

use App\Models\Recipes\Recipe;
use App\Models\Ingredients\IngredientGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IngredientGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recipe_id' => Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->inRandomOrder()->first()->id,
            'name' => $this->faker->unique(true)->word,
        ];
    }
}
