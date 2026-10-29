<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LivestockListing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_qurbani' => 'boolean',
        'verified' => 'boolean',
        'is_sold' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'reviews_count' => 'integer',
        'gallery' => 'array',
    ];

    public function passport(): HasOne
    {
        return $this->hasOne(InaphPassport::class, 'livestock_listing_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'livestock_listing_id');
    }
}
