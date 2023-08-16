<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpToDonations extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->ipAddress('ip')->after('wp_id');
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->removeColumn('ip');
        });
    }
}
