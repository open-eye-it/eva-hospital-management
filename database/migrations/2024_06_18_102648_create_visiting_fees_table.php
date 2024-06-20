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
        Schema::create('visiting_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vf_id');
            $table->bigInteger('vf_added_by');
            $table->bigInteger('vf_updated_by');
            $table->string('vf_case_type')->comment('old/new/emergency');
            $table->integer('vf_fees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visiting_fees');
    }
};
