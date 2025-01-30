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
            $table->string('ipd_mediclaim')->default('no')->comment('yes/no')->after('ipd_received_amount');
            $table->string('ipd_is_foc')->default('no')->comment('yes/no')->after('ipd_mediclaim');
            $table->date('ipd_follow_up_date')->nullable()->after('ipd_discharge_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ipd_details', function (Blueprint $table) {
            $table->dropColumn('ipd_mediclaim');
            $table->dropColumn('ipd_is_foc');
            $table->dropColumn('ipd_follow_up_date');
        });
    }
};
