<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $bookings = $user->bookings()->with(['room', 'slot'])->orderByDesc('booking_date')->get();

        return view('user.dashboard', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'active')->orderBy('room_name')->get();
        $slots = TimeSlot::orderBy('start_time')->get();

        return view('booking.create', compact('rooms', 'slots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'slot_id' => ['required', 'exists:time_slots,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $exists = Booking::where('room_id', $data['room_id'])
            ->where('slot_id', $data['slot_id'])
            ->where('booking_date', $data['booking_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This room is already booked for the selected date and time slot.');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $data['room_id'],
            'slot_id' => $data['slot_id'],
            'booking_date' => $data['booking_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking request submitted. Awaiting approval.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeCancellation($booking);

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    }

    protected function authorizeCancellation(Booking $booking): void
    {
        if ($booking->user_id !== Auth::id() || in_array($booking->status, ['cancelled', 'no_show', 'rejected'])) {
            abort(403);
        }
    }
}
