<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaignFieldsToFoodPacksPrices extends Migration
{
    public function up()
    {
        Schema::table('food_packs_prices', function (Blueprint $table) {
            $table->string('campaign_name')->nullable();
            $table->string('project_name')->nullable();
            $table->string('program_name')->nullable();
            $table->unsignedBigInteger('campaign_category_id')->nullable();
            $table->foreign('campaign_category_id')->references('id')->on('campaign_categories')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('food_packs_prices', function (Blueprint $table) {
            $table->dropForeign(['campaign_category_id']);
            $table->dropColumn(['campaign_name', 'project_name', 'program_name', 'campaign_category_id']);
        });
    }
} 