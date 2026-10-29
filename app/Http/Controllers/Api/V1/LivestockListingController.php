<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Livestock\Actions\CreateListingAction;
use App\Domain\Livestock\Actions\DeleteListingAction;
use App\Domain\Livestock\Actions\FilterLivestockAction;
use App\Domain\Livestock\Actions\UpdateListingAction;
use App\Domain\Livestock\DTOs\ListingData;
use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreLivestockRequest;
use App\Http\Requests\V1\UpdateLivestockRequest;
use App\Http\Resources\V1\LivestockListingResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LivestockListingController extends Controller
{
    public function __construct(
        private FilterLivestockAction $filterAction,
        private CreateListingAction $createAction,
        private UpdateListingAction $updateAction,
        private DeleteListingAction $deleteAction,
        private LivestockListingRepositoryInterface $repository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $listings = $this->filterAction->execute($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $listings->count(),
            'data' => LivestockListingResource::collection($listings),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function store(StoreLivestockRequest $request): JsonResponse
    {
        $userId = $request->user()?->id ?? $request->input('user_id');
        $dto = ListingData::fromRequest($request->validated(), $userId ? (int) $userId : null);
        $listing = $this->createAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Listing published successfully in Kashmir Livestock Mandi.',
            'data' => new LivestockListingResource($listing),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $listing = $this->repository->findById($id);

        if (!$listing) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Livestock listing not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => new LivestockListingResource($listing),
        ]);
    }

    public function update(UpdateLivestockRequest $request, int $id): JsonResponse
    {
        $listing = $this->repository->findById($id);

        if (!$listing) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Livestock listing not found.',
            ], 404);
        }

        $updated = $this->updateAction->execute($listing, $request->validated());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Listing updated successfully.',
            'data' => new LivestockListingResource($updated),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $listing = $this->repository->findById($id);

        if (!$listing) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Livestock listing not found.',
            ], 404);
        }

        $this->deleteAction->execute($listing);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Listing deleted successfully.',
        ]);
    }
}
