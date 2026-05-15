@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-lg space-y-6">
        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-slate-950/20 glass-panel">
            <h2 class="text-3xl font-semibold text-white">Create an account</h2>
            <p class="mt-2 text-sm text-slate-400">Register for Reserve-Lab and reserve your next studio or lab slot.</p>

            <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-300">Full Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-300">Email address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                </div>
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-slate-300">Password</label>
                        <input type="password" name="password" required class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                    </div>
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-slate-300">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-3xl border border-slate-700 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20" />
                    </div>
                </div>
                <button type="submit" class="w-full rounded-3xl bg-cyan-500 px-5 py-3 text-base font-semibold text-slate-950 transition hover:bg-cyan-400">Create account</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">Already registered? <a href="{{ route('login') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">Log in</a></p>
        </div>
    </div>
@endsection
