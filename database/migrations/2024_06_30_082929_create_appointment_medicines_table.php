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
        Schema::create('appointment_medicines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('am_id');
            $table->bigInteger('ap_id')->comment('appointment id');
            $table->bigInteger('am_added_by');
            $table->bigInteger('gm_id')->index()->comment('General medicine id');
            $table->integer('am_days')->nullable();
            $table->string('am_timing')->nullable()->comment('ex - before food or after food');
            $table->string('am_morning')->default('no')->comment('yes/no');
            $table->string('am_afternoon')->default('no')->comment('yes/no');
            $table->string('am_evening')->default('no')->comment('yes/no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_medicines');
    }
};
