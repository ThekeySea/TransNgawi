<?php

namespace App\Enums;

enum IssueStatus: string
{
    case OPEN = 'OPEN';
    case IN_PROGRESS = 'IN_PROGRESS';
    case RESOLVED = 'RESOLVED';
    case CLOSED = 'CLOSED';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Terbuka',
            self::IN_PROGRESS => 'Dalam Proses',
            self::RESOLVED => 'Selesai',
            self::CLOSED => 'Ditutup',
        };
    }
}
