<?php

namespace App\Console\Commands\Maintenance;

use App\Models\Recipes\Recipe;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SortIngredientsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ingredients:sort
        {recipe?* : Sort ingredients of one, multiple or all recipes}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reorder ingredients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->getRecipes() as $recipe) {
            $recipe
                ->ingredients()
                ->sorted()
                ->get()
                ->groupBy('ingredient_group_id')
                ->each(function ($ingredients) {
                    $ingredients
                        ->groupBy('ingredient_id')
                        ->each(function ($ingredients) {
                            $position = 1;
                            foreach ($ingredients as $ingredient) {
                                $ingredient->update(['position' => $position]);
                                $position++;
                            }
                        });
                });
        }

        return 0;
    }

    /**
     * Get all or the provided recipes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getRecipes(): Collection
    {
        if ($this->argument('recipe')) {
            /** @var \Illuminate\Database\Eloquent\Collection */
            return Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->find($this->argument('recipe'));
        }

        return Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->get();
    }
}
