<?php

namespace Database\Factories\Ratings;

use App\Models\Users\User;
use App\Models\Ratings\Rating;
use App\Models\Recipes\Recipe;
use App\Models\Ratings\RatingCriterion;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recipe_id' => Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->inRandomOrder()->first()->id,
            'user_id' => $this->faker->randomElement([null, User::inRandomOrder()->first()->id]),
            'rating_criterion_id' => RatingCriterion::inRandomOrder()->first()->id,
            'comment' => $this->faker->text,
            'stars' => $this->faker->randomElement([null, $this->faker->randomDigit]),
        ];
    }
}
