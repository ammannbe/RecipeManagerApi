<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Category as CategoryModel;
use App\Console\Commands\Cleanup\All;

class Category extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted categories after 24 hours';

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
        parent::cleanup(CategoryModel::class);
    }
}
