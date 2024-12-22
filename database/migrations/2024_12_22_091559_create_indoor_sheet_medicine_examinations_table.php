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
        Schema::create('indoor_sheet_medicine_examinations', function (Blueprint $table) {
            $table->id();
            $table->text('isme_id');
            $table->text('is_id');
            $table->text('ism_recommendation');
            $table->datetime('isme_given_datetime')->nullable();
            $table->datetime('isme_created_datetime');
            $table->text('remark')->nullable();
            $table->text('isme_added_by')->comment('user id who has add deta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indoor_sheet_medicine_examinations');
    }
};
