<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Pastoral\Actions\RegisterTransitPermitAction;
use App\Domain\Pastoral\DTOs\BahakTransitData;
use App\Domain\Pastoral\Repositories\BahakTransitRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LogBahakTransitRequest;
use App\Http\Resources\V1\BahakTransitLogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BahakTransitController extends Controller
{
    public function __construct(
        private BahakTransitRepositoryInterface $repository,
        private RegisterTransitPermitAction $registerAction
    ) {}

    public function index(Request $request): JsonResponse
    {
        $logs = $this->repository->all($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $logs->count(),
            'data' => BahakTransitLogResource::collection($logs),
            'meta' => [
                'authority' => 'Dept of Sheep Husbandry Transhumance Checkpost Cell',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function store(LogBahakTransitRequest $request): JsonResponse
    {
        $dto = BahakTransitData::fromRequest($request->validated());
        $log = $this->registerAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => "Alpine Transit Permit {$log->permit_no} registered successfully.",
            'data' => new BahakTransitLogResource($log),
        ], 201);
    }
}
