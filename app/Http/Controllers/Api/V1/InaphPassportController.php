<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Veterinary\Actions\RegisterInaphTagAction;
use App\Domain\Veterinary\Actions\SearchInaphTagAction;
use App\Domain\Veterinary\DTOs\InaphPassportData;
use App\Domain\Veterinary\Repositories\InaphPassportRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterInaphPassportRequest;
use App\Http\Resources\V1\InaphPassportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InaphPassportController extends Controller
{
    public function __construct(
        private InaphPassportRepositoryInterface $repository,
        private SearchInaphTagAction $searchAction,
        private RegisterInaphTagAction $registerAction
    ) {}

    public function index(Request $request): JsonResponse
    {
        $passports = $this->repository->all($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $passports->count(),
            'data' => InaphPassportResource::collection($passports),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function show(string $tagNo): JsonResponse
    {
        $passport = $this->searchAction->execute($tagNo);

        if (!$passport) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => "INAPH 12-digit RFID Tag #{$tagNo} not found in Bharat Pashudhan registry.",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => new InaphPassportResource($passport),
        ]);
    }

    public function store(RegisterInaphPassportRequest $request): JsonResponse
    {
        $dto = InaphPassportData::fromRequest($request->validated());
        $passport = $this->registerAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => "INAPH 12-Digit Tag #{$passport->tag_no} registered successfully.",
            'data' => new InaphPassportResource($passport),
        ], 201);
    }
}
