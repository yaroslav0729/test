<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodPackQurbaniIdToCartItems extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->integer('food_pack_qurbani_id')->nullable()->after('food_pack_id');
            $table->integer('food_pack_qurbani_type_id')->nullable()->after('food_pack_qurbani_id');
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('food_pack_qurbani_id');
            $table->dropColumn('food_pack_qurbani_type_id');
        });
    }
}
