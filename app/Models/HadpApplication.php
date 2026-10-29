<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HadpApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'subsidy_amount' => 'decimal:2',
        'workflow_stage' => 'integer',
        'disbursed_at' => 'datetime',
    ];

    /**
     * Get label for workflow stage
     */
    public function getStageLabelAttribute(): string
    {
        return match ($this->workflow_stage) {
            1 => 'Application Submitted (KKG Intake)',
            2 => 'Technical Scrutiny (Tehsil VAS Verified)',
            3 => 'Field Verification & Geo-tagging (DSHO Cleared)',
            4 => 'District Level Committee Sanction Approved',
            5 => '50% DBT Disbursed to Bank Account',
            default => 'Under Processing',
        };
    }
}
