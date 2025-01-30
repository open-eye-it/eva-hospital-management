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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no_id');
            $table->bigInteger('ap_id')->nullable()->comment('Appointment id');
            $table->bigInteger('ipd_id')->nullable()->comment('IPD id');
            $table->text('no_type')->nullable()->comment('1-opd, 2-ipd');
            $table->text('no_subject')->comment('New Appoitnemtn, New Patient Admit, Patient Discharged');
            $table->text('no_message')->comment('New appointment added');
            $table->text('no_icon')->comment('Notification related icon');
            $table->text('no_action');
            $table->bigInteger('no_created_for')->comment('User ID');
            $table->bigInteger('no_created_by')->comment('User ID');
            $table->integer('no_read')->default(0)->comment('0-unread, 1-read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
