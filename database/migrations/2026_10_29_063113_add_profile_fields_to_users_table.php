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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('role')->default('buyer')->after('phone'); // buyer, seller, farmer, veterinarian, admin
            $table->string('district')->nullable()->after('role');
            $table->string('tehsil')->nullable()->after('district');
            $table->string('village')->nullable()->after('tehsil');
            $table->boolean('is_verified')->default(false)->after('village');
            $table->string('kkg_id')->nullable()->after('is_verified'); // Kisan Khidmat Ghar ID
            $table->string('inaph_breeder_code')->nullable()->after('kkg_id');
            $table->string('aadhaar_hash')->nullable()->after('inaph_breeder_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'role',
                'district',
                'tehsil',
                'village',
                'is_verified',
                'kkg_id',
                'inaph_breeder_code',
                'aadhaar_hash',
            ]);
        });
    }
};
