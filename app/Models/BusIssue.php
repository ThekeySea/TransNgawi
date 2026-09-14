<?php

namespace App\Models;

use App\Enums\IssueSeverity;
use App\Enums\IssueStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['bus_id', 'category', 'description', 'severity', 'status'])]
class BusIssue extends Model
{
    protected function casts(): array
    {
        return [
            'severity' => IssueSeverity::class,
            'status' => IssueStatus::class,
        ];
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
}
