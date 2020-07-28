<?php

use App\Models\Recipes\Recipe;
use App\Models\Recipes\Tag;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Recipe::class, 100)->create();

        $tags = Tag::get();

        Recipe::get()->each(function ($recipe) use ($tags) {
            $random = $tags->random(rand(0, 3))->pluck('id');
            $recipe->tags()->attach($random);
        });
    }
}
