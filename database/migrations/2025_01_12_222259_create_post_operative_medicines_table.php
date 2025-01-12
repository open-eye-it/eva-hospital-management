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
        Schema::create('post_operative_medicines', function (Blueprint $table) {
            $table->id();
            $table->text('poom_id');
            $table->text('poom_added_by');
            $table->text('poom_updated_by');
            $table->text('recommendation');
            $table->integer('poom_status')->default(1)->comment('1-active, 0-disable	');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppost_operative_medicines');
    }
};
