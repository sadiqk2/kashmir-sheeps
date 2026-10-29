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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique(); // e.g. KS-892104
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('district');
            $table->text('delivery_address');
            $table->string('pin_code')->nullable();
            $table->string('payment_method'); // 'Cash on Delivery', 'Instant UPI', 'KCC Subsidy Voucher'
            $table->string('payment_status')->default('pending'); // 'pending', 'verified', 'kcc_approved'
            $table->string('upi_reference')->nullable();
            $table->string('kcc_number')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('Order Confirmed'); // 'Order Confirmed', 'Veterinary Health Cleared', 'In Transit', 'Delivered', 'Cancelled'
            $table->string('carrier_vehicle')->nullable(); // e.g. JK01-AH-4912
            $table->string('vas_officer_cleared')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
