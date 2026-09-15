<?php

namespace App\Support;

use App\Enums\BusModelType;

/**
 * Otoritas backend untuk peta kursi per model bus.
 *
 * PLETON: 40 kursi (10 baris A–J × 4 kolom, layout 2-2).
 *   Baris A–B = SukianPlus (8), baris C–J = Sukian (32).
 *
 * KSATRIA: 30 kursi (mixed layout):
 *   Baris A–D = SukianPro (8 pods, layout 1-1 sleeper).
 *   Baris E–I = SukianPlus (10 kursi, layout 1-1 executive).
 *   Baris J–L = Sukian (12 kursi, layout 2-2 standar).
 */
class BusSeatTemplate
{
    /**
     * Kelas yang boleh dijual untuk suatu model bus.
     *
     * @return array<int, string>
     */
    public static function allowedClasses(BusModelType $model): array
    {
        return $model->resolve() === BusModelType::PLETON
            ? ['Sukian', 'SukianPlus']
            : ['Sukian', 'SukianPlus', 'SukianPro'];
    }

    /**
     * Daftar kursi template: seat_code (format BarisKolom, mis. A1) + class_name.
     *
     * @return array<int, array{seat_code: string, class_name: string}>
     */
    public static function seats(BusModelType $model): array
    {
        $resolved = $model->resolve();

        if ($resolved === BusModelType::PLETON) {
            return self::build(range('A', 'J'), [1, 2, 3, 4], fn (string $row) => in_array($row, ['A', 'B'], true)
                ? 'SukianPlus'
                : 'Sukian');
        }

        // KSATRIA: mixed layout per section
        return array_merge(
            // Section 1: SukianPro (1-1 sleeper pods), Rows A–D
            self::build(range('A', 'D'), [1, 2], fn (string $row) => 'SukianPro'),
            // Section 2: SukianPlus (1-1 executive), Rows E–I
            self::build(range('E', 'I'), [1, 2], fn (string $row) => 'SukianPlus'),
            // Section 3: Sukian (2-2 standard), Rows J–L
            self::build(range('J', 'L'), [1, 2, 3, 4], fn (string $row) => 'Sukian')
        );
    }

    /**
     * @param array<int, string> $rows
     * @param array<int, int> $cols
     * @return array<int, array{seat_code: string, class_name: string}>
     */
    private static function build(array $rows, array $cols, callable $classFor): array
    {
        $seats = [];

        foreach ($rows as $row) {
            foreach ($cols as $col) {
                $seats[] = ['seat_code' => $row.$col, 'class_name' => $classFor($row)];
            }
        }

        return $seats;
    }
}
