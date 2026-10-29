<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahakTransitLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'ewe_count' => 'integer',
        'ram_count' => 'integer',
        'lamb_count' => 'integer',
        'total_head_count' => 'integer',
        'transit_date' => 'date',
    ];
}
