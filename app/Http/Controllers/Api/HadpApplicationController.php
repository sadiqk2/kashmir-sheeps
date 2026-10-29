<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HadpApplication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HadpApplicationController extends Controller
{
    /**
     * Display a listing of HADP applications.
     */
    public function index(Request $request): JsonResponse
    {
        $query = HadpApplication::orderByDesc('id');

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('stage')) {
            $query->where('workflow_stage', $request->stage);
        }

        $apps = $query->get();

        return response()->json([
            'success' => true,
            'count' => $apps->count(),
            'data' => $apps,
        ]);
    }

    /**
     * Store a newly created HADP application.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'beneficiary_name' => 'required|string|max:255',
            'aadhaar_hash' => 'required|string|max:30',
            'phone' => 'required|string|max:50',
            'district' => 'required|string|max:100',
            'target_scheme' => 'required|string|max:255',
            'training_status' => 'required|string|max:255',
        ]);

        // Calculate scheme unit cost & 50% subsidy
        $scheme = $validated['target_scheme'];
        $unitCost = 500000.00;
        $subsidy = 250000.00; // 50% DBT cap

        if (str_contains($scheme, 'Shearing') || str_contains($scheme, 'Project 27')) {
            $unitCost = 300000.00;
            $subsidy = 150000.00;
        } elseif (str_contains($scheme, 'Fodder') || str_contains($scheme, 'Silage')) {
            $unitCost = 150000.00;
            $subsidy = 75000.00;
        } elseif (str_contains($scheme, 'Ram') || str_contains($scheme, 'Buck')) {
            $unitCost = 40000.00;
            $subsidy = 20000.00;
        }

        $refNo = 'HADP-JK-SHP-' . rand(10000, 99999);

        $app = HadpApplication::create([
            'ref_no' => $refNo,
            'beneficiary_name' => $validated['beneficiary_name'],
            'aadhaar_hash' => $validated['aadhaar_hash'],
            'phone' => $validated['phone'],
            'district' => $validated['district'],
            'target_scheme' => $scheme,
            'training_status' => $validated['training_status'],
            'unit_cost' => $unitCost,
            'subsidy_amount' => $subsidy,
            'workflow_stage' => 1,
            'kkg_center_id' => 'KKG-' . strtoupper(substr($validated['district'], 0, 3)) . '-' . rand(10, 99),
        ]);

        return response()->json([
            'success' => true,
            'message' => "HADP Pre-Application {$app->ref_no} submitted successfully under J&K Kisan Sathi Portal.",
            'ref_no' => $app->ref_no,
            'data' => $app,
        ], 201);
    }

    /**
     * Display the specified application.
     */
    public function show(string $refNo): JsonResponse
    {
        $app = HadpApplication::where('ref_no', $refNo)->first();

        if (!$app) {
            return response()->json(['success' => false, 'message' => 'Application not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $app]);
    }

    /**
     * Advance workflow stage (1 to 5).
     */
    public function advanceStage(string $refNo): JsonResponse
    {
        $app = HadpApplication::where('ref_no', $refNo)->first();

        if (!$app) {
            return response()->json(['success' => false, 'message' => 'Application not found'], 404);
        }

        if ($app->workflow_stage < 5) {
            $newStage = $app->workflow_stage + 1;
            $updates = ['workflow_stage' => $newStage];

            if ($newStage === 2) {
                $updates['vas_inspector_name'] = 'Dr. Z. A. Rather, VAS ' . $app->district;
            } elseif ($newStage === 4) {
                $updates['sanction_order_no'] = 'DSHO/' . strtoupper(substr($app->district, 0, 3)) . '/HADP/2026/' . rand(100, 999);
            } elseif ($newStage === 5) {
                $updates['disbursed_at'] = now();
            }

            $app->update($updates);
        }

        return response()->json([
            'success' => true,
            'message' => "Application {$app->ref_no} advanced to Stage {$app->workflow_stage}: {$app->stage_label}.",
            'data' => $app,
        ]);
    }
}
