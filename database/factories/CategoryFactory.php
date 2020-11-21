<?php

namespace Database\Factories;

use App\Models\Recipes\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use \FakerRestaurant\Provider\de_AT\Restaurant as FakerRestaurant;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Some example category names.
     *
     * @var array
     */
    protected $categories = [
        'Apéros',
        'Brotaufstrich',
        'Brote',
        'Brotspeisen',
        'Cakes, Kuchen, Torten (süss)',
        'Cremen, Desserts, Eis, Puddinge',
        'Eierspeisen',
        'Eingemachtes',
        'Fleischgerichte',
        'Getränke',
        'Guetsli, Kleingebäck, Pâtisserie',
        'Saucen',
        'Sirup',
        'Suppen',
        'Süsse Gerichte',
        'Teigwarengerichte',
        'Vegetarisch',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerRestaurant(($this->faker)));

        return [
            'name' => $this->faker->unique()->randomElement($this->categories),
        ];
    }
}
