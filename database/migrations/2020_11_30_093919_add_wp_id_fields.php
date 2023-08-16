<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWpIdFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('wp_id')
                    ->after('country_id')
                    ->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('wp_id')
                    ->after('type')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('wp_id');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('wp_id');
        });
    }
}
