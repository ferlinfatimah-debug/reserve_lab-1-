@extends('layouts.app')

@section('content')
<div class="space-y-8">
        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 glass-panel shadow-xl shadow-slate-950/20">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Your Reservations</h2>
                    <p class="mt-1 text-sm text-slate-400">Manage bookings and view approval status.</p>
                </div>
                <a href="{{ route('booking.create') }}" class="inline-flex items-center rounded-full bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Book a room</a>
            </div>
        </div>

        <div class="grid gap-6">
            @forelse($bookings as $booking)
                <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 glass-panel transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-white">{{ $booking->room->room_name }} <span class="text-sm text-slate-400">({{ ucfirst($booking->room->type) }})</span></h3>
                            <p class="mt-2 text-sm text-slate-400">{{ $booking->booking_date->format('F j, Y') }} • {{ $booking->slot->label }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="badge {{ $booking->status === 'approved' ? 'bg-emerald-500/15 text-emerald-200' : ($booking->status === 'pending' ? 'bg-amber-500/15 text-amber-200' : 'bg-rose-500/15 text-rose-200') }}">{{ strtoupper($booking->status) }}</span>
                            @if(in_array($booking->status, ['pending', 'approved']))
                                <form action="{{ route('booking.cancel', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="rounded-full border border-slate-700 px-4 py-2 text-sm text-slate-200 transition hover:border-rose-400 hover:text-rose-200">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-8 text-center glass-panel">
                    <p class="text-slate-400">No reservations found yet. Book your first room today.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
