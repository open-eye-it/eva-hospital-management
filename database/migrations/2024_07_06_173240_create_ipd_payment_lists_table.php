<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipd_payment_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ipl_id');
            $table->bigInteger('ipd_id')->comment('ipd detail id');
            $table->bigInteger('ipl_added_by')->comment('user table id');
            $table->string('ipl_paid_by');
            $table->string('ipl_received_by')->default('cash')->comment('cash/card/mediclaim/corporate');
            $table->integer('ipl_amount')->default(0);
            $table->string('ipl_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_payment_lists');
    }
};
