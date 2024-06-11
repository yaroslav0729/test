<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaignToFoodPacksQurbaniesPriceFoodPacksQurbaniesTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_packs_qurbanies_price_food_packs_qurbanies_type', function (Blueprint $table) {
            $table->integer('campaign_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_packs_qurbanies_price_food_packs_qurbanies_type', function (Blueprint $table) {
            $table->dropColumn('campaign_id');
        });
    }
}
