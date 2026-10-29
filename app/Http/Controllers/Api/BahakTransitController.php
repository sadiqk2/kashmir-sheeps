<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BahakTransitLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BahakTransitController extends Controller
{
    /**
     * Display a listing of pastoral migration logs.
     */
    public function index(Request $request): JsonResponse
    {
        $query = BahakTransitLog::orderByDesc('id');

        if ($request->filled('route')) {
            $query->where('route_name', 'like', '%' . $request->route . '%');
        }

        $logs = $query->get();

        return response()->json([
            'success' => true,
            'count' => $logs->count(),
            'data' => $logs,
        ]);
    }

    /**
     * Register a new transhumance migration transit permit.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'chopan_name' => 'required|string|max:255',
            'chopan_id' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'route_name' => 'required|string|max:255',
            'ewe_count' => 'required|integer|min:0',
            'ram_count' => 'required|integer|min:0',
            'lamb_count' => 'required|integer|min:0',
            'dipping_cert_no' => 'required|string|max:100',
            'checkpost_name' => 'required|string|max:100',
            'transit_date' => 'required|date',
        ]);

        $total = $validated['ewe_count'] + $validated['ram_count'] + $validated['lamb_count'];
        $permitNo = 'BAHAK-JK-2026-' . rand(1000, 9999);

        $log = BahakTransitLog::create([
            'permit_no' => $permitNo,
            'chopan_name' => $validated['chopan_name'],
            'chopan_id' => $validated['chopan_id'],
            'phone' => $validated['phone'],
            'route_name' => $validated['route_name'],
            'ewe_count' => $validated['ewe_count'],
            'ram_count' => $validated['ram_count'],
            'lamb_count' => $validated['lamb_count'],
            'total_head_count' => $total,
            'dipping_cert_no' => $validated['dipping_cert_no'],
            'checkpost_name' => $validated['checkpost_name'],
            'transit_date' => $validated['transit_date'],
            'clearance_status' => 'Cleared',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Alpine Transit Permit {$log->permit_no} registered successfully.",
            'data' => $log,
        ], 201);
    }
}
