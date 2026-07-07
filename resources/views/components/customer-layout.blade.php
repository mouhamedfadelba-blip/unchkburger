@php
    $currentUser = auth()->user();
@endphp

<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.08),_transparent_30%),linear-gradient(180deg,_#fffdfb_0%,_#f8fafc_100%)] text-slate-900">
    <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-lg shadow-slate-200">
                    <span class="text-lg font-black">U</span>
                </div>
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Client area</div>
                    <div class="text-xl font-black tracking-tight text-slate-900">UNCHK Burger</div>
                </div>
            </a>

            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('customer.dashboard') }}" class="rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                    Dashboard
                </a>
                <a href="#activity" class="rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                    Activity
                </a>
                <a href="#account" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Account
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Signed in as</div>
                    <div class="text-sm font-bold text-slate-900">{{ $currentUser?->name ?? 'Client' }}</div>
                </div>

                <div class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">
                    Guest mode
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</div>