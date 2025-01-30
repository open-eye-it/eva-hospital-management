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
        Schema::create('ipd_pre_operative_medicines', function (Blueprint $table) {
            $table->id();
            $table->text('ipom_id');
            $table->text('ipd_id');
            $table->text('pom_added_by');
            $table->text('pom_updated_by');
            $table->text('recommendation');
            $table->text('description')->nullable();
            $table->tinyInteger('given_or_not')->default(0)->comment('1-yes, 0-no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_pre_operative_medicines');
    }
};
