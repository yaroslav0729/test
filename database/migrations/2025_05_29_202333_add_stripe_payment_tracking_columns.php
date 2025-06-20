<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('stripe_payment_intent_id')->nullable()->after('name');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_payment_intent_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('stripe_payment_intent_id')->nullable()->after('sort_code');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_payment_intent_id');
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
            $table->dropColumn(['stripe_payment_intent_id', 'stripe_subscription_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['stripe_payment_intent_id', 'stripe_subscription_id']);
        });
    }
};
