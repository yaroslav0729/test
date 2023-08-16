<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('gift_aid')->default(false);
            $table->boolean('do_calls')->default(false);
            $table->boolean('do_sms')->default(false);
            $table->boolean('do_email')->default(false);
            $table->string('pay_with')->nullable();
            $table->string('order_id')->nullable();
            $table->unsignedBigInteger('wp_id')->nullable();
            $table->timestamps();
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')
                    ->unsigned()
                    ->after('id')
                    ->nullable();

            $table->foreign('order_id')
                    ->references('id')->on('orders')
                    ->onDelete('set null');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign('donations_order_id_foreign');
            $table->dropColumn('order_id');
        });

        Schema::dropIfExists('orders');
    }
}
