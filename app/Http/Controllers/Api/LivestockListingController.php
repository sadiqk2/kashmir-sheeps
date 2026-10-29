<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LivestockListing;
use App\Models\InaphPassport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LivestockListingController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $query = LivestockListing::with('passport');

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('district') && $request->district !== 'all') {
            $query->where('district', 'like', '%' . $request->district . '%');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title_en', 'like', "%{$s}%")
                  ->orWhere('title_ur', 'like', "%{$s}%")
                  ->orWhere('spec_en', 'like', "%{$s}%")
                  ->orWhere('district', 'like', "%{$s}%")
                  ->orWhere('farmer_name', 'like', "%{$s}%")
                  ->orWhere('inaph_tag', 'like', "%{$s}%");
            });
        }

        if ($request->filled('qurbani') && filter_var($request->qurbani, FILTER_VALIDATE_BOOLEAN)) {
            $query->where('is_qurbani', true);
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'low':
                $query->orderBy('price', 'asc');
                break;
            case 'high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderByDesc('id');
                break;
        }

        $items = $query->get();

        return response()->json([
            'success' => true,
            'count' => $items->count(),
            'data' => $items,
        ]);
    }

    /**
     * Store a newly created listing in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ur' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|string|max:100',
            'spec_en' => 'required|string|max:255',
            'spec_ur' => 'nullable|string|max:255',
            'district' => 'required|string|max:100',
            'farmer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'inaph_tag' => 'nullable|string|max:20',
            'desc_en' => 'nullable|string',
            'desc_ur' => 'nullable|string',
            'photo' => 'nullable|string', // Data URL or Image URL
        ]);

        $isLive = in_array($validated['category'], ['merino', 'bakarwali', 'qurbani']);
        $whatsapp = $validated['whatsapp'] ?? preg_replace('/[^0-9]/', '', $validated['phone']);

        $gallery = [];
        if (!empty($validated['photo'])) {
            $gallery[] = $validated['photo'];
        } else {
            $gallery[] = $isLive
                ? 'https://images.unsplash.com/photo-1526030994690-40e26ad32a1c?auto=format&fit=crop&w=800&q=80'
                : 'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=800&q=80';
        }

        $listing = LivestockListing::create([
            'type' => $isLive ? 'live' : 'product',
            'category' => $validated['category'],
            'title_en' => $validated['title_en'],
            'title_ur' => $validated['title_ur'] ?? $validated['title_en'],
            'price' => $validated['price'],
            'weight' => str_ends_with($validated['weight'], 'Kg') ? $validated['weight'] : $validated['weight'] . ' Kg',
            'spec_en' => $validated['spec_en'],
            'spec_ur' => $validated['spec_ur'] ?? $validated['spec_en'],
            'district' => $validated['district'],
            'village_en' => $validated['district'] . ' Mandi Center',
            'village_ur' => $validated['district'] . ' منڈی مرکز',
            'farmer_name' => $validated['farmer_name'],
            'phone' => $validated['phone'],
            'whatsapp' => $whatsapp,
            'is_qurbani' => str_contains(strtolower($validated['spec_en']), '2') || str_contains(strtolower($validated['spec_en']), '4'),
            'verified' => true,
            'rating' => 5.0,
            'reviews_count' => 1,
            'inaph_tag' => $validated['inaph_tag'] ?? null,
            'is_sold' => false,
            'gallery' => $gallery,
            'desc_en' => $validated['desc_en'] ?? 'Direct livestock from shepherd flock in Kashmir.',
            'desc_ur' => $validated['desc_ur'] ?? 'براہ راست کشمیری فارمر کا مال۔',
        ]);

        // If inaph_tag provided, automatically register in INAPH table
        if (!empty($validated['inaph_tag'])) {
            InaphPassport::firstOrCreate(
                ['tag_no' => $validated['inaph_tag']],
                [
                    'livestock_listing_id' => $listing->id,
                    'breed' => $listing->title_en,
                    'genotype' => 'Kashmir Merino Pastoral Line',
                    'sex' => 'Ram / Male',
                    'dob' => now()->subYears(2)->toDateString(),
                    'teeth' => $listing->spec_en,
                    'sire_line' => 'Highland Sire',
                    'dam_line' => 'Pasture Ewe',
                    'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
                    'etv_vaccination_date' => now()->subMonths(3)->toDateString(),
                    'deworming_date' => now()->subMonth()->toDateString(),
                    'owner_name' => $listing->farmer_name,
                    'district' => $listing->district,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Listing published successfully in Kashmir Livestock Mandi.',
            'data' => $listing->load('passport'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $item = LivestockListing::with('passport')->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = LivestockListing::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $validated = $request->validate([
            'price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:50',
            'is_sold' => 'nullable|boolean',
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Listing updated successfully.',
            'data' => $item,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $item = LivestockListing::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Listing deleted successfully.',
        ]);
    }
}
