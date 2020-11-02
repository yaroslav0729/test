<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_containers', function (Blueprint $table) {
            $table->integer('status')
                    ->after('id')
                    ->default(App\Models\PostContainer::POST_STATUS_PUBLICHED);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_containers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
