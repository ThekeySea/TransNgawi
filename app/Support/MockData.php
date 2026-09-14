<?php

namespace App\Support;

class MockData
{
    public static function serviceTypes(): array
    {
        return [
            ['code' => 'antibu', 'name' => 'ANTIBU', 'label' => 'Antar Ibu Kota'],
            ['code' => 'satset', 'name' => 'SATSET', 'label' => 'Perjalanan Antar Tempat Penting'],
            ['code' => 'biasane', 'name' => 'BIASANE', 'label' => 'Perjalanan Reguler'],
        ];
    }

    public static function cities(): array
    {
        return ['Surabaya', 'Semarang', 'Yogyakarta', 'Bandung', 'Jakarta', 'Serang', 'Cilegon'];
    }

    public static function classes(): array
    {
        return [
            [
                'code' => 'sukian',
                'name' => 'Sukian',
                'description' => 'Entry/affordable dengan snack gratis dan air mineral.',
                'facilities' => ['Snack gratis', 'Air mineral'],
            ],
            [
                'code' => 'sukianplus',
                'name' => 'SukianPlus',
                'description' => 'Best-value dengan kursi lebih lega dan fasilitas tambahan.',
                'facilities' => ['Kursi lebih lega', 'Massage', 'Snack gratis', 'Air mineral', 'Souvenir keychain'],
            ],
            [
                'code' => 'sukianpro',
                'name' => 'SukianPro',
                'description' => 'Premium sleeper dengan cabin tidur compact dan personal TV.',
                'facilities' => ['Compact sleeping cabin', 'Personal TV'],
            ],
        ];
    }

    public static function routes(): array
    {
        return [
            ['category' => 'antibu', 'origin' => 'Surabaya', 'destination' => 'Jakarta', 'duration' => '13j 30m'],
            ['category' => 'antibu', 'origin' => 'Surabaya', 'destination' => 'Bandung', 'duration' => '11j 15m'],
            ['category' => 'antibu', 'origin' => 'Surabaya', 'destination' => 'Yogyakarta', 'duration' => '6j 45m'],
            ['category' => 'antibu', 'origin' => 'Surabaya', 'destination' => 'Semarang', 'duration' => '4j 30m'],
            ['category' => 'satset', 'origin' => 'Surabaya', 'destination' => 'Cilegon', 'duration' => '14j 00m'],
            ['category' => 'satset', 'origin' => 'Yogyakarta', 'destination' => 'Jakarta', 'duration' => '8j 30m'],
            ['category' => 'biasane', 'origin' => 'Surabaya', 'destination' => 'Serang', 'duration' => '12j 00m'],
        ];
    }

    public static function trips(array $filters = []): array
    {
        $trips = [
            [
                'id' => 1,
                'origin' => 'Surabaya',
                'destination' => 'Jakarta',
                'service' => 'ANTIBU',
                'departure' => '08:00',
                'arrival' => '21:30',
                'duration' => '13j 30m',
                'class' => 'SukianPlus',
                'price' => 285000,
                'seats_available' => 12,
                'facilities' => ['AC', 'Reclining Seat', 'USB'],
            ],
            [
                'id' => 2,
                'origin' => 'Surabaya',
                'destination' => 'Jakarta',
                'service' => 'ANTIBU',
                'departure' => '14:00',
                'arrival' => '03:30',
                'duration' => '13j 30m',
                'class' => 'Sukian',
                'price' => 195000,
                'seats_available' => 8,
                'facilities' => ['AC', 'Snack'],
            ],
            [
                'id' => 3,
                'origin' => 'Surabaya',
                'destination' => 'Bandung',
                'service' => 'ANTIBU',
                'departure' => '09:30',
                'arrival' => '20:45',
                'duration' => '11j 15m',
                'class' => 'SukianPro',
                'price' => 420000,
                'seats_available' => 4,
                'facilities' => ['Sleeper', 'Personal TV'],
            ],
        ];

        if (! empty($filters['origin'])) {
            $trips = array_values(array_filter($trips, fn ($t) => $t['origin'] === $filters['origin']));
        }

        if (! empty($filters['destination'])) {
            $trips = array_values(array_filter($trips, fn ($t) => $t['destination'] === $filters['destination']));
        }

        return $trips;
    }

    public static function trip(int $id): ?array
    {
        foreach (self::trips() as $trip) {
            if ($trip['id'] === $id) {
                return array_merge($trip, [
                    'bus' => 'TN-BUS-042',
                    'model' => 'Mercedes-Benz Tourismo',
                    'fares' => [
                        ['class' => 'Sukian', 'price' => 195000, 'available' => 8],
                        ['class' => 'SukianPlus', 'price' => 285000, 'available' => 12],
                        ['class' => 'SukianPro', 'price' => 420000, 'available' => 4],
                    ],
                    'pricing_note' => 'Harga simulasi untuk prototype.',
                ]);
            }
        }

        return null;
    }

    public static function booking(int $id): array
    {
        return [
            'id' => $id,
            'code' => 'TNX8F29',
            'status' => 'pending_payment',
            'origin' => 'Surabaya',
            'destination' => 'Jakarta',
            'departure_date' => '2026-09-15',
            'departure_time' => '08:00',
            'arrival_time' => '21:30',
            'class' => 'SukianPlus',
            'passengers' => 2,
            'seats' => ['A1', 'A2'],
            'subtotal' => 570000,
            'total' => 570000,
            'expires_at' => now()->addMinutes(30)->toIso8601String(),
        ];
    }

    public static function ticket(string $code): ?array
    {
        if ($code !== 'TNX8F29') {
            return null;
        }

        return [
            'code' => $code,
            'passenger' => 'Budi Santoso',
            'passengers' => [
                ['name' => 'Budi Santoso', 'seat' => 'A1'],
                ['name' => 'Siti Rahayu', 'seat' => 'A2'],
            ],
            'origin' => 'Surabaya',
            'destination' => 'Jakarta',
            'departure_date' => '2026-09-15',
            'departure_time' => '08:00',
            'arrival_time' => '21:30',
            'service' => 'ANTIBU',
            'class' => 'SukianPlus',
            'bus' => 'TN-BUS-042',
            'payment_status' => 'confirmed',
            'boarding_info' => 'Datang 30 menit sebelum keberangkatan di Terminal Purabaya.',
            'qr_code' => $code,
        ];
    }

    public static function journey(int $id): array
    {
        return [
            'id' => $id,
            'booking_code' => 'TNX8F29',
            'origin' => 'Surabaya',
            'destination' => 'Jakarta',
            'status' => 'on_route',
            'is_simulated' => true,
            'timeline' => [
                ['status' => 'scheduled', 'label' => 'Scheduled', 'time' => '07:00', 'done' => true],
                ['status' => 'boarding', 'label' => 'Boarding', 'time' => '07:30', 'done' => true],
                ['status' => 'departed', 'label' => 'Departed', 'time' => '08:00', 'done' => true],
                ['status' => 'on_route', 'label' => 'On Route', 'time' => '12:00', 'done' => true, 'current' => true],
                ['status' => 'arrived', 'label' => 'Arrived', 'time' => '21:30', 'done' => false],
            ],
            'eta' => '21:30',
            'last_updated' => '12:15',
            'progress' => 45,
        ];
    }

    public static function myTrips(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'TNX8F29',
                'origin' => 'Surabaya',
                'destination' => 'Jakarta',
                'date' => '2026-09-15',
                'status' => 'confirmed',
                'type' => 'upcoming',
            ],
            [
                'id' => 2,
                'code' => 'TNX3A12',
                'origin' => 'Yogyakarta',
                'destination' => 'Bandung',
                'date' => '2026-08-20',
                'status' => 'completed',
                'type' => 'past',
            ],
        ];
    }

    public static function helpTopics(): array
    {
        return [
            'Booking', 'Payment', 'Ticket', 'Schedule', 'Boarding',
            'Seat', 'Route', 'Trip Status', 'Refund/Cancellation', 'Other',
        ];
    }

    public static function helpSession(int $id): array
    {
        return [
            'id' => $id,
            'topic' => 'Payment',
            'status' => 'active',
            'booking_code' => 'TNX8F29',
            'messages' => [
                ['sender' => 'customer', 'message' => 'Halo, saya sudah transfer tapi status belum berubah.', 'time' => '10:15'],
                ['sender' => 'admin', 'message' => 'Baik, kami sedang memverifikasi pembayaran Anda.', 'time' => '10:20'],
            ],
        ];
    }

    public static function seatLayout(): array
    {
        $seats = [];
        $rows = ['A', 'B', 'C', 'D'];
        $occupied = ['B2', 'C3', 'D1'];

        foreach ($rows as $row) {
            for ($col = 1; $col <= 4; $col++) {
                $id = $row.$col;
                $seats[] = [
                    'id' => $id,
                    'row' => $row,
                    'col' => $col,
                    'status' => in_array($id, $occupied) ? 'occupied' : 'available',
                ];
            }
        }

        return ['seats' => $seats, 'occupied' => $occupied];
    }
}
