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
        Schema::create('ipd_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ipd_id')->comment('ipd detail id');
            $table->text('ipd_doc_name');
            $table->text('ipd_doc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_documents');
    }
};
