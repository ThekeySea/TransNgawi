<?php

namespace App\Enums;

enum BusStatus: string
{
    case IDLE = 'IDLE';
    case ACTIVE = 'ACTIVE';
    case MAINTENANCE = 'MAINTENANCE';

    public function label(): string
    {
        return match ($this) {
            self::IDLE => 'Tersedia',
            self::ACTIVE => 'Aktif',
            self::MAINTENANCE => 'Perawatan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::IDLE => 'green',
            self::ACTIVE => 'blue',
            self::MAINTENANCE => 'amber',
        };
    }

    public function canBeAssigned(): bool
    {
        return $this === self::IDLE;
    }
}
