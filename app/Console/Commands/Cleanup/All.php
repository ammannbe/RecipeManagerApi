<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\BufferedOutput;

class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup deleted DB rows after the specified time';

    /**
     * The commands that will be executed.
     *
     * @var string
     */
    private $commands = [
        'ingredient-detail',
        'ingredient-detail-group',
        'recipe',
        'category',
        'rating-criterion',
        'user',
        'tag',
        'prep',
        'rating',
        'unit',
        'ingredient',
        'author',
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
        $this->output = new BufferedOutput;

        $output = [];
        foreach ($this->commands as $command) {
            $this->call("cleanup:{$command}");
            $output[] = $this->output->fetch();
        }

        $consoleOutput = new ConsoleOutput();
        foreach ($output as $out) {
            if (! empty($out)) {
                $consoleOutput->writeln($out);
            }
        }
    }

    /**
     * This is the base cleanup method
     *  which can be inherited
     *
     * @param mixed $class Model class to cleanup
     * @param Int $hours = 24 After how much hours the resource should be deleted
     */
    protected static function cleanup($class, Int $hours = 24)
    {
        $consoleOutput = new ConsoleOutput();

        try {
            $class::withTrashed()
                ->where('deleted_at', '<=', Carbon::now()->subHours($hours))
                ->whereNotNull('deleted_at')
                ->forceDelete();

            $classname = class_basename($class);
            $consoleOutput->writeln("{$classname} successfully cleaned up!");
        } catch (\Exception $e) {
            $consoleOutput->writeln($classname . ': ' . $e->getMessage());
        }
    }
}
