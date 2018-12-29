<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Disable FK check to allow truncate...
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // "normal" tables
        $this->call(AuthorsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CookbooksTableSeeder::class);
        $this->call(IngredientDetailsTableSeeder::class);
        $this->call(IngredientsTableSeeder::class);
        $this->call(PrepsTableSeeder::class);
        $this->call(RecipesTableSeeder::class);
        $this->call(RatingCriteriaTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $faker = \Faker\Factory::create();

        DB::table('category_recipe')->truncate();
        for ($i = 0; $i < 50; $i++) {
            DB::table('category_recipe')->insert([
                'recipe_id' => rand(1, 50),
                'category_id' => rand(1, 50),
            ]);
        }

        // ...and enable FK check again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
