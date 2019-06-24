<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use App\Models\IngredientDetailGroup as IngredientDetailGroupModel;
use App\Console\Commands\Cleanup\All;

class IngredientDetailGroup extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:ingredient-detail-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted ingredient detail groups after 24 hours';

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
        parent::cleanup(IngredientDetailGroupModel::class);
    }
}
