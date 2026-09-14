<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'is_capital', 'is_important'])]
class Location extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_capital' => 'boolean',
            'is_important' => 'boolean',
        ];
    }

    /**
     * Routes originating from this location.
     */
    public function originatingRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'origin_id');
    }

    /**
     * Routes destined for this location.
     */
    public function destinationRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'destination_id');
    }
}
