<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InaphPassport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'dob' => 'date',
        'etv_vaccination_date' => 'date',
        'pox_vaccination_date' => 'date',
        'ppr_vaccination_date' => 'date',
        'fmd_vaccination_date' => 'date',
        'deworming_date' => 'date',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(LivestockListing::class, 'livestock_listing_id');
    }
}
