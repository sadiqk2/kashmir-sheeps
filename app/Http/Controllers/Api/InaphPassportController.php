<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InaphPassport;
use App\Models\LivestockListing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InaphPassportController extends Controller
{
    /**
     * Display a listing or search by 12-digit RFID tag.
     */
    public function index(Request $request): JsonResponse
    {
        $query = InaphPassport::with('listing')->orderByDesc('id');

        if ($request->filled('tag')) {
            $tag = $request->tag;
            $query->where('tag_no', 'like', "%{$tag}%");
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $passports = $query->get();

        return response()->json([
            'success' => true,
            'count' => $passports->count(),
            'data' => $passports,
        ]);
    }

    /**
     * Display passport for specific 12-digit tag.
     */
    public function show(string $tagNo): JsonResponse
    {
        $passport = InaphPassport::with('listing')->where('tag_no', $tagNo)->first();

        if (!$passport) {
            return response()->json([
                'success' => false,
                'message' => "INAPH 12-digit RFID Tag #{$tagNo} not found in Bharat Pashudhan registry.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $passport,
        ]);
    }

    /**
     * Field registration of a new 12-digit INAPH ear tag.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tag_no' => 'required|string|size:12|unique:inaph_passports,tag_no',
            'breed' => 'required|string|max:255',
            'genotype' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'dob' => 'nullable|date',
            'teeth' => 'required|string',
            'sire_line' => 'nullable|string',
            'dam_line' => 'nullable|string',
            'etv_vaccination_date' => 'nullable|date',
            'pox_vaccination_date' => 'nullable|date',
            'deworming_date' => 'nullable|date',
            'deworming_drug' => 'nullable|string',
            'vet_officer' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'district' => 'required|string|max:100',
        ]);

        $passport = InaphPassport::create([
            'tag_no' => $validated['tag_no'],
            'breed' => $validated['breed'],
            'genotype' => $validated['genotype'] ?? 'Kashmir Merino Certified Breed',
            'sex' => $validated['sex'],
            'dob' => $validated['dob'] ?? now()->subMonths(18)->toDateString(),
            'teeth' => $validated['teeth'],
            'sire_line' => $validated['sire_line'] ?? 'Govt Breeding Ram',
            'dam_line' => $validated['dam_line'] ?? 'Pastoral Ewe Line',
            'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
            'etv_vaccination_date' => $validated['etv_vaccination_date'] ?? now()->subMonths(2)->toDateString(),
            'pox_vaccination_date' => $validated['pox_vaccination_date'] ?? now()->subMonths(4)->toDateString(),
            'deworming_date' => $validated['deworming_date'] ?? now()->subMonth()->toDateString(),
            'deworming_drug' => $validated['deworming_drug'] ?? 'Fenbendazole 10% (SKUAST Protocol)',
            'vet_officer' => $validated['vet_officer'] ?? 'Dr. M. A. Lone, VAS J&K Sheep Husbandry',
            'fitness_cert_no' => 'JK-VET-FIT-2026-' . rand(100, 999),
            'owner_name' => $validated['owner_name'],
            'district' => $validated['district'],
        ]);

        return response()->json([
            'success' => true,
            'message' => "INAPH 12-Digit Tag #{$passport->tag_no} registered successfully.",
            'data' => $passport,
        ], 201);
    }
}
