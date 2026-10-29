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
        Schema::create('wool_lab_records', function (Blueprint $table) {
            $table->id();
            $table->string('sample_code')->unique(); // WOOL-SKUAST-XXXX
            $table->string('farmer_name');
            $table->string('flock_tag_reference')->nullable();
            $table->string('district');
            $table->decimal('micron', 4, 1); // e.g. 18.5
            $table->decimal('staple_length_cm', 4, 1); // e.g. 7.5
            $table->decimal('clean_yield_pct', 4, 1); // e.g. 62.0
            $table->decimal('greasy_weight_kg', 6, 2); // e.g. 3.50
            $table->string('wool_grade'); // 'Superfine Merino Grade A', 'Fine Merino Grade B', etc.
            $table->decimal('msp_rate_per_kg', 8, 2);
            $table->decimal('clean_yield_bonus', 8, 2)->default(0);
            $table->decimal('total_payout', 10, 2);
            $table->string('certified_by')->default('SKUAST-K Wool Quality Testing Division');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wool_lab_records');
    }
};
