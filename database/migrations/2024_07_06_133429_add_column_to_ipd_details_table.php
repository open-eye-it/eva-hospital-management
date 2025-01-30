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
        Schema::table('ipd_details', function (Blueprint $table) {
            $table->string('ipd_diagnosis')->nullable()->after('ipd_cancel_reason');
            $table->string('ipd_investigations')->nullable()->after('ipd_diagnosis');
            $table->text('ipd_treatment_given')->nullable()->after('ipd_investigations');
            $table->text('ipd_treatment_discharge')->nullable()->after('ipd_treatment_given');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ipd_details', function (Blueprint $table) {
            $table->dropColumn('ipd_diagnosis');
            $table->dropColumn('ipd_investigations');
            $table->dropColumn('ipd_treatment_given');
            $table->dropColumn('ipd_treatment_discharge');
        });
    }
};
