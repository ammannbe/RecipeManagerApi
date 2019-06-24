<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Rating as RatingModel;
use App\Console\Commands\Cleanup\All;

class Rating extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted ratings after 24 hours';

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
        parent::cleanup(RatingModel::class);
    }
}
