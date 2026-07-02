<x-customer-layout>
    <section class="grid gap-8 lg:grid-cols-[1.4fr_0.9fr]">
        <div class="space-y-8">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-slate-900 p-8 text-white shadow-[0_30px_80px_-35px_rgba(15,23,42,0.75)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(249,115,22,0.22),_transparent_28%),linear-gradient(135deg,_rgba(15,23,42,0.95),_rgba(30,41,59,0.98))]"></div>
                <div class="relative grid gap-8 lg:grid-cols-[1.25fr_0.75fr] lg:items-end">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-orange-300/80">Client dashboard</p>
                        <h1 class="mt-4 max-w-2xl text-4xl font-black tracking-tight text-white sm:text-5xl">
                            Good food, clear status, and a dashboard that scales with your next features.
                        </h1>
                        <p class="mt-5 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                            A focused client space for tracking orders, account value, and future commerce actions without the clutter.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#activity" class="rounded-full bg-white px-5 py-3 text-sm font-bold text-slate-900 transition hover:bg-slate-100">
                                View activity
                            </a>
                            <a href="#account" class="rounded-full border border-white/15 bg-white/5 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10">
                                Account summary
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <div class="rounded-3xl border border-white/10 bg-white/8 p-5 backdrop-blur">
                            <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-300">Total spent</div>
                            <div class="mt-3 text-3xl font-black">{{ number_format($totalSpent ?? 0, 0, ',', ' ') }} F</div>
                            <div class="mt-2 text-sm text-slate-300">Current account value across completed orders.</div>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/8 p-5 backdrop-blur">
                            <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-300">Items ordered</div>
                            <div class="mt-3 text-3xl font-black">{{ $burgersCount ?? 0 }}</div>
                            <div class="mt-2 text-sm text-slate-300">A concise count that can later power loyalty logic.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="activity" class="rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Activity</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Current order status</h2>
                    </div>

                    <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-bold text-slate-700">
                        Live view ready
                    </div>
                </div>

                <div class="mt-6">
                    @if($latestOrder && in_array($latestOrder->status, ['en_attente', 'en_preparation', 'prete']))
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6">
                            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Order number</div>
                                    <div class="mt-2 text-xl font-black text-slate-900">#{{ $latestOrder->numero_commande }}</div>
                                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                                        @if($latestOrder->status === 'en_attente')
                                            Your order has been received and is waiting to enter the kitchen queue.
                                        @elseif($latestOrder->status === 'en_preparation')
                                            Your order is in progress. The kitchen team is preparing it now.
                                        @else
                                            Your order is ready. You can collect it as soon as possible.
                                        @endif
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm">
                                    <div class="text-xs uppercase tracking-[0.22em] text-slate-400">Timeline</div>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-2 {{ $latestOrder->status === 'en_attente' ? 'text-orange-600' : 'text-slate-500' }}">
                                            <span class="h-2.5 w-2.5 rounded-full bg-current"></span> Validated
                                        </div>
                                        <div class="flex items-center gap-2 {{ $latestOrder->status === 'en_preparation' ? 'text-orange-600' : 'text-slate-500' }}">
                                            <span class="h-2.5 w-2.5 rounded-full bg-current"></span> In kitchen
                                        </div>
                                        <div class="flex items-center gap-2 {{ $latestOrder->status === 'prete' ? 'text-orange-600' : 'text-slate-500' }}">
                                            <span class="h-2.5 w-2.5 rounded-full bg-current"></span> Ready
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-amber-400 transition-all duration-700"
                                         style="width: {{ $latestOrder->status === 'en_attente' ? '33' : ($latestOrder->status === 'en_preparation' ? '66' : '100') }}%"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 p-8">
                            <div class="max-w-lg">
                                <h3 class="text-xl font-black text-slate-900">No active order right now</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">
                                    This space is ready for live order tracking, recent purchases, and future customer actions.
                                </p>
                            </div>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="/catalogue" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                    Start a new order
                                </a>
                                <a href="#account" class="rounded-full border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                                    Review account
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <aside id="account" class="space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Account</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Profile snapshot</h2>

                <dl class="mt-6 space-y-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <dt class="text-sm font-medium text-slate-500">Name</dt>
                        <dd class="mt-1 text-base font-bold text-slate-900">{{ auth()->user()?->name ?? 'Client' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 break-all text-base font-bold text-slate-900">{{ auth()->user()?->email ?? 'Not available' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <dt class="text-sm font-medium text-slate-500">Total spent</dt>
                        <dd class="mt-1 text-base font-bold text-slate-900">{{ number_format($totalSpent ?? 0, 0, ',', ' ') }} F</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <dt class="text-sm font-medium text-slate-500">Orders tracked</dt>
                        <dd class="mt-1 text-base font-bold text-slate-900">{{ $burgersCount ?? 0 }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-slate-900 p-7 text-white shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Next step</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight">This dashboard is ready to grow.</h3>
                <p class="mt-4 text-sm leading-6 text-slate-300">
                    You can connect live orders, catalog actions, loyalty metrics, and payment history into this structure without redesigning the page.
                </p>

                <div class="mt-6 flex flex-col gap-3">
                    <a href="#activity" class="rounded-full bg-white px-5 py-3 text-center text-sm font-bold text-slate-900 transition hover:bg-slate-100">
                        Inspect activity
                    </a>
                    <a href="/catalogue" class="rounded-full border border-white/15 bg-white/5 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-white/10">
                        Go to catalogue
                    </a>
                </div>
            </div>
        </aside>
    </section>
</x-customer-layout>