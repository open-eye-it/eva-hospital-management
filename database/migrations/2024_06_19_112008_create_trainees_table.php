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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tr_id');
            $table->bigInteger('tr_added_by')->comment('user table id user_id');
            $table->bigInteger('tr_updated_by')->comment('first time same as tr_added_by and next time updated user_id');
            $table->bigInteger('tr_real_id');
            $table->string('tr_name')->index();
            $table->string('tr_address');
            $table->string('tr_contact_no')->index();
            $table->date('tr_start_date')->index();
            $table->date('tr_end_date')->index();
            $table->integer('tr_total_amount');
            $table->integer('tr_paid_amount')->nullable();
            $table->integer('tr_is_advance_received')->default(0)->comment('0-no, 1-yes');
            $table->date('tr_advance_received_date')->nullable();
            $table->text('tr_remarks')->nullable();
            $table->json('tr_documents')->nullable();
            $table->integer('tr_status')->index()->default(1)->comment('1-pending, 2-completed, 3-cancelled');
            $table->text('tr_reason_cancel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
