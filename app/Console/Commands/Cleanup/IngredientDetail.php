<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\IngredientDetail as IngredientDetailModel;

class IngredientDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:ingredient-detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted ingredient details after 24 hours';

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
        IngredientDetailModel::withTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subHours(24))
            ->whereNotNull('deleted_at')
            ->get();
    }
}
