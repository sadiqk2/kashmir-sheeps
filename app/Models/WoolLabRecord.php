<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoolLabRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'micron' => 'decimal:1',
        'staple_length_cm' => 'decimal:1',
        'clean_yield_pct' => 'decimal:1',
        'greasy_weight_kg' => 'decimal:2',
        'msp_rate_per_kg' => 'decimal:2',
        'clean_yield_bonus' => 'decimal:2',
        'total_payout' => 'decimal:2',
    ];
}
