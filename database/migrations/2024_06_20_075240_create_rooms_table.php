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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rm_id')->index();
            $table->bigInteger('rm_added_by');
            $table->bigInteger('rm_updated_by');
            $table->string('rm_building');
            $table->string('rm_floor');
            $table->string('rm_ward');
            $table->string('rm_no')->index();
            $table->integer('rm_charge')->index();
            $table->integer('rm_busy')->default(0)->comment('0-No, 1-Yes');
            $table->integer('rm_status')->default(1)->comment('1-Active, 0-Disable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
