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
        Schema::create('ipd_operative_notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ion_id');
            $table->bigInteger('ipd_id')->index();
            $table->date('ion_date')->nullable();
            $table->text('ion_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_operative_notes');
    }
};
