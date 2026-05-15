@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 glass-panel shadow-xl shadow-slate-950/20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">Admin Approval Panel</h2>
                <p class="mt-2 text-sm text-slate-400">Review pending requests, manage rooms, and export booking reports.</p>
            </div>
            <a href="{{ route('admin.bookings.export') }}" class="inline-flex items-center rounded-full bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Export to PDF</a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-white/10 bg-slate-950/80 glass-panel">
        <table class="min-w-full divide-y divide-slate-700 text-sm text-slate-200">
            <thead class="bg-slate-950/70 text-left text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Room</th>
                    <th class="px-6 py-4">Slot</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($bookings as $booking)
                    <tr class="transition hover:bg-slate-950/60">
                        <td class="px-6 py-4">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4">{{ $booking->room->room_name }}</td>
                        <td class="px-6 py-4">{{ $booking->slot->label }}</td>
                        <td class="px-6 py-4">{{ $booking->booking_date->format('M j, Y') }}</td>
                        <td class="px-6 py-4"><span class="badge bg-amber-500/15 text-amber-200">{{ strtoupper($booking->status) }}</span></td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.booking.update', $booking) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="status" class="rounded-2xl border border-slate-700 bg-slate-900/70 px-3 py-2 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                                <button type="submit" class="rounded-2xl bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">No pending or approved bookings available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-8 glass-panel shadow-xl shadow-slate-950/20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">Add New Room</h2>
                <p class="mt-2 text-sm text-slate-400">Create a room for admin booking management.</p>
            </div>
        </div>

        <form action="{{ route('admin.rooms.store') }}" method="POST" class="mt-8 grid gap-4 lg:grid-cols-2">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-200" for="room_name">Room Name</label>
                <input id="room_name" name="room_name" type="text" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="type">Type</label>
                <select id="type" name="type" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                    <option value="lab">Lab</option>
                    <option value="studio">Studio</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="capacity">Capacity</label>
                <input id="capacity" name="capacity" type="number" min="1" value="1" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="status">Status</label>
                <select id="status" name="status" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <div class="lg:col-span-2 flex justify-end">
                <button type="submit" class="rounded-full bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Create room</button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-white/10 bg-slate-950/80 glass-panel">
        <table class="min-w-full divide-y divide-slate-700 text-sm text-slate-200">
            <thead class="bg-slate-950/70 text-left text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-6 py-4">Room Name</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Capacity</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($rooms as $room)
                    <tr class="transition hover:bg-slate-950/60">
                        <td class="px-6 py-4">{{ $room->room_name }}</td>
                        <td class="px-6 py-4">{{ ucfirst($room->type) }}</td>
                        <td class="px-6 py-4">{{ $room->capacity }}</td>
                        <td class="px-6 py-4"><span class="badge {{ $room->status === 'active' ? 'bg-emerald-500/15 text-emerald-200' : 'bg-amber-500/15 text-amber-200' }}">{{ ucfirst($room->status) }}</span></td>
                        <td class="px-6 py-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="rounded-full border border-slate-700 bg-slate-900/70 px-4 py-2 text-sm text-slate-200 transition hover:border-cyan-400">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-rose-600 bg-rose-600/10 px-4 py-2 text-sm text-rose-200 transition hover:bg-rose-600/20">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">No rooms have been added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
