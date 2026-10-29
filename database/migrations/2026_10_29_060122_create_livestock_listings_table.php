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
        Schema::create('livestock_listings', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('live'); // 'live' or 'product'
            $table->string('category'); // 'merino', 'bakarwali', 'qurbani', 'hadp', 'fertilizer', 'wool', 'supplies'
            $table->string('title_en');
            $table->string('title_ur');
            $table->decimal('price', 12, 2);
            $table->string('weight');
            $table->string('spec_en');
            $table->string('spec_ur');
            $table->string('district');
            $table->string('village_en');
            $table->string('village_ur');
            $table->string('farmer_name');
            $table->string('phone');
            $table->string('whatsapp');
            $table->boolean('is_qurbani')->default(false);
            $table->boolean('verified')->default(true);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->unsignedInteger('reviews_count')->default(1);
            $table->string('inaph_tag')->nullable();
            $table->boolean('is_sold')->default(false);
            $table->json('gallery')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ur')->nullable();
            $table->string('sire_line')->nullable();
            $table->string('dam_line')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock_listings');
    }
};
