<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignPageRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_page_instance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_instance_id');
            $table->unsignedBigInteger('campaign_id');
            $table->timestamps();

            $table->foreign('page_instance_id')
                    ->references('id')->on('page_instances')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('campaign_page_instance');
    }
}
