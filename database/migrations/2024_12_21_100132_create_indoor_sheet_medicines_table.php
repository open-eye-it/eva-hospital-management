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
        Schema::create('indoor_sheet_medicines', function (Blueprint $table) {
            $table->id();
            $table->text('ism_id');
            $table->text('is_id');
            $table->text('ism_recommendation');
            $table->text('ism_added_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indoor_sheet_medicines');
    }
};
