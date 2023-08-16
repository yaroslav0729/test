<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentAtFieldToTempStoreDonationDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_store_donation_data', function (Blueprint $table) {
            $table->timestamp('sent_at')->after('donation_data')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_store_donation_data', function (Blueprint $table) {
            $table->dropColumn('sent_at');
        });
    }
}
