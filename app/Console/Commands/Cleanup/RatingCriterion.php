<?php

namespace App\Console\Commands\Cleanup;

use App\Models\RatingCriterion as RatingCriterionModel;
use App\Console\Commands\Cleanup\All;

class RatingCriterion extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:rating-criterion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted rating criteria after 24 hours';

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
        parent::cleanup(RatingCriterionModel::class);
    }
}
