<?php

namespace App\Support;

use App\Enums\BusModelType;

/**
 * Otoritas backend untuk peta kursi per model bus.
 *
 * v1 (didokumentasikan di docs/ARCHITECTURE.md §19):
 * - BIASANE: 40 kursi (10 baris A–J × 4 kolom). Baris A–B = SukianPlus (8),
 *   baris C–J = Sukian (32). Tanpa SukianPro.
 * - ANTIBU_SATSET: 30 kursi (10 baris A–J × 3 kolom). Baris A–C = SukianPro (9),
 *   baris D–F = SukianPlus (9), baris G–J = Sukian (12).
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
        return $model === BusModelType::BIASANE
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
        if ($model === BusModelType::BIASANE) {
            return self::build(range('A', 'J'), [1, 2, 3, 4], fn (string $row) => in_array($row, ['A', 'B'], true)
                ? 'SukianPlus'
                : 'Sukian');
        }

        return self::build(range('A', 'J'), [1, 2, 3], function (string $row): string {
            if (in_array($row, ['A', 'B', 'C'], true)) {
                return 'SukianPro';
            }

            return in_array($row, ['D', 'E', 'F'], true) ? 'SukianPlus' : 'Sukian';
        });
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
