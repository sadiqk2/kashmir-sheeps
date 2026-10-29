<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Identity\Actions\AuthenticateUserAction;
use App\Domain\Identity\Actions\RegisterUserAction;
use App\Domain\Identity\DTOs\RegisterUserData;
use App\Domain\Identity\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user account (Buyer, Seller, Farmer, or Veterinarian).
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
        $dto = RegisterUserData::fromRequest($request->validated());
        $result = $action->execute($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Account successfully registered and verified on Kashmir Sheeps & HADP Digital Ecosystem.',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * Authenticate and get API bearer token.
     */
    public function login(LoginRequest $request, AuthenticateUserAction $action): JsonResponse
    {
        $result = $action->execute(
            login: $request->validated('login'),
            password: $request->validated('password')
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully.',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * Get authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * Logout and revoke current token.
     */
    public function logout(Request $request): JsonResponse
    {
        if ($user = $request->user()) {
            $user->currentAccessToken()?->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out.',
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * List verified sellers & registered breeders.
     */
    public function sellers(UserRepositoryInterface $userRepo): JsonResponse
    {
        $sellers = $userRepo->getVerifiedSellers();

        return response()->json([
            'status' => 'success',
            'count' => $sellers->count(),
            'data' => UserResource::collection($sellers),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * List verified buyers & HADP beneficiaries.
     */
    public function buyers(UserRepositoryInterface $userRepo): JsonResponse
    {
        $buyers = $userRepo->getVerifiedBuyers();

        return response()->json([
            'status' => 'success',
            'count' => $buyers->count(),
            'data' => UserResource::collection($buyers),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * Available account roles and their privileges.
     */
    public function roles(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'role' => 'buyer',
                    'name_en' => 'Verified Buyer / Consumer',
                    'name_ur' => 'تصدیق شدہ خریدار / شہری',
                    'desc' => 'Buy certified breeding stock, organic manure, wool products, and order Qurbani sacrificial rams with live transit tracking.',
                ],
                [
                    'role' => 'seller',
                    'name_en' => 'Livestock Breeder & Equipment Seller',
                    'name_ur' => 'بھیڑ پالنے والا بریڈر و دکاندار',
                    'desc' => 'Sell certified Kashmir Merino, Bakarwali sheep, shearing machines, and orchard manure directly across J&K without middlemen.',
                ],
                [
                    'role' => 'farmer',
                    'name_en' => 'HADP Commercial Sheep Farmer',
                    'name_ur' => 'ایچ اے ڈی پی پروجیکٹ کسان',
                    'desc' => 'Apply for 50% DBT subsidy on 50-ewe / 100-ewe commercial units, register INAPH tags, and log Bahak migratory transit passes.',
                ],
                [
                    'role' => 'veterinarian',
                    'name_en' => 'Veterinary Assistant Surgeon (VAS)',
                    'name_ur' => 'ویٹرنری اسسٹنٹ سرجن (محکمہ بھیڑ پالن)',
                    'desc' => 'Issue official e-health certificates, conduct pre-purchase disease fitness checks, and submit laboratory wool test grades.',
                ],
            ],
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }
}
