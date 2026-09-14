<?php

namespace App\Models;

use App\Enums\IssueStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['bus_issue_id', 'bus_id', 'action', 'diagnosis', 'resolution', 'responsible', 'status'])]
class MaintenanceRecord extends Model
{
    protected function casts(): array
    {
        return [
            'status' => IssueStatus::class,
        ];
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function busIssue(): BelongsTo
    {
        return $this->belongsTo(BusIssue::class);
    }
}
