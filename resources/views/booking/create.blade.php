@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-8">
    <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 glass-panel shadow-xl shadow-slate-950/20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">New Booking</h2>
                <p class="mt-1 text-sm text-slate-400">Reserve a lab or studio slot with a single request.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-full border border-slate-700 px-5 py-3 text-sm text-slate-200 transition hover:border-cyan-400">Back to dashboard</a>
        </div>

        <form action="{{ route('booking.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            <div class="grid gap-6 lg:grid-cols-2">
                <label class="block space-y-2 text-sm text-slate-200">
                    <span>Room</span>
                    <select name="room_id" required class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                        <option value="">Select room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>{{ $room->room_name }} • {{ ucfirst($room->type) }} • {{ $room->capacity }} seats</option>
                        @endforeach
                    </select>
                </label>

                <label class="block space-y-2 text-sm text-slate-200">
                    <span>Time slot</span>
                    <select name="slot_id" required class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                        <option value="">Select slot</option>
                        @foreach($slots as $slot)
                            <option value="{{ $slot->id }}" @selected(old('slot_id') == $slot->id)>{{ \Illuminate\Support\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($slot->end_time)->format('H:i') }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label class="block space-y-2 text-sm text-slate-200">
                <span>Booking date</span>
                <input type="date" name="booking_date" required value="{{ old('booking_date', now()->toDateString()) }}" class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
            </label>

            <button type="submit" class="w-full rounded-3xl bg-cyan-500 px-5 py-3 text-base font-semibold text-slate-950 transition hover:bg-cyan-400">Submit booking</button>
        </form>
    </div>
</div>
@endsection
