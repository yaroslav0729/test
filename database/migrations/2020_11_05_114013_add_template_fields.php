<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_instances', function (Blueprint $table) {
            $table->integer('template')
                    ->after('keywords')
                    ->unsigned()
                    ->nullable();

            $table->text('parameters')
                    ->after('template')
                    ->nullable();

            $table->text('html')
                    ->after('parameters')
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
        Schema::table('page_instances', function (Blueprint $table) {
            $table->dropColumn('template', 'parameters', 'html');
        });
    }
}
