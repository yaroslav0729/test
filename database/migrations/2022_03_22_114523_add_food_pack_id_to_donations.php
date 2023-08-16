<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodPackIdToDonations extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('food_pack_id')->nullable()->after('campaign_id');
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('food_pack_id');
        });
    }
}
