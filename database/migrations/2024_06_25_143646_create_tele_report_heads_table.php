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
        Schema::create('tele_report_heads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('teleHead_estabId');

            $table->string('teleHead_manageMale');
            $table->integer('teleHead_manageFemale');
            $table->integer('teleHead_superMale');
            $table->integer( 'teleHead_superFemale');
            $table->integer('teleHead_rankMale');
            $table->integer('teleHead_rankFemale');
            $table->integer('teleHead_total');
            $table->integer('teleHead_disabMale');
            $table->integer('teleHead_disabFemale');
            $table->integer('teleHead_soloperMale');
            $table->integer('teleHead_soloperFemale');
            $table->integer('teleHead_immunoMale');
            $table->integer('teleHead_immunoFemale');
            $table->integer('teleHead_mentalMale');
            $table->integer('teleHead_mentalFemale');
            $table->integer('teleHead_seniorMale',);
            $table->integer('teleHead_seniorFemale',);
            $table->integer('teleHead_specialTotal');
            $table->json('teleHead_workspace');
            $table->string('teleHead_workspace_others')->nullable();
            $table->json('teleHead_areasCovered');
            $table->string('teleHead_areasCovered_others')->nullable();
            $table->string('teleHead_program');
            $table->string('teleHead_employer');
            $table->string('teleHead_designation');
            $table->string('teleHead_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tele_report_heads');
    }
};
