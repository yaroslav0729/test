<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSingleMonthlyEmergencyFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_instances', function (Blueprint $table) {
            $table->boolean('is_single')
                    ->after('actual')
                    ->default(false);

            $table->boolean('is_monthly')
                    ->after('is_single')
                    ->default(false);

            $table->boolean('is_appeal')
                    ->after('is_monthly')
                    ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_instances', function (Blueprint $table) {
            $table->dropColumn('is_single', 'is_monthly', 'is_appeal');
        });
    }
}
