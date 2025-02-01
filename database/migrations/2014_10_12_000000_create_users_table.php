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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->biginteger('user_id')->index();
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('person_name')->index();
            $table->text('contactno');
            $table->string('address')->nullable();
            $table->biginteger('added_by');
            $table->biginteger('updated_by');
            $table->integer('user_status')->defaultt(1)->comment('0-disable,1-enable');
            $table->integer('show_to_doctor_list');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
