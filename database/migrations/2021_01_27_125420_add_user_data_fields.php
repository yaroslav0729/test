<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDataFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->after('last_name')->nullable();
            $table->date('birthday')->after('facebook_id')->nullable();
            $table->text('address_1')->after('wp_id')->nullable();
            $table->text('address_2')->after('address_1')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->text('city')->after('address_2')->nullable();
            $table->text('country')->after('city')->nullable();
            $table->text('post_code')->after('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('title');
        $table->dropColumn('birthday');
        $table->dropColumn('address_1');
        $table->dropColumn('address_2');
        $table->dropColumn('city');
        $table->dropColumn('country');
        $table->dropColumn('post_code');
        $table->dropColumn('phone');
    }
}
