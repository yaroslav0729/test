<?php

namespace App\Console\Commands;

use App\Models\User;
use DB;
use Illuminate\Console\Command;
use Carbon\Carbon;

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

        return isset($attr->meta_value) ? $attr->meta_value : '';
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

            $localUser->title = $this->getDataAttr($wpUserData, 'cf_title');
            $localUser->address_1 = $this->getDataAttr($wpUserData, 'cf_address_1');
            $localUser->address_2 = $this->getDataAttr($wpUserData, 'cf_address_2');
            $localUser->city = $this->getDataAttr($wpUserData, 'cf_city');
            $localUser->post_code = $this->getDataAttr($wpUserData, 'cf_postcode');
            $localUser->phone = $this->getDataAttr($wpUserData, 'cf_telephone');
            $localUser->country = $this->getDataAttr($wpUserData, 'cf_country');
            $birthday = $this->getDataAttr($wpUserData, 'cf_birthday');
            
            if (!empty($birthday)) {
                $birthday = '16/02/1988';
                $date = Carbon::createFromFormat('d/m/Y', $birthday);

                $localUser->birthday = $date;
            }
                   
            $localUser->save();
        }
    }

}
