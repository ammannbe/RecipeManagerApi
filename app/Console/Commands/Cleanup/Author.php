<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Author as AuthorModel;
use App\Console\Commands\Cleanup\All;

class Author extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted authors after 24 hours';

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
        parent::cleanup(AuthorModel::class);
    }
}
