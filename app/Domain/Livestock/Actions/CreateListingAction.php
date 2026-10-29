<?php

namespace App\Domain\Livestock\Actions;

use App\Domain\Livestock\DTOs\ListingData;
use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use App\Domain\Veterinary\Repositories\InaphPassportRepositoryInterface;
use App\Models\LivestockListing;
use App\Models\User;

class CreateListingAction
{
    public function __construct(
        private LivestockListingRepositoryInterface $repository,
        private InaphPassportRepositoryInterface $passportRepository
    ) {}

    public function execute(ListingData $data): LivestockListing
    {
        $gallery = $data->gallery ?? [];
        if (!empty($data->photo)) {
            $gallery[] = $data->photo;
        } elseif (empty($gallery)) {
            $gallery[] = ($data->type === 'live')
                ? 'https://images.unsplash.com/photo-1526030994690-40e26ad32a1c?auto=format&fit=crop&w=800&q=80'
                : 'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=800&q=80';
        }

        $tier = $data->seller_verification_tier ?? 'basic';
        $isVerified = false;

        if ($data->user_id) {
            $user = User::find($data->user_id);
            if ($user) {
                $hasAadhaar = !empty($user->aadhaar_hash);
                $hasInaph = !empty($user->inaph_breeder_code);
                if ($hasAadhaar && $hasInaph) {
                    $tier = 'aadhaar_inaph';
                    $isVerified = true;
                } elseif ($hasAadhaar) {
                    $tier = 'aadhaar_only';
                    $isVerified = true;
                } elseif ($hasInaph) {
                    $tier = 'inaph_only';
                    $isVerified = true;
                } elseif ($user->is_verified) {
                    $tier = 'verified_phone';
                    $isVerified = true;
                }
            }
        }

        $listing = $this->repository->create([
            'user_id' => $data->user_id,
            'type' => $data->type,
            'category' => $data->category,
            'title_en' => $data->title_en,
            'title_ur' => $data->title_ur,
            'price' => $data->price,
            'weight' => $data->weight,
            'spec_en' => $data->spec_en,
            'spec_ur' => $data->spec_ur,
            'district' => $data->district,
            'village_en' => $data->district . ' Mandi Center',
            'village_ur' => $data->district . ' منڈی مرکز',
            'farmer_name' => $data->farmer_name,
            'phone' => $data->phone,
            'whatsapp' => $data->whatsapp,
            'is_qurbani' => str_contains(strtolower($data->spec_en), '2') || str_contains(strtolower($data->spec_en), '4'),
            'verified' => $isVerified,
            'seller_verification_tier' => $tier,
            'rating' => 5.0,
            'reviews_count' => 1,
            'inaph_tag' => $data->inaph_tag,
            'is_sold' => false,
            'gallery' => $gallery,
            'desc_en' => $data->desc_en,
            'desc_ur' => $data->desc_ur,
        ]);

        if (!empty($data->inaph_tag)) {
            $this->passportRepository->firstOrCreate([
                'tag_no' => $data->inaph_tag,
            ], [
                'livestock_listing_id' => $listing->id,
                'breed' => $listing->title_en,
                'genotype' => 'Kashmir Merino Pastoral Line',
                'sex' => 'Ram / Male',
                'dob' => now()->subYears(2)->toDateString(),
                'teeth' => $listing->spec_en,
                'sire_line' => 'Highland Sire',
                'dam_line' => 'Pasture Ewe',
                'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
                'etv_vaccination_date' => now()->subMonths(3)->toDateString(),
                'deworming_date' => now()->subMonth()->toDateString(),
                'owner_name' => $listing->farmer_name,
                'district' => $listing->district,
            ]);
        }

        return $listing->load(['passport', 'user']);
    }
}
