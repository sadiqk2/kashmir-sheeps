<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Pastoral\Actions\AnalyzeWoolAction;
use App\Domain\Pastoral\DTOs\WoolLabData;
use App\Domain\Pastoral\Repositories\WoolLabRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AnalyzeWoolRequest;
use App\Http\Resources\V1\WoolLabRecordResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WoolLabController extends Controller
{
    public function __construct(
        private WoolLabRepositoryInterface $repository,
        private AnalyzeWoolAction $analyzeAction
    ) {}

    public function index(Request $request): JsonResponse
    {
        $records = $this->repository->all($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $records->count(),
            'data' => WoolLabRecordResource::collection($records),
            'meta' => [
                'authority' => 'SKUAST-Kashmir Wool Testing Division',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function analyze(AnalyzeWoolRequest $request): JsonResponse
    {
        $dto = WoolLabData::fromRequest($request->validated());
        $res = $this->analyzeAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => "Sample {$res['record']->sample_code} analyzed successfully by SKUAST-K Wool Testing Division.",
            'data' => new WoolLabRecordResource($res['record']),
            'clean_wool_kg' => $res['clean_wool_kg'],
        ], 201);
    }

    public function show(string $sampleCode): JsonResponse
    {
        $record = $this->repository->findBySampleCode($sampleCode);

        if (!$record) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Lab record not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => new WoolLabRecordResource($record),
        ]);
    }
}
