<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodPacksQurbaniesTypesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'food_packs_qurbanies_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
        }
        );
    }

    public function down()
    {
        Schema::dropIfExists('food_packs_qurbanies_types');
    }
}
