<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignCampaignPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_campaign_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('campaign_price_id');
            $table->timestamps();

            $table->foreign('campaign_id')
                    ->references('id')->on('campaigns')
                    ->onDelete('cascade');

            $table->foreign('campaign_price_id')
                    ->references('id')->on('campaign_prices')
                    ->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_campaign_price');
    }
}
