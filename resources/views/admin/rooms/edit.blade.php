@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-8 glass-panel shadow-xl shadow-slate-950/20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">Edit Room</h2>
                <p class="mt-2 text-sm text-slate-400">Update the room details and save changes.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-slate-200 transition hover:border-cyan-400 hover:text-cyan-300">Back to Admin Dashboard</a>
        </div>

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="mt-8 grid gap-6 rounded-3xl border border-white/10 bg-slate-950/70 p-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-200" for="room_name">Room Name</label>
                <input id="room_name" name="room_name" value="{{ old('room_name', $room->room_name) }}" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="type">Type</label>
                <select id="type" name="type" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                    <option value="lab" {{ old('type', $room->type) === 'lab' ? 'selected' : '' }}>Lab</option>
                    <option value="studio" {{ old('type', $room->type) === 'studio' ? 'selected' : '' }}>Studio</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="capacity">Capacity</label>
                <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity', $room->capacity) }}" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200" for="status">Status</label>
                <select id="status" name="status" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20">
                    <option value="active" {{ old('status', $room->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-full bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Update room</button>
            </div>
        </form>
    </div>
</div>
@endsection
