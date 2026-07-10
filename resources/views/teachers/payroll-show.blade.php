<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Breakdown | {{ $teacher['name'] }}</title>
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
<body class="flex h-screen overflow-hidden text-slate-900">
    @include('partials.sidebar', ['activeSection' => 'teachers', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-hidden">
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between bg-surface-container-lowest px-8 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-64 rounded-full border-none bg-slate-50 py-1.5 pl-10 pr-4 text-sm transition-all focus:ring-2 focus:ring-active-accent/20" placeholder="Search lessons or staff..." type="text">
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
                <x-back-button :href="route('teachers.show', ['teacher' => $teacher['id'], 'tab' => 'payroll'])" label="Back to Payroll Overview" />
            </div>

            <div class="academic-border mb-8 flex flex-col gap-4 rounded-xl border border-border-subtle bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-primary text-xl font-bold text-white sm:h-20 sm:w-20 sm:text-2xl">
                        {{ collect(explode(' ', $teacher['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ $teacher['name'] }}</h2>
                        <div class="mt-1 flex flex-wrap gap-2 sm:gap-4">
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">{{ $payrollBreakdown['summary']['teacher_role'] }}</span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">{{ $payrollBreakdown['summary']['employment_badge'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-sm font-medium text-slate-500">Monthly Earnings ({{ $payrollBreakdown['summary']['period'] }})</p>
                    <p class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">{{ $payrollBreakdown['summary']['total_earnings'] }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-border-subtle bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-border-subtle bg-slate-50/50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Payroll Period Breakdown: {{ $payrollBreakdown['summary']['period'] }}</h3>
                        <p class="mt-0.5 text-sm text-slate-500">{{ $payrollBreakdown['summary']['subtitle'] }}</p>
                    </div>
                    <button class="flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold transition-colors hover:bg-slate-50 sm:w-auto">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                        Export CSV
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-0 border-collapse text-left">
                        <thead>
                            <tr class="border-b border-border-subtle bg-slate-50/80">
                                <th class="px-3 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Date</th>
                                <th class="px-3 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Day</th>
                                <th class="px-3 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Lesson Time</th>
                                <th class="px-3 py-3 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Duration</th>
                                <th class="px-3 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Student Name</th>
                                <th class="px-3 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Category</th>
                                <th class="px-3 py-3 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Hourly Rate</th>
                                <th class="px-3 py-3 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500 sm:px-4 sm:py-4">Daily Income</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($payrollBreakdown['rows'] as $row)
                                <tr class="data-table-row transition-colors">
                                    <td class="px-3 py-4 text-xs font-semibold text-slate-900 sm:px-4 sm:text-sm">{{ $row['date'] }}</td>
                                    <td class="px-3 py-4 text-xs text-slate-600 sm:px-4 sm:text-sm">{{ $row['day'] }}</td>
                                    <td class="px-3 py-4 text-xs font-medium text-slate-700 sm:px-4 sm:text-sm">{{ $row['time'] }}</td>
                                    <td class="px-3 py-4 text-center text-xs sm:px-4 sm:text-sm">
                                        <span class="rounded px-2 py-1 font-medium {{ $row['duration_class'] }}">{{ $row['duration'] }}</span>
                                    </td>
                                    <td class="px-3 py-4 text-xs font-medium text-slate-900 sm:px-4 sm:text-sm">{{ $row['student'] }}</td>
                                    <td class="px-3 py-4 text-xs sm:px-4 sm:text-sm">
                                        <span class="rounded-full border px-2 py-1 text-[10px] font-bold {{ $row['category_class'] }}">{{ $row['category'] }}</span>
                                    </td>
                                    <td class="px-3 py-4 text-right text-xs text-slate-600 sm:px-4 sm:text-sm">{{ $row['hourly_rate'] }}</td>
                                    <td class="px-3 py-4 text-right text-xs font-bold text-slate-900 sm:px-4 sm:text-sm">{{ $row['daily_income'] }}</td>
                                </tr>
                            @endforeach
                            <tr class="data-table-row bg-slate-50/30 italic">
                                <td class="px-3 py-4 text-center text-[11px] text-slate-400 sm:px-4" colspan="8">Showing {{ count($payrollBreakdown['rows']) }} sample rows from {{ $payrollBreakdown['summary']['total_records'] }} records</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-900 text-white">
                                <td class="px-3 py-4 text-xs font-medium sm:px-4 sm:py-5 sm:text-sm" colspan="5">Payroll Cycle Completion Summary</td>
                                <td class="px-3 py-4 text-right text-xs font-bold uppercase tracking-wider sm:px-4 sm:py-5 sm:text-sm" colspan="2">Total Earnings</td>
                                <td class="px-3 py-4 text-right text-base font-extrabold sm:px-4 sm:py-5 sm:text-lg">{{ $payrollBreakdown['summary']['total_earnings'] }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-xl border border-border-subtle bg-white p-5 shadow-sm">
                    <h4 class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Status
                    </h4>
                    <p class="flex items-center gap-2 text-sm font-semibold {{ str_contains(strtolower($payrollRecord['status']), 'paid') ? 'text-green-600' : 'text-amber-600' }}">
                        <span class="h-2 w-2 rounded-full {{ str_contains(strtolower($payrollRecord['status']), 'paid') ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                        {{ $payrollRecord['status'] }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Payroll ID {{ $payrollRecord['id'] }} for {{ $teacher['name'] }}</p>
                </div>

                <div class="rounded-xl border border-border-subtle bg-white p-5 shadow-sm">
                    <h4 class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                        <span class="material-symbols-outlined text-[16px]">account_balance_wallet</span>
                        Payment Method
                    </h4>
                    <p class="text-sm font-semibold text-slate-900">Direct Deposit</p>
                    <p class="mt-1 text-xs text-slate-500">Teacher payout linked to payroll release</p>
                </div>

                <div class="rounded-xl border border-border-subtle bg-white p-5 shadow-sm">
                    <h4 class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                        <span class="material-symbols-outlined text-[16px]">history</span>
                        Reference
                    </h4>
                    <p class="text-sm font-semibold text-slate-900">{{ $payrollRecord['slug'] }}-{{ strtoupper(str_replace('-', '', $teacher['id'])) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Internal Reference ID</p>
                </div>
            </div>
        </div>

        <footer class="flex h-12 items-center justify-between border-t border-border-subtle bg-white px-8 text-[11px] font-medium text-slate-400">
            <p>&copy; 2024 SpeakRyt Administrative Systems. Internal Use Only.</p>
            <div class="flex gap-6">
                <a class="hover:text-active-accent" href="#">System Status</a>
                <a class="hover:text-active-accent" href="#">Help Center</a>
                <a class="hover:text-active-accent" href="#">Report an Issue</a>
            </div>
        </footer>
    </main>
</body>
</html>
