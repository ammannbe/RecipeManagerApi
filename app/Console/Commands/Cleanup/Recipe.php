<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use App\Models\Recipe as RecipeModel;
use Illuminate\Console\Command;

class Recipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:recipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted ingredient detail groups after 7 days';

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
        RecipeModel::withTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subDays(7))
            ->whereNotNull('deleted_at')
            ->get();
    }
}
