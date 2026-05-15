@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-lg space-y-6">
        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-slate-950/20 glass-panel">
            <h2 class="text-3xl font-semibold text-white">Login</h2>
            <p class="mt-2 text-sm text-slate-400">Access your Reserve-Lab dashboard.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-300">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-300">Password</label>
                    <input type="password" name="password" required class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>
                <button type="submit" class="w-full rounded-3xl bg-cyan-500 px-5 py-3 text-base font-semibold text-slate-950 transition hover:bg-cyan-400">Sign in</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">Register</a></p>
        </div>
    </div>
@endsection
