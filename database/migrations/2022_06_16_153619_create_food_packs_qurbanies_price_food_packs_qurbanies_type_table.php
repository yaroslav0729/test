<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodPacksQurbaniesPriceFoodPacksQurbaniesTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_packs_qurbanies_price_food_packs_qurbanies_type', function (Blueprint $table) {
            $table->foreignId('food_packs_qurbanies_price_id')->onDelete('cascade');
            $table->foreignId('food_packs_qurbanies_type_id')->onDelete('cascade');
            $table->float('price')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_packs_qurbanies_price_food_packs_qurbanies_type');
    }
}
