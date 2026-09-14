<?php

namespace App\Enums;

enum BusModelType: string
{
    case BIASANE = 'BIASANE';
    case ANTIBU_SATSET = 'ANTIBU_SATSET';

    public function label(): string
    {
        return match ($this) {
            self::BIASANE => 'BIASANE · 40 kursi',
            self::ANTIBU_SATSET => 'ANTIBU/SATSET · 30 kursi',
        };
    }
}
