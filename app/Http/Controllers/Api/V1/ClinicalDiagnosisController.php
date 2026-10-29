<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Veterinary\Actions\CalculateDosageAction;
use App\Domain\Veterinary\Actions\DiagnoseSymptomsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ClinicalDiagnosisRequest;
use App\Http\Requests\V1\ClinicalDosageRequest;
use Illuminate\Http\JsonResponse;

class ClinicalDiagnosisController extends Controller
{
    public function __construct(
        private DiagnoseSymptomsAction $diagnoseAction,
        private CalculateDosageAction $dosageAction
    ) {}

    public function diagnose(ClinicalDiagnosisRequest $request): JsonResponse
    {
        $findings = $this->diagnoseAction->execute($request->validated('symptoms'));

        return response()->json([
            'status' => 'success',
            'success' => true,
            'helpline' => '1962 (J&K 24x7 Mobile Veterinary Ambulance)',
            'hospital' => 'SKUAST-K Clinical Complex Shuhama, Alusteng',
            'findings' => $findings,
            'meta' => [
                'authority' => 'SKUAST-K Division of Veterinary Medicine',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function dosage(ClinicalDosageRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $calc = $this->dosageAction->execute((float) $validated['weight_kg'], $validated['drug']);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'animal_weight_kg' => (float) $validated['weight_kg'],
            'calculation' => $calc,
        ]);
    }
}
