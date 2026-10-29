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
        Schema::create('hadp_applications', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->unique(); // HADP-JK-SHP-XXXXX
            $table->string('beneficiary_name');
            $table->string('aadhaar_hash'); // e.g. XXXX-XXXX-7182
            $table->string('phone');
            $table->string('district');
            $table->string('target_scheme');
            $table->string('training_status');
            $table->decimal('unit_cost', 14, 2)->default(500000.00);
            $table->decimal('subsidy_amount', 14, 2)->default(250000.00); // 50% DBT Cap
            $table->unsignedTinyInteger('workflow_stage')->default(1); // 1 to 5
            $table->string('kkg_center_id')->default('KKG-J&K-001');
            $table->string('vas_inspector_name')->nullable();
            $table->string('sanction_order_no')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadp_applications');
    }
};
