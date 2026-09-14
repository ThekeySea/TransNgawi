<?php

namespace App\Enums;

enum TripSeatStatus: string
{
    case AVAILABLE = 'AVAILABLE';
    case HELD = 'HELD';
    case SOLD = 'SOLD';
    case BLOCKED = 'BLOCKED';
}
