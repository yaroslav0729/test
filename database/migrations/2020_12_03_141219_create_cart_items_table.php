<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->unsigned();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->unsignedBigInteger('campaign_category_id')->nullable();
            $table->string('period');
            $table->string('cart_item_id')->nullable();
            $table->timestamps();

            $table->foreign('campaign_id')
                    ->references('id')->on('campaigns')
                    ->onDelete('set null');

            $table->foreign('campaign_category_id')
                    ->references('id')->on('campaign_categories')
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
        Schema::dropIfExists('cart_items');
    }
}
