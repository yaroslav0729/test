<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodPacksQurbaniesPricesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'food_packs_qurbanies_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->nullOnDelete();
            $table->timestamps();
        }
        );
    }

    public function down()
    {
        Schema::dropIfExists('food_packs_qurbanies_prices');
    }
}
