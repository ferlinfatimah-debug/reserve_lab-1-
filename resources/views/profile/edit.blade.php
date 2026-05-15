@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-8 glass-panel shadow-xl shadow-slate-950/20">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">Edit Profile</h2>
                <p class="mt-2 text-sm text-slate-400">Update your name, email, and profile photo.</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[280px_1fr]">
            <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-6">
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile photo" class="h-40 w-40 rounded-3xl object-cover" />
                @else
                    <div class="flex h-40 w-40 items-center justify-center rounded-3xl bg-slate-800 text-4xl font-semibold text-slate-200">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <p class="mt-4 text-sm text-slate-400">Upload a square profile photo for better display.</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-3xl border border-white/10 bg-slate-950/70 p-8">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="profile_photo">Profile Photo</label>
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 outline-none file:rounded-full file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:text-slate-950" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-full bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
