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
        Schema::create('appointment_additional_charges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('apac_id');
            $table->bigInteger('ap_id')->index()->comment('appointment table id');
            $table->bigInteger('apac_added_by')->comment('user id');
            $table->string('apac_desc');
            $table->string('apac_qty');
            $table->string('apac_charge')->comment('single quantity charge');
            $table->string('apac_final_charge')->comment('charge muliply with quantity');
            $table->string('apac_payment_mode')->default('cash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_additional_charges');
    }
};
