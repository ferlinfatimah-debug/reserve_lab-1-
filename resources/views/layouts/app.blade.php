<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve-Lab</title>
    @vite(['resources/css/app.css'])
    <style>
        body { background: radial-gradient(circle at top, rgba(56,189,248,0.16), transparent 35%), linear-gradient(180deg, #0f172a 0%, #020617 100%); }
        .glass-panel { background: rgba(15, 23, 42, 0.82); backdrop-filter: blur(18px); border: 1px solid rgba(148, 163, 184, 0.12); }
        .badge { display: inline-flex; align-items: center; justify-content: center; border-radius: 9999px; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; }
    </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 rounded-3xl border border-white/10 bg-slate-950/30 p-6 shadow-2xl shadow-slate-950/20 glass-panel sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-cyan-300">Reserve-Lab</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-400">A premium reservation system for labs and studios with approval workflows.</p>
            </div>
            <div class="flex flex-wrap gap-3 text-sm">
                @auth
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full object-cover border border-white/10" />
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-xs font-semibold text-slate-200">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @endif
                    <span class="badge bg-slate-700/70 text-cyan-100">{{ auth()->user()->name }}</span>
                    <a href="{{ route('profile.edit') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-slate-200 transition hover:border-cyan-400 hover:text-cyan-300">My Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-slate-200 transition hover:border-cyan-400 hover:text-cyan-300">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-full bg-cyan-500 px-4 py-2 text-slate-950 transition hover:bg-cyan-400">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200 transition hover:border-cyan-400 hover:text-cyan-300">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Register</a>
                @endauth
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-200">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-rose-200">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-rose-100">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
