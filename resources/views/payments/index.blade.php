<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payments &amp; Refunds | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: '#f7f9fb',
                        surface: '#f7f9fb',
                        primary: '#022448',
                        secondary: '#006397',
                        success: '#27ae60',
                        warning: '#f1c40f',
                        error: '#e74c3c',
                        outline: '#74777f',
                        'outline-variant': '#c4c6cf',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-high': '#e6e8ea',
                        'surface-container-lowest': '#ffffff',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#43474e',
                        'active-accent': '#00bfff',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '0.75rem',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'payments', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-y-auto bg-[#f0f2f5]">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center overflow-hidden rounded border border-white/20 bg-white/20 text-lg font-bold shadow-sm">V</div>
                <div class="flex flex-col">
                    <h1 class="text-xl font-bold leading-none">Welcome back, Van</h1>
                    <p class="text-[11px] font-medium opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="flex h-9 w-9 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl text-white">search</span>
                </button>
                <button class="flex h-9 w-9 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl text-white">notifications</span>
                </button>
                <button class="flex h-9 w-9 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl text-white">settings</span>
                </button>
            </div>
        </header>

        <div class="mx-auto w-full max-w-[1600px] space-y-6 bg-white p-8">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-primary">Payments &amp; Refunds</h2>
                    <p class="mt-1 text-sm text-on-surface-variant">Monitor student payments, discounts, refund status, and payment methods.</p>
                </div>
                <button class="flex h-10 items-center gap-2 rounded bg-primary px-4 text-sm font-bold text-white shadow-sm transition-all hover:bg-primary/90 active:scale-95">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export Report
                </button>
            </div>

            <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($paymentSummaries as $summary)
                    <div class="relative overflow-hidden rounded-lg border border-surface-container-high bg-surface-container-lowest p-6 shadow-sm">
                        <div class="absolute left-0 top-0 h-full w-1.5 {{ $summary['accent'] }}"></div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">{{ $summary['label'] }}</p>
                                <h3 class="text-3xl font-bold text-primary">{{ $summary['amount'] }}</h3>
                            </div>
                            <div class="rounded-full p-2 {{ $summary['icon_class'] }}">
                                <span class="material-symbols-outlined">{{ $summary['icon'] }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-1.5">
                            <span class="flex items-center rounded-full px-2 py-0.5 text-xs font-bold {{ $summary['meta_class'] }}">
                                @if ($summary['meta_icon'])
                                    <span class="material-symbols-outlined text-sm">{{ $summary['meta_icon'] }}</span>
                                @endif
                                {{ $summary['meta'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="rounded-lg border border-surface-container-high bg-surface-container-lowest p-6 shadow-sm">
                <div class="grid grid-cols-1 items-end gap-5 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">By Country</label>
                        <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                            <option>All Countries</option>
                            @foreach ($countryOptions as $country)
                                <option>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">By Date Range</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2 text-lg text-outline">calendar_today</span>
                            <input class="w-full rounded border border-outline-variant bg-white py-2 pl-10 pr-3 text-sm focus:border-primary focus:ring-primary" placeholder="Select dates..." type="text">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">By Package</label>
                        <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                            <option>All Packages</option>
                            <option>Intensive IELTS 50</option>
                            <option>Business English Pro</option>
                            <option>Casual Conversation 20</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button class="h-10 flex-1 rounded bg-primary px-6 text-sm font-bold text-white transition-all hover:bg-primary/90 active:scale-95">Apply</button>
                        <button class="h-10 flex-1 rounded border border-outline-variant px-6 text-sm font-bold text-on-surface-variant transition-all hover:bg-surface active:scale-95">Reset</button>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg border border-surface-container-high bg-surface-container-lowest shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[1180px] w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-surface-container-high bg-surface-container-low">
                                <th class="p-4 w-10"><input class="rounded border-outline-variant text-active-accent focus:ring-active-accent" type="checkbox"></th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Student</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Category</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Date &amp; Time</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Package</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Details</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Amount Paid</th>
                                <th class="p-4 text-center text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Refunded</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Note</th>
                                <th class="p-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Method</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-high">
                            @foreach ($paymentTransactions as $transaction)
                                <tr class="transition-colors hover:bg-surface-container-low">
                                    <td class="p-4"><input class="rounded border-outline-variant text-active-accent" type="checkbox"></td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-primary">{{ $transaction['student'] }}</span>
                                            <span class="text-[11px] text-on-surface-variant">{{ $transaction['student_id'] }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="rounded-full border px-2.5 py-1 text-[10px] font-bold {{ $transaction['category_class'] }}">{{ $transaction['category'] }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col text-[13px]">
                                            <span class="font-medium text-on-surface">{{ $transaction['date'] }}</span>
                                            <span class="text-on-surface-variant">{{ $transaction['time'] }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-[13px] font-medium text-on-surface">{{ $transaction['package'] }}</td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span class="text-[12px] font-bold text-primary">{{ $transaction['country'] }}</span>
                                            <span class="text-[10px] font-medium {{ $transaction['discount_class'] }}">{{ $transaction['discount'] }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-[13px] font-bold text-primary">{{ $transaction['amount'] }}</td>
                                    <td class="p-4 text-center">
                                        <span class="rounded-full border px-2 py-0.5 text-[10px] font-bold uppercase {{ $transaction['refund_class'] }}">{{ $transaction['refunded'] }}</span>
                                    </td>
                                    <td class="p-4">
                                        <button class="flex items-center gap-1 text-[12px] font-medium text-secondary transition-colors hover:text-active-accent hover:underline">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                            View
                                        </button>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px] text-secondary">{{ $transaction['icon'] }}</span>
                                            <span class="text-[12px] font-medium">{{ $transaction['method'] }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between border-t border-surface-container-high bg-surface-container-low p-4">
                    <p class="text-[12px] text-on-surface-variant">Showing 1 to {{ count($paymentTransactions) }} of 142 entries</p>
                    <div class="flex gap-1">
                        <button class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded border border-outline-variant bg-white text-on-surface-variant opacity-50">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button class="flex h-8 w-8 items-center justify-center rounded bg-active-accent text-xs font-bold text-white shadow-sm">1</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-xs font-medium text-on-surface-variant hover:bg-surface">2</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-xs font-medium text-on-surface-variant hover:bg-surface">3</button>
                        <span class="px-1 py-2 text-on-surface-variant">...</span>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-xs font-medium text-on-surface-variant hover:bg-surface">18</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-on-surface-variant hover:bg-surface">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
