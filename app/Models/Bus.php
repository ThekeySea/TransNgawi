<?php

namespace App\Models;

use App\Enums\BusModelType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['plate_number', 'model_type', 'status'])]
class Bus extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'model_type' => BusModelType::class,
        ];
    }

    /**
     * Trips assigned to this bus.
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
