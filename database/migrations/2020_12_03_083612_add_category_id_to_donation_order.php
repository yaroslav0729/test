<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToDonationOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_category_id')
                    ->after('campaign_id')->nullable();

            $table->foreign('campaign_category_id')
                    ->references('id')->on('campaign_categories')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign('donations_campaign_category_id_foreign');
            $table->dropColumn('campaign_category_id');
        });
    }
}
