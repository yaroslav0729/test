<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTmpsTable extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_tmps', function (Blueprint $table) {
            $table->id();
            $table->string('customer_email');
            $table->string('type')->nullable();
            $table->json('payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_tmps');
    }
}
