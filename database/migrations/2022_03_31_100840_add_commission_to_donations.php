<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionToDonations extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->float('commission')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('commission');
        });
    }
}
