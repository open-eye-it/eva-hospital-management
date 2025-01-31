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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('pa_id')->index();
            $table->bigInteger('pa_added_by')->comment('user table id user_id');
            $table->bigInteger('pa_updated_by')->comment('user table id user_id');
            $table->string('pa_name')->index();
            $table->string('pa_country_code')->nullable();
            $table->string('pa_dial_code')->nullable();
            $table->string('pa_contact_no')->nullable()->index();
            $table->string('pa_alt_country_code')->nullable();
            $table->string('pa_alt_dial_code')->nullable();
            $table->string('pa_alt_contact_no')->nullable()->index();
            $table->string('pa_email')->nullable()->index();
            $table->string('pa_address')->nullable();
            $table->string('pa_country')->nullable();
            $table->string('pa_pan_card')->nullable();
            $table->string('pa_city')->nullable();
            $table->string('pa_pincode')->nullable();
            $table->string('pa_state')->nullable();
            $table->date('pa_dob')->index();
            $table->string('pa_age')->nullable();
            $table->string('pa_gender')->nullable()->comment('male/female');
            $table->string('pa_marital_status')->nullable()->comment('married/single/divorced/widow');
            $table->string('pa_occupation')->nullable();
            $table->string('pa_last_monestrual_period')->nullable();
            $table->string('pa_pregnancy_no')->nullable();
            $table->string('pa_miscarriages_no')->nullable();
            $table->string('pa_abortion_no')->nullable();
            $table->string('pa_children_no')->nullable();
            $table->json('pa_photo')->nullable();
            $table->string('pa_tobacco')->nullable()->comment('no/regular/occasional');
            $table->string('pa_smoking')->nullable()->comment('no/regular/occasional');
            $table->string('pa_alcohol')->nullable()->comment('no/regular/occasional');
            $table->string('pa_medical_history')->nullable();
            $table->string('pa_family_medical_history')->nullable();
            $table->string('pa_referred_by')->nullable()->comment('doctor/other');
            $table->string('pa_referred_doctor')->nullable();
            $table->string('pa_referred_text')->nullable();
            $table->integer('pa_status')->default(1)->comment('1-active/0-disable');
            $table->text('pa_blood_group')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
