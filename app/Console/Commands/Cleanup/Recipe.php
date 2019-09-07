<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Console\Commands\Cleanup\All;
use App\Models\Recipe as RecipeModel;
use Symfony\Component\Console\Output\ConsoleOutput;

class Recipe extends All
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
    protected $description = 'Cleanup deleted recipes after 7 days';

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
        $consoleOutput = new ConsoleOutput();

        try {
            $recipes = RecipeModel::withTrashed()
                ->where('deleted_at', '<=', Carbon::now()->subDays(7))
                ->whereNotNull('deleted_at');

            foreach ($recipes->get() as $recipe) {
                if ($recipe->photo) {
                    File::delete(public_path() . '/images/recipes/' . $recipe->photo);
                }
            }
            $recipes->forceDelete();

            $classname = class_basename(RecipeModel::class);
            $consoleOutput->writeln("{$classname} successfully cleaned up!");
        } catch (\Exception $e) {
            $consoleOutput->writeln($classname . ': ' . $e->getMessage());
        }
    }
}
