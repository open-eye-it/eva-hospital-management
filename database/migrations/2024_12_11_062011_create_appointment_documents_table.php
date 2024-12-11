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
        Schema::create('appointment_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ap_id')->comment('appoointment detail id');
            $table->text('ap_doc_name');
            $table->text('ap_doc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_documents');
    }
};
