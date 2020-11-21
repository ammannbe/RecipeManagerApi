<?php

namespace Database\Factories;

use App\Models\Ingredients\Food;
use Illuminate\Database\Eloquent\Factories\Factory;
use \FakerRestaurant\Provider\de_AT\Restaurant as FakerRestaurant;

class FoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerRestaurant(($this->faker)));

        return [
            'name' => $this->faker->unique()->foodName(),
        ];
    }
}
