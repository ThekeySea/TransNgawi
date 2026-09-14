<?php

namespace App\Enums;

enum ServiceCategory: string
{
    case ANTIBU = 'antibu';
    case SATSET = 'satset';
    case BIASANE = 'biasane';

    public function label(): string
    {
        return match ($this) {
            self::ANTIBU => 'Antar Ibu Kota',
            self::SATSET => 'Perjalanan Antar Tempat Penting',
            self::BIASANE => 'Perjalanan Reguler',
        };
    }
}
