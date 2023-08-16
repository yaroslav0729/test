<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpsellColumnToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->boolean('upsell')->default(false)->after('type');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->boolean('upsell')->default(false)->after('period');
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
            $table->dropColumn('upsell');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('upsell');
        });
    }
}
