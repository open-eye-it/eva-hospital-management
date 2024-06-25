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
        Schema::create('referred_doctors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rd_id');
            $table->bigInteger('rd_added_by');
            $table->bigInteger('rd_updated_by');
            $table->string('rd_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referred_doctors');
    }
};
