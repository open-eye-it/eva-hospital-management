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
        Schema::create('general_medicines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gm_id')->index();
            $table->bigInteger('gm_added_by');
            $table->bigInteger('gm_updated_by');
            $table->string('gm_name')->index();
            $table->string('gm_company_name')->nullble()->index();
            $table->text('gm_description')->nullable();
            $table->integer('gm_status')->default(1)->comment('1-active, 0-disable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_medicines');
    }
};
