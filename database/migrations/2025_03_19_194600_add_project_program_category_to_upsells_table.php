<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectProgramCategoryToUpsellsTable extends Migration
{
    public function up()
    {
        Schema::table('upsells', function (Blueprint $table) {
            $table->string('project_name')->nullable();
            $table->string('program_name')->nullable();
            $table->unsignedBigInteger('campaign_category_id')->nullable();
            $table->foreign('campaign_category_id')->references('id')->on('campaign_categories');
        });
    }

    public function down()
    {
        Schema::table('upsells', function (Blueprint $table) {
            $table->dropForeign(['campaign_category_id']);
            $table->dropColumn(['project_name', 'program_name', 'campaign_category_id']);
        });
    }
} 