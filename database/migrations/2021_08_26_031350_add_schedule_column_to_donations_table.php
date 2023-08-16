<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleColumnToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('schedule')->after('note')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('account_number')->after('pay_with')->nullable();
            $table->integer('sort_code')->after('pay_with')->nullable();
            $table->string('pay_day')->after('pay_with')->nullable();
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
            $table->dropColumn('schedule');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('account_number');
            $table->dropColumn('sort_code');
            $table->dropColumn('pay_day');
        });
    }
}
