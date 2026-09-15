<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TripSeatStatus;
use App\Http\Controllers\Controller;
use App\Models\TripSeat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripSeatController extends Controller
{
    public function toggleMaintenance(TripSeat $seat): RedirectResponse
    {
        // Protection: SOLD or HELD seats cannot be toggled
        if (in_array($seat->status, [TripSeatStatus::SOLD, TripSeatStatus::HELD])) {
            return back()->with('error', 'Kursi sedang ditahan atau sudah dibeli penumpang, tidak dapat ditandai rusak.');
        }

        $newStatus = $seat->status === TripSeatStatus::BLOCKED
            ? TripSeatStatus::AVAILABLE
            : TripSeatStatus::BLOCKED;

        $newIsDamaged = $newStatus === TripSeatStatus::BLOCKED;

        DB::transaction(function () use ($seat, $newStatus, $newIsDamaged) {
            $seat->update([
                'status' => $newStatus,
                'is_damaged' => $newIsDamaged,
            ]);
        });

        $seat->refresh();

        Log::info('Seat toggled', [
            'seat_id' => $seat->id,
            'seat_code' => $seat->seat_code,
            'trip_id' => $seat->trip_id,
            'new_status' => $seat->status->value,
            'is_damaged' => $seat->is_damaged,
        ]);

        $label = $newStatus === TripSeatStatus::BLOCKED ? 'ditandai rusak' : 'diperbaiki dan siap digunakan kembali';

        return back()->with('status', "Kursi {$seat->seat_code} berhasil {$label}.");
    }
}
