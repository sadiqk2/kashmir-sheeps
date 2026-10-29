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
        Schema::create('inaph_passports', function (Blueprint $table) {
            $table->id();
            $table->string('tag_no', 12)->unique(); // 12-digit RFID tag e.g. 040029481023
            $table->unsignedBigInteger('livestock_listing_id')->nullable();
            $table->string('breed');
            $table->string('genotype');
            $table->string('sex')->default('Ram / Male');
            $table->date('dob')->nullable();
            $table->string('teeth')->default('2 Teeth (Doda)');
            $table->string('sire_line')->nullable();
            $table->string('dam_line')->nullable();
            $table->string('rfid_frequency')->default('134.2 kHz ISO 11784/11785 FDX-B');
            $table->date('etv_vaccination_date')->nullable();
            $table->date('pox_vaccination_date')->nullable();
            $table->date('ppr_vaccination_date')->nullable();
            $table->date('fmd_vaccination_date')->nullable();
            $table->date('deworming_date')->nullable();
            $table->string('deworming_drug')->nullable()->default('Fenbendazole 10% (SKUAST Protocol)');
            $table->string('vet_officer')->default('Dr. M. A. Lone, VAS J&K Sheep Husbandry');
            $table->string('fitness_cert_no')->default('JK-VET-FIT-2026-092');
            $table->string('owner_name');
            $table->string('district');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inaph_passports');
    }
};
