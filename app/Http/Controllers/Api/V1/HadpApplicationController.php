<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Hadp\Actions\AdvanceHadpStageAction;
use App\Domain\Hadp\Actions\SubmitHadpApplicationAction;
use App\Domain\Hadp\DTOs\HadpApplicationData;
use App\Domain\Hadp\Repositories\HadpApplicationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SubmitHadpApplicationRequest;
use App\Http\Resources\V1\HadpApplicationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class HadpApplicationController extends Controller
{
    public function __construct(
        private HadpApplicationRepositoryInterface $repository,
        private SubmitHadpApplicationAction $submitAction,
        private AdvanceHadpStageAction $advanceStageAction
    ) {}

    public function index(Request $request): JsonResponse
    {
        $apps = $this->repository->all($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $apps->count(),
            'data' => HadpApplicationResource::collection($apps),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function store(SubmitHadpApplicationRequest $request): JsonResponse
    {
        $dto = HadpApplicationData::fromRequest($request->validated());
        $app = $this->submitAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => "HADP Pre-Application {$app->ref_no} submitted successfully under J&K Kisan Sathi Portal.",
            'ref_no' => $app->ref_no,
            'data' => new HadpApplicationResource($app),
        ], 201);
    }

    public function show(string $refNo): JsonResponse
    {
        $app = $this->repository->findByRefNo($refNo);

        if (!$app) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'HADP application not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => new HadpApplicationResource($app),
        ]);
    }

    public function advanceStage(string $refNo): JsonResponse
    {
        try {
            $app = $this->advanceStageAction->execute($refNo);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => "Application {$app->ref_no} advanced to Stage {$app->workflow_stage}: {$app->stage_label}.",
                'data' => new HadpApplicationResource($app),
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}
