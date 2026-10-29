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
        Schema::create('bahak_transit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('permit_no')->unique(); // BAHAK-JK-2026-XXXX
            $table->string('chopan_name');
            $table->string('chopan_id');
            $table->string('phone');
            $table->string('route_name'); // e.g. Peer Ki Gali / Mughal Road
            $table->unsignedInteger('ewe_count')->default(0);
            $table->unsignedInteger('ram_count')->default(0);
            $table->unsignedInteger('lamb_count')->default(0);
            $table->unsignedInteger('total_head_count')->default(0);
            $table->string('dipping_cert_no');
            $table->string('checkpost_name');
            $table->date('transit_date');
            $table->string('clearance_status')->default('Cleared');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahak_transit_logs');
    }
};
