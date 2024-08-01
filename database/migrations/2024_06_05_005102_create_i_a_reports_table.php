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
        Schema::create('i_a_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            //
            $table->string('ia_owner');
            $table->string('ia_nationality');
            //
            $table->string('ia_dateTime');
            $table->string('ia_injury');
            $table->string('ia_damage');
            $table->string('ia_description');
            $table->string('ia_wasInjured');
            $table->string('ia_ntInjuredReason')->nullable();
            $table->string('ia_agencyInvolved');
            $table->string('ia_agencyPart');
            $table->string('ia_accidentType');
            $table->string('ia_condition');
            $table->string('ia_unsafeAct');
            $table->string('ia_factor');
            //
            $table->string('ia_preventiveMeasure');
            $table->string('ia_safeguard');
            $table->string('ia_useSafeguard');
            $table->string('ia_ntSafeguardReason')->nullable();
            //
            $table->json('ia_affectedWorkers')->nullable();
            $table->integer('ia_affectedWorkers_count');
            //
            $table->string('ia_compensation');
            $table->string('ia_compensation_amount');
            $table->string('ia_medical');
            $table->string('ia_burial');
            $table->string('ia_timeLostDay');
            $table->string('ia_timeLostDay_hours');
            $table->string('ia_timeLostDay_mins');
            $table->string('ia_timeLostSubseq');
            $table->string('ia_timeLostSubseq_hours');
            $table->string('ia_timeLostSubseq_mins');
            $table->string('ia_timeReducedOutput');
            $table->string('ia_timeReducedOutput_days');
            $table->string('ia_timeReducedOutput_percent');
            //
            $table->string('ia_machineryDamage');
            $table->string('ia_machineryDamage_repair');
            $table->string('ia_machineryDamage_time');
            $table->string('ia_machineryDamage_production');
            $table->string('ia_materialDamage');
            $table->string('ia_materialDamage_repair');
            $table->string('ia_materialDamage_time');
            $table->string('ia_materialDamage_production');
            $table->string('ia_equipmentDamage');
            $table->string('ia_equipmentDamage_repair');
            $table->string('ia_equipmentDamage_time');
            $table->string('ia_equipmentDamage_production');
            //
            $table->string('ia_safetyOfficer');
            $table->string('ia_safetyOfficer_id')->nullable();
            $table->string('ia_employer');
            $table->string('ia_employer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_a_reports');
    }
};
