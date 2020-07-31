<?php

namespace App\Console\Commands\Maintenance;

use Illuminate\Console\Command;

class CleanupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:database
        {--all : Run command on all possible tables}
        {--table=* : Run command on specific table, possible values are: ingredients, ingredient_groups, recipes, categories, rating_criteria, users, tags, ingredient_attributes, ratings, units, foods, authors, cookbooks}
        {--days=30 : Amount of days to preserve the soft deletes}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup soft deleted entries';

    /**
     * All tables to cleanup
     *
     * @var array
     */
    protected $tables = [
        'ingredients',
        'ingredient_groups',
        'recipes',
        'categories',
        'rating_criteria',
        'users',
        'tags',
        'ingredient_attributes',
        'ratings',
        'units',
        'foods',
        'authors',
        'cookbooks',
    ];

    /**
     * Possible models to cleanup
     *
     * @var array
     */
    protected $models = [
        'ingredients' => 'App\Models\Ingredients\Ingredient',
        'ingredient_groups' => 'App\Models\Ingredients\IngredientGroup',
        'recipes' => 'App\Models\Recipes\Recipe',
        'categories' => 'App\Models\Recipes\Recipe',
        'rating_criteria' => 'App\Models\Ratings\RatingCriterion',
        'users' => 'App\Models\Users\User',
        'tags' => 'App\Models\Recipes\Tag',
        'ingredient_attributes' => 'App\Models\Ingredients\IngredientAttribute',
        'ratings' => 'App\Models\Ratings\Rating',
        'units' => 'App\Models\Ingredients\Unit',
        'foods' => 'App\Models\Ingredients\Food',
        'authors' => 'App\Models\Users\Author',
        'cookbooks' => 'App\Models\Recipes\Cookbook',
    ];

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
     * @return mixed
     */
    public function handle()
    {
        $days = $this->getDays();

        $tables = $this->getTables();

        $this->cleanup($tables, $days);
    }

    /**
     * Get the amount of days to preserve the soft deletes
     *
     * @return int
     */
    protected function getDays(): int
    {
        $days = $this->option('days');
        if (!is_string($days)) {
            $this->error('The days option must be a number!');
            exit(1);
        }
        return (int) $days;
    }

    /**
     * Get the tables to cleanup
     *
     * @return array
     */
    protected function getTables(): array
    {
        if ($this->option('table') && is_array($this->option('table'))) {
            return $this->option('table');
        }

        if ($this->option('all')) {
            return $this->tables;
        }

        $response = null;
        while (!$response) {
            $response = $this->ask('Which table(s) you would you like to cleanup? (comma separated list)');
        }
        return explode(',', $response);
    }

    /**
     * Validate and cleanup given tables
     *
     * @param  array  $tables
     * @param  int  $days
     * @return void
     */
    protected function cleanup(array $tables, int $days): void
    {
        $bar = $this->output->createProgressBar(count($tables));

        foreach ($tables as $table) {
            $this->validateTable($table);
        }

        $this->info('Start cleanup...');
        foreach ($tables as $table) {
            $bar->setMessage("Cleanup {$table}");
            try {
                $this->cleanupTable($table, $days);
            } catch (\Exception $e) {
                $this->error("Could not delete: {$e}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info(' Done.');
    }

    /**
     * Validate if table exists
     *
     * @param  string  $table
     * @return void
     */
    protected function validateTable(string $table): void
    {
        if (!isset($this->models[$table])) {
            $this->error("Table '{$table}' does not exists!");
            exit(1);
        }
    }

    /**
     * Cleanup table
     *
     * @param  string  $table
     * @param  int  $days
     * @return void
     */
    protected function cleanupTable(string $table, int $days): void
    {
        $class = $this->models[$table];
        $class::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays($days))
            ->forceDelete();
    }
}
