<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackToFoodPacksQurbaniesPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_packs_qurbanies_prices', function (Blueprint $table) {
            $table->text('feedback')->nullable(); // Add feedback column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_packs_qurbanies_prices', function (Blueprint $table) {
            $table->dropColumn('feedback'); // Drop feedback column
        });
    }
}
