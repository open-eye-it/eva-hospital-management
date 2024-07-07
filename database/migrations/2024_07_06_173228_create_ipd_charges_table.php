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
        Schema::create('ipd_charges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ic_id');
            $table->bigInteger('ipd_id')->comment('ipd detail id');
            $table->bigInteger('ic_added_by')->comment('user table id');
            $table->string('ic_text');
            $table->integer('ic_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_charges');
    }
};
