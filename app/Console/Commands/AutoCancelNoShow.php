<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AutoCancelNoShow extends Command
{
    protected $signature = 'bookings:mark-no-show';
    protected $description = 'Mark approved bookings as no-show when the end time has passed and no attendance exists.';

    public function handle(): int
    {
        $now = Carbon::now()->format('H:i:s');

        /** @var \Illuminate\Support\Collection<int, Booking> $bookings */
        $bookings = Booking::where('status', 'approved')
            ->whereHas('slot', fn ($query) => $query->where('end_time', '<', $now))
            ->whereDate('booking_date', '<=', Carbon::today())
            ->doesntHave('attendance')
            ->get();

        foreach ($bookings as $booking) {
            $booking->update(['status' => 'no_show']);
        }

        $this->info('Marked ' . $bookings->count() . ' bookings as no-show.');

        return self::SUCCESS;
    }
}
