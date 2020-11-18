<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->tinyInteger('type');
            $table->unsignedBigInteger('campaign_id');
            $table->timestamps();

            $table->foreign('campaign_id')
                    ->references('id')->on('campaigns')
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
        Schema::dropIfExists('campaign_prices');
    }
}
