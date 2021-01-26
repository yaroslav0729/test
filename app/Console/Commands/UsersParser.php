<?php

namespace App\Console\Commands;

use App\Models\User;
use DB;
use Illuminate\Console\Command;

class UsersParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:users
     *
     * @var string
     */
    protected $signature = 'parse:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $wpConnection;
    public $users;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->wpConnection = DB::connection('wp');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Users parser started');

        $this->getAllWpUsers();
        $this->createOrUpdateUsers();

        $this->info('Command complete');
    }

    protected function getAllWpUsers()
    {
        $this->users = $this->wpConnection->table('wp_users')
            ->get();
    }

    protected function getWpUserAdditionalData($wpUserId)
    {
        return $this->wpConnection->table('wp_usermeta')
            ->where('user_id', $wpUserId)
            ->get();
    }

    protected function getDataAttr($userData, $attrName)
    {
        $attr = $userData->where('meta_key', $attrName)->first();

        return $attr->meta_value ? $attr->meta_value : '';
    }

    protected function createOrUpdateUsers()
    {
        $cou = count($this->users);

        foreach ($this->users as $key => $wpUser) {

            $localUser = User::where('email', $wpUser->user_email)->first();

            if ($localUser) {
                $this->info($key + 1 . ' from ' . $cou . ' - Update user with email: ' . $wpUser->user_email);

            } else {
                $this->info($key + 1 . ' from ' . $cou . ' - Create user with email: ' . $wpUser->user_email);

                $localUser = User::create([
                    'email' => $wpUser->user_email,
                    'password' => $wpUser->user_pass,
                    'created_at' => $wpUser->user_registered,
                    'name' => '',
                ]);
            }

            $wpUserData = $this->getWpUserAdditionalData($wpUser->ID);

            $localUser->wp_id = $wpUser->ID;
            $localUser->password = $wpUser->user_pass;
            $localUser->created_at = $wpUser->user_registered;
            $localUser->name = $this->getDataAttr($wpUserData, 'first_name');
            $localUser->last_name = $this->getDataAttr($wpUserData, 'last_name');
            $localUser->save();
        }
    }

}
