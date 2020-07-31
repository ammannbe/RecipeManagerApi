<?php

namespace App\Console\Commands\Maintenance;

use App\Models\Ingredients\Ingredient;
use App\Models\Recipes\Recipe;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class DatabaseIntegrityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrity:check
        {--fix : Resolve located problems automatically}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database integrities and output problematic ID\'s';

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
        $this->validateZeroValuesRecipeYieldAmount();
        $this->validateZeroValuesIngredientAmount();
        $this->validateZeroValuesIngredientAmountMax();

        return 0;
    }

    /**
     * Check if the query spit results out
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return bool
     */
    private function hasProblems(Builder $query): bool
    {
        $count = $query->count();

        if (!$count) {
            $this->info('No problems found!');
            return false;
        }

        $ids = $query->pluck('id')->implode(', ');
        $this->error("Problems found: {$count} (ID's: {$ids})");

        return (bool) $count;
    }

    /**
     * Fix (update) the query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $update
     * @return void
     */
    private function fix(Builder $query, array $update): void
    {
        if (!$this->option('fix')) {
            return;
        }

        $this->line('Automatically resolve it');
        $query->update($update);
        $this->info('Done');
    }

    /**
     * Validate if recipe.yield_amount has wrong zero-values
     *
     * @return void
     */
    protected function validateZeroValuesRecipeYieldAmount(): void
    {
        $this->line('Validate: recipes.yield_amount == 0');

        $query = Recipe::whereYieldAmount(0);

        if ($this->hasProblems($query)) {
            $this->fix($query, ['yield_amount' => null]);
        }
    }

    /**
     * Validate if ingredients.amount has wrong zero-values
     *
     * @return void
     */
    protected function validateZeroValuesIngredientAmount(): void
    {
        $this->line('Validate: ingredients.amount == 0 && ingredients.amount_max == 0|NULL');

        $query = Ingredient::whereAmount(0)->where(function ($q) {
            return $q->whereAmountMax(0)->orWhereNull('amount_max');
        });

        if ($this->hasProblems($query)) {
            $this->fix($query, ['amount' => null]);
        }
    }

    /**
     * Validate if ingredients.amount_max has wrong zero-values
     *
     * @return void
     */
    protected function validateZeroValuesIngredientAmountMax(): void
    {
        $this->line('Validate: ingredients.amount_max == 0');

        $query = Ingredient::whereAmountMax(0);

        if ($this->hasProblems($query)) {
            $this->fix($query, ['amount_max' => null]);
        }
    }
}
