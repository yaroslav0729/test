<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoPostToOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('do_post')->default(false)->after('do_email');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->removeColumn('do_post');
        });
    }
}
