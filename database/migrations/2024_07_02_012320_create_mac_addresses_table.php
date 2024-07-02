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
        Schema::create('mac_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ma_id');
            $table->string('ma_pc_name')->index();
            $table->string('ma_address')->index();
            $table->integer('ma_status')->default(1)->comment('0-disable/1-enable');
            $table->bigInteger('ma_added_by');
            $table->bigInteger('ma_updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mac_addresses');
    }
};
