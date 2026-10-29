<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WoolLabRecord;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WoolLabController extends Controller
{
    /**
     * Display a listing of wool quality records.
     */
    public function index(Request $request): JsonResponse
    {
        $query = WoolLabRecord::orderByDesc('id');

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $records = $query->get();

        return response()->json([
            'success' => true,
            'count' => $records->count(),
            'data' => $records,
        ]);
    }

    /**
     * Calculate HADP Project 27 wool grading and store lab certificate.
     */
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'farmer_name' => 'required|string|max:255',
            'flock_tag_reference' => 'nullable|string|max:50',
            'district' => 'required|string|max:100',
            'micron' => 'required|numeric|min:14|max:45',
            'staple_length_cm' => 'required|numeric|min:2|max:20',
            'clean_yield_pct' => 'required|numeric|min:30|max:85',
            'greasy_weight_kg' => 'required|numeric|min:0.5|max:1000',
        ]);

        $micron = (float) $validated['micron'];
        $cleanYield = (float) $validated['clean_yield_pct'];
        $greasyWt = (float) $validated['greasy_weight_kg'];

        // HADP Project 27 Classification
        if ($micron < 19.5) {
            $grade = 'Superfine Merino Grade A (Premium Apparel)';
            $baseMsp = 340.00;
            $bonus = ($cleanYield >= 60) ? 95.00 : 50.00;
        } elseif ($micron <= 22.5) {
            $grade = 'Fine Merino Grade B (Worsted Suitings)';
            $baseMsp = 280.00;
            $bonus = ($cleanYield >= 58) ? 60.00 : 30.00;
        } elseif ($micron <= 26.0) {
            $grade = 'Medium Crossbred Grade C (Pheran Tweeds & Blankets)';
            $baseMsp = 210.00;
            $bonus = ($cleanYield >= 55) ? 35.00 : 15.00;
        } else {
            $grade = 'Bakarwali Coarse Grade D (Handmade Rugs & Namdas)';
            $baseMsp = 140.00;
            $bonus = ($cleanYield >= 50) ? 20.00 : 0.00;
        }

        $cleanWoolKg = round(($greasyWt * $cleanYield) / 100, 2);
        $ratePerKg = $baseMsp + $bonus;
        $totalPayout = round($cleanWoolKg * $ratePerKg, 2);

        $sampleCode = 'WOOL-SKUAST-2026-' . rand(1000, 9999);

        $record = WoolLabRecord::create([
            'sample_code' => $sampleCode,
            'farmer_name' => $validated['farmer_name'],
            'flock_tag_reference' => $validated['flock_tag_reference'] ?? null,
            'district' => $validated['district'],
            'micron' => $micron,
            'staple_length_cm' => $validated['staple_length_cm'],
            'clean_yield_pct' => $cleanYield,
            'greasy_weight_kg' => $greasyWt,
            'wool_grade' => $grade,
            'msp_rate_per_kg' => $baseMsp,
            'clean_yield_bonus' => $bonus,
            'total_payout' => $totalPayout,
            'certified_by' => 'SKUAST-K Wool Testing & Quality Certification Division (HADP Project 27)',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Sample {$record->sample_code} analyzed successfully under HADP Project 27.",
            'data' => $record,
            'clean_wool_kg' => $cleanWoolKg,
        ], 201);
    }

    /**
     * Display the specified wool test certificate.
     */
    public function show(string $sampleCode): JsonResponse
    {
        $record = WoolLabRecord::where('sample_code', $sampleCode)->first();

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Lab record not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $record]);
    }
}
