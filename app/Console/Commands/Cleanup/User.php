<?php

namespace App\Console\Commands\Cleanup;

use App\Models\User as UserModel;
use Adldap\Laravel\Facades\Adldap;
use App\Console\Commands\Cleanup\All;
use Symfony\Component\Console\Output\ConsoleOutput;

class User extends All
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:user';

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
        $consoleOutput = new ConsoleOutput();

        try {
            Adldap::connect();

            foreach (UserModel::get() as $user) {
                if (!Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $user->username)->first()) {
                    $user->forceDelete();
                }
            }

            $classname = class_basename(UserModel::class);
            $consoleOutput->writeln("{$classname} successfully cleaned up!");
        } catch (\Exception $e) {
            $consoleOutput->writeln($classname . ': ' . $e->getMessage());
        }
    }
}
