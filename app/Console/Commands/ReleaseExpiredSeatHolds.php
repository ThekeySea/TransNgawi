<?php

namespace App\Console\Commands;

use App\Services\BookingService;
use Illuminate\Console\Command;

class ReleaseExpiredSeatHolds extends Command
{
    protected $signature = 'seats:release-expired';

    protected $description = 'Release seat holds that have expired (past 15-minute window)';

    public function handle(BookingService $bookingService): int
    {
        $released = $bookingService->releaseExpiredHolds();

        if ($released > 0) {
            $this->info("Released {$released} expired seat holds.");
        } else {
            $this->info('No expired seat holds to release.');
        }

        return Command::SUCCESS;
    }
}
