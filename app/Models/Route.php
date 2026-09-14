<?php

namespace App\Models;

use App\Enums\ServiceCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['origin_id', 'destination_id', 'service_category'])]
class Route extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'service_category' => ServiceCategory::class,
        ];
    }

    /**
     * Origin location of the route.
     */
    public function origin(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_id');
    }

    /**
     * Destination location of the route.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_id');
    }

    /**
     * Rute yang boleh dipakai untuk suatu layanan (aturan lokasi backend).
     * ANTIBU: kedua kota ibu kota. SATSET: kedua titik penting. BIASANE: bebas.
     */
    public function scopeForService(Builder $query, ServiceCategory $service): Builder
    {
        $query->where('service_category', $service);

        if ($service === ServiceCategory::ANTIBU) {
            $query->whereHas('origin', fn (Builder $q) => $q->where('is_capital', true))
                ->whereHas('destination', fn (Builder $q) => $q->where('is_capital', true));
        }

        if ($service === ServiceCategory::SATSET) {
            $query->whereHas('origin', fn (Builder $q) => $q->where('is_important', true))
                ->whereHas('destination', fn (Builder $q) => $q->where('is_important', true));
        }

        return $query;
    }

    /**
     * Trips operating on this route.
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
