<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_containers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {

            $table->unsignedBigInteger('post_container_id')
                    ->after('id');

            $table->foreign('post_container_id')
                    ->references('id')->on('post_containers')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_containers');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('post_container_id');
        });
    }
}
