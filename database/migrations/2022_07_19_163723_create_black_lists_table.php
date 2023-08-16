<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackListsTable extends Migration
{
    public function up()
    {
        Schema::create('black_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('black_lists');
    }
}
