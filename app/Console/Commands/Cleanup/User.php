<?php

namespace App\Console\Commands\Cleanup;

use Illuminate\Console\Command;
use App\Models\User as UserModel;
use Adldap\Laravel\Facades\Adldap;

class User extends Command
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
        try {
            Adldap::connect();

            foreach (UserModel::get() as $user) {
                if (! Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $user->username)->first()) {
                    $user->forceDelete();
                }
            }
        } catch (\Exception $e) {
            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
            $out->writeln($e->getMessage());
        }
    }
}
