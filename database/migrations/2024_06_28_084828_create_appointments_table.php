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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ap_id')->index();
            $table->string('pa_id')->index();
            $table->bigInteger('ap_added_by');
            $table->bigInteger('ap_updated_by');
            $table->string('ap_height')->nullable();
            $table->string('ap_weight')->nullable();
            $table->string('ap_bp')->nullable();
            $table->bigInteger('ap_doctor')->index()->comment('user id where role is doctor');
            $table->date('ap_date')->index();
            $table->string('ap_book_via')->nullable();
            $table->string('ap_case_type')->index()->comment('old/new/emergency');
            $table->string('ap_charge');
            $table->string('ap_charge_status')->default('pending')->comment('pending, paid');
            $table->string('ap_additional_charge')->default(0)->comment('additional charge total');
            $table->string('ap_payment_mode')->nullable()->comment('cash/card/mediclaim/corporate');
            $table->string('ap_payment_detail')->nullable();
            $table->string('ap_status')->default('pending')->index()->comment('pending/completed(prescribe)/cancelled');
            $table->string('ap_status_reaason')->nullable();
            $table->text('ap_complaint')->nullable();
            $table->text('ap_other_detail')->nullable();
            $table->text('ap_any_advice')->nullable();
            $table->date('ap_follow_up_date')->nullable();
            $table->string('ap_surg_required')->default('no')->index()->comment('yes/no');
            $table->string('ap_surg_date')->nullable();
            $table->string('ap_surg_type')->nullable();
            $table->string('ap_is_foc')->default('no')->index()->comment('yes/no');
            $table->string('ap_is_workshop')->default('no')->index()->comment('yes/no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
