<?php

namespace App\Enums;

enum BusModelType: string
{
    case PLETON = 'PLETON';
    case KSATRIA = 'KSATRIA';

    /**
     * @deprecated Use PLETON instead. Kept for backward compatibility.
     */
    case BIASANE = 'BIASANE';

    /**
     * @deprecated Use KSATRIA instead. Kept for backward compatibility.
     */
    case ANTIBU_SATSET = 'ANTIBU_SATSET';

    public function label(): string
    {
        return match ($this) {
            self::PLETON => 'Pleton · 40 kursi',
            self::KSATRIA => 'Ksatria · 30 kursi',
            self::BIASANE => 'Pleton · 40 kursi',
            self::ANTIBU_SATSET => 'Ksatria · 30 kursi',
        };
    }

    public function seats(): int
    {
        return match ($this) {
            self::PLETON, self::BIASANE => 40,
            self::KSATRIA, self::ANTIBU_SATSET => 30,
        };
    }

    public function columns(): int
    {
        return match ($this) {
            self::PLETON, self::BIASANE => 4,
            self::KSATRIA, self::ANTIBU_SATSET => 3,
        };
    }

    /**
     * Resolve legacy enum values to their modern equivalent.
     */
    public function resolve(): self
    {
        return match ($this) {
            self::BIASANE => self::PLETON,
            self::ANTIBU_SATSET => self::KSATRIA,
            default => $this,
        };
    }

    /**
     * Return only the active (non-deprecated) bus model types.
     *
     * @return array<int, self>
     */
    public static function activeCases(): array
    {
        return [self::PLETON, self::KSATRIA];
    }
}
