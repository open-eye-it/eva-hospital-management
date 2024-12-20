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
        Schema::create('indoor_sheets', function (Blueprint $table) {
            $table->id();
            $table->biginteger('is_id');
            $table->biginteger('ipd_id');
            $table->biginteger('is_added_by');
            $table->date('is_date');
            $table->text('is_findings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indoor_sheets');
    }
};
