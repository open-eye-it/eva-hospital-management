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
        Schema::create('ipd_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ipd_id');
            $table->bigInteger('ipd_added_by');
            $table->bigInteger('ipd_updated_by');
            $table->string('pa_id')->index();
            $table->date('ipd_admit_date')->index();
            $table->bigInteger('ipd_doctor')->comment('user id of doctor');
            $table->date('ipd_surgery_date')->nullable();
            $table->string('ipd_surgery_text')->nullable();
            $table->bigInteger('rm_id')->comment('Room id');
            $table->string('ipd_status')->default('admit')->comment('admit/discharge/cancel');
            $table->date('ipd_discharge_date')->nullable()->comment('when status discharge');
            $table->string('ipd_cancel_reason')->nullable();
            $table->string('ipd_bill_amount')->default(0);
            $table->string('ipd_received_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_details');
    }
};
