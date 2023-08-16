<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPagePreviewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_instances', function (Blueprint $table) {
            $table->text('preview_text')
                    ->after('slug')
                    ->nullable();

            $table->string('preview_img')
                    ->after('preview_text')
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
            $table->dropColumn('preview_text', 'preview_img');
        });
    }
}
