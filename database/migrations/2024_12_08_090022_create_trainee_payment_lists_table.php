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
        Schema::create('trainee_payment_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tpl_id');
            $table->bigInteger('tr_id')->comment('trainee id');
            $table->bigInteger('tpl_added_by');
            $table->text('tpl_desc');
            $table->text('tpl_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_payment_lists');
    }
};
