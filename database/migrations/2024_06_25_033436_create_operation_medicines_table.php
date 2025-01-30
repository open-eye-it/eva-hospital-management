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
        Schema::create('operation_medicines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('om_id')->index();
            $table->bigInteger('om_added_by');
            $table->bigInteger('om_updated_by');
            $table->string('om_name')->index();
            $table->string('om_company_name')->nullable()->index();
            $table->text('om_description')->nullable();
            $table->integer('om_status')->default(1)->comment('1-active, 0-disable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_medicines');
    }
};
