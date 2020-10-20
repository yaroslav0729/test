<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAnAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan admin_user:make 1
     * 
     * @var string
     */
    protected $signature = 'admin_user:make {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to user';

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
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $user = User::where('id',1)->firstOrFail();
        $user->syncRoles([User::ROLE_ADMIN]);

        $this->info('User id: ' . $id . ' is admin now');

        return;
    }
}
