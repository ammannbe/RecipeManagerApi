<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\IngredientDetailGroup as IngredientDetailGroupModel;

class IngredientDetailGroup extends Command
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
        IngredientDetailGroupModel::withTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subHours(24))
            ->whereNotNull('deleted_at')
            ->forceDelete();
    }
}
