<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodPacksQurbaniesPagesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'food_packs_qurbanies_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_url')->nullable();
            $table->dateTime('active_at')->nullable();
            $table->timestamps();
        }
        );
    }

    public function down()
    {
        Schema::dropIfExists('food_packs_qurbanies_pages');
    }
}
