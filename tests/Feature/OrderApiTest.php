<?php

namespace Tests\Feature;

use App\Models\LivestockListing;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_list_orders(): void
    {
        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'count',
                'data' => [
                    '*' => ['id', 'order_no', 'customer_name', 'total_amount', 'status', 'items']
                ]
            ]);
    }

    public function test_can_place_order_and_mark_live_animal_sold(): void
    {
        $listing = LivestockListing::where('type', 'live')->where('is_sold', false)->first();

        $payload = [
            'customer_name' => 'Ghulam Nabi Dar',
            'customer_phone' => '09419123456',
            'district' => 'Kulgam',
            'delivery_address' => 'Near Eidgah, Kulgam - 192231',
            'payment_method' => 'Cash on Delivery',
            'items' => [
                [
                    'id' => $listing->id,
                    'title' => $listing->title_en,
                    'price' => $listing->price,
                    'qty' => 1,
                    'spec' => $listing->spec_en,
                    'inaph_tag' => $listing->inaph_tag,
                ]
            ]
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'customer_name' => 'Ghulam Nabi Dar',
                    'district' => 'Kulgam',
                    'status' => 'Order Confirmed',
                    'shipping_fee' => '0.00', // Free delivery over 1499
                ]
            ]);

        $orderNo = $response->json('order_no');
        $this->assertNotEmpty($orderNo);

        // Verify live animal is now marked as sold
        $this->assertTrue($listing->fresh()->is_sold);

        // Verify database order
        $this->assertDatabaseHas('orders', [
            'order_no' => $orderNo,
            'customer_name' => 'Ghulam Nabi Dar',
        ]);
    }

    public function test_can_view_single_order_details(): void
    {
        $order = Order::first();

        $response = $this->getJson("/api/orders/{$order->order_no}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'order_no' => $order->order_no,
                    'customer_name' => $order->customer_name,
                ]
            ]);
    }

    public function test_can_cancel_order_and_restore_live_stock(): void
    {
        $listing = LivestockListing::where('type', 'live')->first();
        $listing->update(['is_sold' => true]);

        $order = Order::create([
            'order_no' => 'KS-TEST-CANCEL',
            'customer_name' => 'Cancel Test User',
            'customer_phone' => '09419000000',
            'district' => 'Budgam',
            'delivery_address' => 'Test Address',
            'payment_method' => 'Cash on Delivery',
            'total_amount' => $listing->price,
            'status' => 'Order Confirmed',
        ]);

        $order->items()->create([
            'livestock_listing_id' => $listing->id,
            'title' => $listing->title_en,
            'unit_price' => $listing->price,
            'quantity' => 1,
            'total_price' => $listing->price,
        ]);

        $response = $this->postJson("/api/orders/{$order->order_no}/cancel");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'status' => 'Cancelled',
                ]
            ]);

        // Animal stock must be restored to available (is_sold = false)
        $this->assertFalse($listing->fresh()->is_sold);
    }

    public function test_can_advance_order_tracking_timeline(): void
    {
        $order = Order::create([
            'order_no' => 'KS-TEST-TRACK',
            'customer_name' => 'Tracking User',
            'customer_phone' => '09419000000',
            'district' => 'Srinagar',
            'delivery_address' => 'Rajbagh',
            'payment_method' => 'Cash on Delivery',
            'total_amount' => 5000,
            'status' => 'Order Confirmed',
        ]);

        $res1 = $this->postJson("/api/orders/{$order->order_no}/advance-tracking");
        $res1->assertStatus(200)->assertJson(['data' => ['status' => 'Veterinary Health Cleared']]);

        $res2 = $this->postJson("/api/orders/{$order->order_no}/advance-tracking");
        $res2->assertStatus(200)->assertJson(['data' => ['status' => 'In Transit']]);

        $res3 = $this->postJson("/api/orders/{$order->order_no}/advance-tracking");
        $res3->assertStatus(200)->assertJson(['data' => ['status' => 'Delivered']]);
    }
}
