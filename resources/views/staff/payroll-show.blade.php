<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Breakdown | {{ $staff['name'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'active-accent': '#2563eb',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f8fafc',
                        primary: '#1e40af',
                        'on-surface-variant': '#64748b',
                        'border-subtle': '#e2e8f0',
                    },
                    borderRadius: {
                        DEFAULT: '0.25rem',
                        lg: '0.5rem',
                        xl: '0.75rem',
                        full: '9999px',
                    },
                    fontFamily: {
                        sans: ['Public Sans', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Public Sans', sans-serif; background-color: #f1f5f9; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .data-table-row:hover { background-color: #f8fafc; }
        .academic-border { border-left: 4px solid #2563eb; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-slate-100 text-slate-900">
    @include('partials.sidebar', ['activeSection' => 'staff', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-hidden">
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between bg-surface-container-lowest px-8 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-64 rounded-full border-none bg-slate-50 py-1.5 pl-10 pr-4 text-sm transition-all focus:ring-2 focus:ring-active-accent/20" placeholder="Search staff payroll..." type="text">
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 text-on-surface-variant">
                    <button class="relative transition-colors hover:text-active-accent">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute right-0 top-0 h-2 w-2 rounded-full border-2 border-white bg-red-500"></span>
                    </button>
                    <button class="transition-colors hover:text-active-accent">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-xs font-semibold leading-none text-slate-900">Welcome back, Van</p>
                        <p class="mt-1 text-[10px] font-bold uppercase text-slate-500">Administrator</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-active-accent/10 bg-blue-100 text-sm font-bold text-blue-700">V</div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="mb-6">
                <x-back-button :href="route('staff.show', ['staff' => $staff['id'], 'tab' => 'payroll'])" label="Back to Staff Payroll" />
            </div>

            <div class="academic-border mb-8 flex items-center justify-between rounded-xl border border-border-subtle bg-white p-6 shadow-sm">
                <div class="flex items-center gap-6">
                    <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-primary text-2xl font-bold text-white">
                        {{ collect(explode(' ', $staff['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $staff['name'] }}</h2>
                        <div class="mt-1 flex gap-4">
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">{{ $payrollBreakdown['summary']['role'] }}</span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">{{ $payrollBreakdown['summary']['employment_badge'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-500">{{ $payrollBreakdown['summary']['headline_label'] }}</p>
                    <p class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $payrollBreakdown['summary']['headline_total'] }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-border-subtle bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-border-subtle bg-slate-50/50 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Staff Payroll Details: {{ $payrollBreakdown['summary']['period'] }}</h3>
                        <p class="mt-0.5 text-sm text-slate-500">{{ $payrollBreakdown['summary']['subtitle'] }}</p>
                    </div>
                    <button class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold transition-colors hover:bg-slate-50">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                        Export CSV
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-4 border-b border-border-subtle bg-white px-6 py-4">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Filter By:</label>
                    </div>
                    <select class="rounded-lg border-slate-200 py-1.5 pl-3 pr-8 text-sm font-medium text-slate-600 transition-all focus:ring-2 focus:ring-active-accent/20">
                        <option>All Days</option>
                        @foreach (collect($payrollBreakdown['rows'])->pluck('day')->unique()->values() as $day)
                            <option>{{ $day }}</option>
                        @endforeach
                    </select>
                    <select class="rounded-lg border-slate-200 py-1.5 pl-3 pr-8 text-sm font-medium text-slate-600 transition-all focus:ring-2 focus:ring-active-accent/20">
                        <option>All Categories</option>
                        @foreach (collect($payrollBreakdown['rows'])->pluck('category')->filter()->unique()->values() as $category)
                            <option>{{ $category }}</option>
                        @endforeach
                    </select>
                    <div class="ml-auto text-sm font-semibold text-slate-500">Payroll Record: <span class="text-slate-900">{{ $payrollRecord['id'] }}</span></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-border-subtle bg-slate-50/80">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Date</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Day</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Work Item</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Category</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Hours</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Rate</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($payrollBreakdown['rows'] as $row)
                                <tr class="data-table-row transition-colors">
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $row['date'] }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $row['day'] }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $row['item'] ?? 'Staff payroll item' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $row['category'] ?? 'Regular Work' }}</td>
                                    <td class="px-6 py-4 text-center text-sm font-medium text-slate-700">{{ $row['hours'] ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right text-sm text-slate-600">{{ $row['rate'] ?? ($row['hourly_rate'] ?? '-') }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">{{ $row['amount'] ?? ($row['daily_income'] ?? '-') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-900 text-white">
                                <td class="px-6 py-5 text-sm font-medium" colspan="4">Staff Payroll Summary</td>
                                <td class="px-6 py-5 text-right text-sm font-bold uppercase tracking-wider" colspan="2">Total Pay</td>
                                <td class="px-6 py-5 text-right text-lg font-extrabold">{{ $payrollBreakdown['summary']['total_earnings'] }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex items-center justify-between border-t border-border-subtle bg-slate-50/30 px-6 py-4">
                    <div class="text-sm font-medium text-slate-500">
                        Showing <span class="font-bold text-slate-900">1</span> to <span class="font-bold text-slate-900">{{ count($payrollBreakdown['rows']) }}</span> of <span class="font-bold text-slate-900">{{ $payrollBreakdown['summary']['total_records'] }}</span> records
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="rounded-lg border border-slate-200 bg-white p-2 text-slate-400 transition-colors hover:bg-slate-50">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>
                        <button class="h-10 w-10 rounded-lg bg-active-accent text-sm font-bold text-white shadow-sm">1</button>
                        <button class="h-10 w-10 rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-50">2</button>
                        <button class="h-10 w-10 rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-50">3</button>
                        <button class="rounded-lg border border-slate-200 bg-white p-2 text-slate-600 transition-colors hover:bg-slate-50">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
