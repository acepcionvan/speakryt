<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CEO Dashboard | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                        primary: '#022448',
                        secondary: '#006397',
                        success: '#27ae60',
                        warning: '#f1c40f',
                        error: '#e74c3c',
                        outline: '#74777f',
                        'outline-variant': '#c4c6cf',
                        'surface-container': '#eceef0',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-high': '#e6e8ea',
                        'surface-container-lowest': '#ffffff',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#43474e',
                        'text-secondary': '#666666',
                        'active-accent': '#00bfff',
                        'primary-fixed': '#d5e3ff',
                        'secondary-fixed': '#cce5ff',
                    },
                    fontFamily: {
                        display: ['Hanken Grotesk', 'sans-serif'],
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
<body class="flex h-screen overflow-hidden bg-[#eef3f8] font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'dashboard', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-y-auto">
        <header class="sticky top-0 z-40 flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white shadow-md">
            <div class="flex min-w-0 items-center gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded border border-white/20 bg-white/20 text-lg font-bold shadow-sm">V</div>
                <div class="min-w-0">
                    <h1 class="truncate text-xl font-bold leading-none">Good Afternoon, Van</h1>
                    <p class="mt-1 text-[11px] font-medium opacity-90">Founder & CEO · Today is {{ now()->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="hidden w-full max-w-md items-center px-8 xl:flex">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/70 text-xl">search</span>
                    <input class="h-10 w-full rounded-full border border-white/20 bg-white/10 pl-10 pr-4 text-sm text-white placeholder:text-white/70 focus:border-white/50 focus:ring-white/20" placeholder="Search students, teachers, payments...">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="relative flex h-9 w-9 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl text-white">notifications</span>
                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
                <a class="flex items-center gap-3 rounded-full bg-white/10 py-1 pl-1 pr-3 transition-colors hover:bg-white/20" href="{{ route('profile.index') }}">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-bold text-primary">V</span>
                    <span class="hidden text-sm font-bold md:inline">CEO</span>
                </a>
            </div>
        </header>

        <div class="mx-auto flex w-full max-w-[1680px] flex-col gap-6 p-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end">
                    <div>
                        <p class="mb-2 inline-flex rounded-full bg-primary-fixed px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-primary">CEO/Admin only</p>
                        <h2 class="font-display text-3xl font-bold text-primary">Business Command Center</h2>
                        <p class="mt-1 max-w-3xl text-sm text-text-secondary">A fast executive view of lessons, revenue, payroll, students, teachers, alerts, and system health.</p>
                    </div>
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        Sensitive pricing, revenue, and payroll are restricted to CEO/Admin users.
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-8">
                @foreach ($dashboardKpis as $kpi)
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $kpi['icon_class'] }}">
                                <span class="material-symbols-outlined">{{ $kpi['icon'] }}</span>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-bold {{ $kpi['trend_class'] }}">{{ $kpi['trend'] }}</span>
                        </div>
                        <p class="font-display text-2xl font-bold text-primary">{{ $kpi['value'] }}</p>
                        <p class="mt-1 text-xs font-bold uppercase tracking-wider text-text-secondary">{{ $kpi['label'] }}</p>
                    </div>
                @endforeach
            </section>

            @if (! empty($lessonReminderAlerts))
                <section class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                    @foreach ($lessonReminderAlerts as $alert)
                        <div class="flex items-center gap-3 rounded-2xl border px-5 py-4 shadow-sm {{ $alert['class'] }}">
                            <span class="material-symbols-outlined text-[22px]">notifications_active</span>
                            <p class="text-sm font-bold">{{ $alert['message'] }}</p>
                        </div>
                    @endforeach
                </section>
            @endif

            <section class="grid grid-cols-1 gap-6 2xl:grid-cols-12">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm 2xl:col-span-5">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="font-display text-xl font-bold text-primary">CEO Daily Brief</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-3 p-5 lg:grid-cols-2">
                        @foreach ($dailyBriefs as $brief)
                            <div class="rounded-xl border border-slate-200 bg-surface-container-low p-4">
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <p class="font-bold text-primary">{{ $brief['title'] }}</p>
                                    <span class="rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-secondary">{{ $brief['status'] }}</span>
                                </div>
                                <p class="text-sm leading-6 text-text-secondary">{{ $brief['detail'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm 2xl:col-span-7">
                    <div class="flex flex-col justify-between gap-3 border-b border-slate-200 px-5 py-4 lg:flex-row lg:items-center">
                        <div>
                            <h3 class="font-display text-xl font-bold text-primary">Today's Calendar Snapshot</h3>
                            <p class="text-sm text-text-secondary">Live view of today's teaching operations.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a class="rounded-lg border border-secondary bg-white px-3 py-2 text-xs font-bold text-secondary hover:bg-secondary-fixed" href="{{ route('schedule.index') }}">View Full Calendar</a>
                            <a class="rounded-lg bg-primary px-3 py-2 text-xs font-bold text-white hover:opacity-90" href="{{ route('lessons.index') }}">Add Lesson</a>
                            <a class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-xs font-bold text-primary hover:bg-primary-fixed" href="{{ route('schedule.index') }}">Open Schedule</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-[720px] w-full text-left">
                            <thead class="bg-surface-container-high">
                            <tr>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Time</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Student</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Category</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Platform</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($calendarLessons as $lesson)
                                    <tr class="hover:bg-surface-container-low">
                                        <td class="px-5 py-4 text-sm font-bold text-primary">{{ $lesson['time'] }}</td>
                                        <td class="px-5 py-4 text-sm font-semibold">{{ $lesson['student'] }}</td>
                                        <td class="px-5 py-4"><span class="rounded-full border px-3 py-1 text-[11px] font-bold {{ $lesson['category_class'] }}">{{ $lesson['category'] }}</span></td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $lesson['teacher'] }}</td>
                                        <td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-[11px] font-bold {{ $lesson['status_class'] }}">{{ $lesson['status'] }}</span></td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $lesson['platform'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col justify-between gap-3 border-b border-slate-200 px-5 py-4 md:flex-row md:items-center">
                    <div>
                        <h3 class="font-display text-xl font-bold text-primary">Today's Reminders</h3>
                        <p class="text-sm text-text-secondary">Manual WeChat message tasks waiting for admin review.</p>
                    </div>
                    <span class="rounded-full bg-primary-fixed px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary">Advance</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[720px] w-full text-left">
                        <thead class="bg-surface-container-high">
                            <tr>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Student Name</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Reminder Type</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Time</th>
                                <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($todayReminders as $reminder)
                                <tr class="hover:bg-surface-container-low">
                                    <td class="px-5 py-4 text-sm font-bold text-primary">{{ $reminder['student'] }}</td>
                                    <td class="px-5 py-4 text-sm text-text-secondary">{{ $reminder['type'] }}</td>
                                    <td class="px-5 py-4 text-sm font-bold text-primary">{{ $reminder['time'] }}</td>
                                    <td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-[11px] font-bold {{ $reminder['status_class'] }}">{{ $reminder['status'] }}</span></td>
                                    <td class="px-5 py-4 text-right">
                                        <a class="inline-flex h-9 items-center gap-2 rounded-lg bg-primary px-3 text-xs font-bold text-white transition-colors hover:bg-secondary" href="{{ route('students.show', ['student' => $reminder['student_id']]) }}">
                                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                            Open Student
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="grid grid-cols-1 items-start gap-6 2xl:grid-cols-12">
                <div class="self-start rounded-2xl border border-slate-200 bg-white shadow-sm 2xl:col-span-8">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <div>
                            <h3 class="font-display text-xl font-bold text-primary">Revenue Analytics</h3>
                            <p class="text-sm text-text-secondary">Performance over the last 30 days.</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 p-5">
                        @foreach ($revenueSnapshot as $item)
                            <div class="min-w-[100px] flex-1 rounded-xl border border-slate-200 bg-surface-container-low p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-text-secondary">{{ $item['label'] }}</p>
                                <p class="mt-2 font-display text-2xl font-bold {{ $item['class'] }}">{{ $item['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 2xl:col-span-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h3 class="font-display text-xl font-bold text-primary">Student Statistics</h3>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            @foreach ($studentStats as $stat)
                                <div class="rounded-xl border border-slate-200 bg-surface-container-low p-3">
                                    <p class="text-xs font-semibold text-text-secondary">{{ $stat['label'] }}</p>
                                    <p class="mt-1 text-xl font-bold text-primary">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h3 class="font-display text-xl font-bold text-primary">Teacher Statistics</h3>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            @foreach ($teacherStats as $stat)
                                <div class="rounded-xl border border-slate-200 bg-surface-container-low p-3">
                                    <p class="text-xs font-semibold text-text-secondary">{{ $stat['label'] }}</p>
                                    <p class="mt-1 text-xl font-bold text-primary">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-2 2xl:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-2">
                    <h3 class="font-display text-xl font-bold text-primary">Country Distribution</h3>
                    <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($countryDistribution as $country)
                            <div class="rounded-xl border border-slate-200 bg-surface-container-low p-4">
                                <p class="font-bold text-primary">{{ $country['country'] }}</p>
                                <div class="mt-3 grid grid-cols-3 gap-2 text-xs">
                                    <div><p class="text-text-secondary">Students</p><p class="font-bold text-primary">{{ $country['students'] }}</p></div>
                                    <div><p class="text-text-secondary">Packages</p><p class="font-bold text-primary">{{ $country['packages'] }}</p></div>
                                    <div><p class="text-text-secondary">Revenue</p><p class="font-bold text-primary">{{ $country['revenue'] }}</p></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="font-display text-xl font-bold text-primary">Payment Alerts</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($paymentAlerts as $alert)
                            <div class="flex items-center justify-between rounded-xl border px-4 py-3 {{ $alert['class'] }}">
                                <span class="font-bold">{{ $alert['label'] }}</span>
                                <span class="text-xl font-bold">{{ $alert['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-6 2xl:grid-cols-12">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm 2xl:col-span-6">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="font-display text-xl font-bold text-primary">Student Package Status</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-[680px] w-full text-left">
                            <thead class="bg-surface-container-high">
                                <tr>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Student</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Category</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($packageStatuses as $student)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-bold text-primary">{{ $student['student'] }}</td>
                                        <td class="px-5 py-4"><span class="rounded-full border px-3 py-1 text-[11px] font-bold {{ $student['category_class'] }}">{{ $student['category'] }}</span></td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $student['issue'] }}</td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $student['teacher'] }}</td>
                                        <td class="px-5 py-4"><span class="rounded-full bg-amber-50 px-3 py-1 text-[11px] font-bold text-amber-700">{{ $student['action'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm 2xl:col-span-6">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="font-display text-xl font-bold text-primary">Teacher Payroll</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-[760px] w-full text-left">
                            <thead class="bg-surface-container-high">
                                <tr>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Lessons</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Amount</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Due</th>
                                    <th class="px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($teacherPayrollDashboard as $payroll)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-bold text-primary">{{ $payroll['teacher'] }}</td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $payroll['lessons'] }}</td>
                                        <td class="px-5 py-4 text-sm font-bold text-primary">{{ $payroll['amount'] }}</td>
                                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $payroll['due'] }}</td>
                                        <td class="px-5 py-4"><span class="rounded-full bg-blue-50 px-3 py-1 text-[11px] font-bold text-blue-700">{{ $payroll['status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-6 2xl:grid-cols-12">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-5">
                    <h3 class="font-display text-xl font-bold text-primary">Quick Actions</h3>
                    <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4 2xl:grid-cols-2">
                        @foreach ($quickActions as $action)
                            <a class="flex items-center gap-3 rounded-xl border border-slate-200 bg-surface-container-low p-4 text-sm font-bold text-primary transition-colors hover:bg-primary-fixed" href="{{ $action['href'] }}">
                                <span class="material-symbols-outlined text-[22px] text-secondary">{{ $action['icon'] }}</span>
                                {{ $action['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-3">
                    <h3 class="font-display text-xl font-bold text-primary">Notifications</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($dashboardNotifications as $notification)
                            <div class="rounded-xl border border-slate-200 p-3">
                                <p class="text-sm font-bold text-primary">{{ $notification['title'] }}</p>
                                <p class="mt-1 text-xs text-text-secondary">{{ $notification['time'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-2">
                    <h3 class="font-display text-xl font-bold text-primary">To-Do List</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($dashboardTodos as $todo)
                            <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3 text-sm font-semibold text-primary">
                                <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox">
                                {{ $todo }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm 2xl:col-span-2">
                    <h3 class="font-display text-xl font-bold text-primary">System Health</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($systemHealth as $health)
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 px-3 py-2">
                                <span class="text-xs font-semibold text-text-secondary">{{ $health['label'] }}</span>
                                <span class="text-xs font-bold {{ $health['class'] }}">{{ $health['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
