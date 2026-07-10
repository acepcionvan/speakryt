<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Profile | {{ $teacher['name'] }} - SpeakRyt</title>
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
                        'tertiary-fixed': '#c3e8ff',
                        'on-error': '#ffffff',
                        'on-secondary': '#ffffff',
                        'surface-container-high': '#e6e8ea',
                        'surface-container-highest': '#e0e3e5',
                        'on-tertiary-fixed': '#001e2c',
                        'sidebar-bg': '#1e3a5f',
                        'on-primary': '#ffffff',
                        'primary-fixed': '#d5e3ff',
                        'on-surface-variant': '#43474e',
                        'on-tertiary-fixed-variant': '#004c69',
                        'surface-container-lowest': '#ffffff',
                        'on-tertiary': '#ffffff',
                        'on-background': '#191c1e',
                        'success': '#27ae60',
                        'error': '#e74c3c',
                        'tertiary-fixed-dim': '#7ad0ff',
                        'secondary-fixed': '#cce5ff',
                        'surface-variant': '#e0e3e5',
                        'inverse-surface': '#2d3133',
                        'surface': '#f7f9fb',
                        'active-accent': '#00bfff',
                        'primary': '#022448',
                        'text-secondary': '#666666',
                        'on-secondary-fixed': '#001d31',
                        'on-surface': '#191c1e',
                        'secondary-container': '#5cb8fd',
                        'outline': '#74777f',
                        'tertiary-container': '#003e56',
                        'primary-container': '#1e3a5f',
                        'outline-variant': '#c4c6cf',
                        'secondary-fixed-dim': '#92ccff',
                        'background': '#f7f9fb',
                        'on-primary-fixed': '#001c3b',
                        'surface-tint': '#455f87',
                        'on-error-container': '#93000a',
                        'tertiary': '#002738',
                        'on-secondary-container': '#00476e',
                        'on-primary-container': '#8aa4cf',
                        'surface-container': '#eceef0',
                        'surface-bright': '#f7f9fb',
                        'on-secondary-fixed-variant': '#004b73',
                        'surface-container-low': '#f2f4f6',
                        'primary-fixed-dim': '#adc8f5',
                        'secondary': '#006397',
                        'warning': '#f1c40f',
                        'error-container': '#ffdad6',
                        'surface-dim': '#d8dadc',
                        'text-primary': '#333333',
                        'inverse-on-surface': '#eff1f3',
                        'inverse-primary': '#adc8f5',
                        'on-tertiary-container': '#00afea',
                        'on-primary-fixed-variant': '#2d486d',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '0.75rem',
                    },
                    spacing: {
                        unit: '4px',
                        gutter: '24px',
                        'sidebar-width': '260px',
                        'margin-mobile': '16px',
                        'card-padding': '20px',
                        'margin-desktop': '32px',
                    },
                    fontFamily: {
                        'display-lg': ['Inter'],
                        'label-caps': ['Inter'],
                        'headline-md-mobile': ['Inter'],
                        'body-lg': ['Inter'],
                        'headline-md': ['Inter'],
                        'headline-sm': ['Inter'],
                        'body-md': ['Inter'],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .folder-tab-strip {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-top: 1px solid #e6e8ea;
            border-bottom: 1px solid #c4c6cf;
            background: #eef3f8;
            padding: 14px 24px 0;
        }
        .folder-tab {
            display: inline-flex;
            align-items: center;
            min-height: 46px;
            border: 1px solid #c4c6cf;
            border-bottom: 0;
            border-radius: 12px 12px 0 0;
            background: #d5e3ff;
            color: #244166;
            padding: 12px 24px;
            box-shadow: inset 0 3px 0 #82cfff;
        }
        .folder-tab-active {
            background: #ffffff;
            color: #022448;
            box-shadow: inset 0 4px 0 #00aeef, 0 -2px 10px rgba(15, 23, 42, 0.08);
            transform: translateY(1px);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-body-md text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'teachers', 'sidebarClass' => 'hidden lg:flex'])

    <main class="relative flex h-screen flex-grow flex-col overflow-y-auto">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-md border border-white/20 bg-white/20 text-lg font-bold shadow-sm">V</div>
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold">Welcome back, Van</h1>
                    <p class="text-sm opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
        </header>

        <div class="mx-auto flex w-full max-w-[1400px] flex-col space-y-8 p-8">
            <x-back-button :href="route('teachers.index')" label="Back to Teachers" />

            <section class="overflow-hidden rounded-xl border border-surface-container-high bg-surface-container-lowest shadow-sm">
                <div class="flex flex-col items-start gap-8 p-card-padding md:flex-row">
                    <div class="flex flex-shrink-0 flex-col items-center gap-4">
                        <div class="flex h-40 w-40 items-center justify-center overflow-hidden rounded-xl border-4 border-surface bg-primary text-4xl font-bold text-white shadow-md">
                            {{ collect(explode(' ', $teacher['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="mb-2 inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-[12px] font-bold tracking-wider text-success">
                                <span class="mr-2 h-2 w-2 rounded-full bg-success"></span>
                                ACTIVE TEACHER
                            </span>
                            <span class="font-label-caps text-[10px] text-on-surface-variant">TEACHER ID: {{ $teacher['id'] }}</span>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <div class="mb-6 flex items-start justify-between">
                            <div>
                                <h2 class="mb-1 text-3xl text-primary">{{ $teacher['name'] }}</h2>
                                <p class="font-body-lg text-on-surface-variant">{{ $teacher['headline'] }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-on-primary transition-opacity hover:opacity-90">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    Edit Profile
                                </button>
                                <button class="rounded-lg border border-outline-variant px-3 py-2 text-on-surface transition-colors hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-3 lg:grid-cols-4">
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">DATE OF BIRTH</p>
                                <p class="font-semibold">{{ $teacher['date_of_birth'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">MOBILE NUMBER</p>
                                <p class="font-semibold text-secondary">{{ $teacher['mobile'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">EMERGENCY CONTACT</p>
                                <p class="font-semibold">{{ $teacher['emergency_contact'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">HOURLY RATE</p>
                                <p class="font-semibold">{{ $teacher['hourly_rate'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">SUPERVISOR</p>
                                <p class="flex items-center gap-1 font-semibold">
                                    <span class="material-symbols-outlined text-sm text-active-accent">verified_user</span>
                                    {{ $teacher['supervisor'] }}
                                </p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">HIRE DATE</p>
                                <p class="font-semibold">{{ $teacher['hire_date'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">RESIGNATION DATE</p>
                                <p class="font-semibold text-on-surface-variant">{{ $teacher['resignation_date'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">EMPLOYMENT STATUS</p>
                                <p class="font-semibold">{{ $teacher['employment_full'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[11px] text-on-surface-variant">ASSIGNED COUNTRY</p>
                                <p class="font-semibold">{{ $teacher['country'] }}</p>
                            </div>
                            <div class="lg:col-span-2">
                                <p class="mb-1 text-[11px] text-on-surface-variant">EMAIL ADDRESS</p>
                                <p class="font-semibold text-secondary">{{ $teacher['email'] }}</p>
                            </div>
                            <div class="lg:col-span-2">
                                <p class="mb-1 text-[11px] text-on-surface-variant">TEACHING SPECIALIZATIONS</p>
                                <div class="mt-1 flex flex-wrap gap-2">
                                    @foreach ($teacher['specializations'] as $specialization)
                                        <span class="rounded bg-primary-container/20 px-2 py-0.5 text-[11px] font-bold text-primary-container">{{ $specialization }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="folder-tab-strip">
                    <a href="{{ route('teachers.show', ['teacher' => $teacher['id'], 'tab' => 'teaching']) }}" class="folder-tab {{ $activeTab === 'teaching' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-wider transition-all">
                        Teaching History
                    </a>
                    <a href="{{ route('teachers.show', ['teacher' => $teacher['id'], 'tab' => 'payroll']) }}" class="folder-tab {{ $activeTab === 'payroll' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-wider transition-all">
                        Payroll
                    </a>
                    <button class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">
                        Schedule
                    </button>
                    <button class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">
                        Notices & Feedback
                    </button>
                    <button class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">
                        Documents
                    </button>
                </div>
            </section>

            <section class="rounded-xl border border-surface-container-high bg-surface-container-lowest shadow-sm">
                @if ($activeTab === 'payroll')
                    <div class="grid grid-cols-1 items-end gap-5 border-b border-surface-container-high p-6 md:grid-cols-2 lg:grid-cols-12">
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher Search</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-2 text-lg text-outline">search</span>
                                <input type="text" class="w-full rounded border border-outline-variant bg-white py-2 pl-10 pr-3 text-sm focus:border-primary focus:ring-primary" value="{{ $teacher['name'] }}">
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Payroll Period</label>
                            <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                                <option>1st - 15th</option>
                                <option>16th - End</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Start Date</label>
                            <input type="date" class="w-full rounded border border-outline-variant bg-white p-2 text-sm focus:border-primary focus:ring-primary" value="2024-05-01">
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">End Date</label>
                            <input type="date" class="w-full rounded border border-outline-variant bg-white p-2 text-sm focus:border-primary focus:ring-primary" value="2024-05-15">
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</label>
                            <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>Pending</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Payment Status</label>
                            <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                                <option>All Payments</option>
                                <option>Paid</option>
                                <option>Unpaid</option>
                            </select>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 pt-2 lg:col-span-12">
                            <button class="flex h-10 items-center gap-2 rounded bg-primary px-6 text-sm font-bold text-white shadow-sm transition-all hover:bg-primary/90 active:scale-95">
                                Apply Filters
                            </button>
                            <button class="h-10 rounded border border-outline-variant px-6 text-sm font-bold text-on-surface-variant transition-all hover:bg-surface active:scale-95">
                                Reset
                            </button>
                            <div class="mx-2 h-8 w-px bg-surface-container-high"></div>
                            <button class="flex h-10 items-center gap-2 rounded border border-success/30 px-4 text-sm font-bold text-success transition-all hover:bg-success/5">
                                <span class="material-symbols-outlined text-lg">file_download</span>
                                Excel
                            </button>
                            <button class="flex h-10 items-center gap-2 rounded border border-error/30 px-4 text-sm font-bold text-error transition-all hover:bg-error/5">
                                <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                                PDF
                            </button>
                            <button class="flex h-10 items-center gap-2 rounded border border-outline-variant px-4 text-sm font-bold text-on-surface-variant transition-all hover:bg-surface">
                                <span class="material-symbols-outlined text-lg">print</span>
                                Print
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-b border-surface-container-high px-6 py-5">
                        <h3 class="text-lg font-bold text-primary">Payroll History: {{ $teacher['name'] }}</h3>
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Showing:</span>
                            <select class="rounded border border-outline-variant bg-white px-2 py-1 text-[11px] font-bold text-primary focus:border-primary focus:ring-primary">
                                <option>10 Entries</option>
                                <option>25 Entries</option>
                                <option>50 Entries</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[1200px] w-full border-collapse text-left">
                            <thead class="bg-surface-container-low">
                                <tr>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Payroll ID</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Period / Cutoff</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Hourly Rate</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Lessons</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Gross Salary</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Bonus / Ded.</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Net Salary</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Status</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-center text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Itemized Lesson Statement</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Receipt</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-center text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high">
                                @foreach ($payrollHistory as $record)
                                    <tr class="transition-colors hover:bg-surface-container-low/50">
                                        <td class="px-6 py-5 text-sm font-bold text-primary">
                                            <a href="{{ route('teachers.payroll.show', ['teacher' => $teacher['id'], 'payroll' => $record['slug']]) }}" class="hover:underline">{{ $record['id'] }}</a>
                                        </td>
                                        <td class="px-6 py-5 text-sm">
                                            <span class="block font-bold text-primary">{{ $record['period'] }}</span>
                                            <span class="text-[10px] font-bold uppercase text-on-surface-variant">{{ $record['cutoff'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['hourly_rate'] }}</td>
                                        <td class="px-6 py-5 text-sm">
                                            <span class="block font-bold text-primary">{{ $record['lessons'] }}</span>
                                            <span class="text-[10px] font-bold uppercase text-on-surface-variant">{{ $record['hours'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['gross_salary'] }}</td>
                                        <td class="px-6 py-5 text-sm font-bold {{ $record['bonus_class'] }}">{{ $record['bonus_deduction'] }}</td>
                                        <td class="px-6 py-5 text-lg font-bold text-secondary">{{ $record['net_salary'] }}</td>
                                        <td class="px-6 py-5">
                                            <span class="{{ $record['status_class'] }} rounded border px-3 py-1 text-[10px] font-bold uppercase tracking-wider">{{ $record['status'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <a href="{{ route('teachers.payroll.show', ['teacher' => $teacher['id'], 'payroll' => $record['slug']]) }}" class="text-sm font-bold text-primary transition-all hover:underline">View</a>
                                        </td>
                                        <td class="px-6 py-5 text-sm"><a href="#" class="font-bold text-primary transition-all hover:underline">View</a></td>
                                        <td class="px-6 py-5"><div class="flex justify-center"><a href="#" class="text-sm font-bold text-primary transition-all hover:underline">View</a></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-surface-container-high bg-surface-container-low px-6 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Showing 1 to 3 of 24 records</p>
                        <div class="flex gap-1.5">
                            <button class="flex h-9 w-9 items-center justify-center rounded border border-outline-variant transition-all hover:bg-white disabled:opacity-30" disabled>
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-between border-b border-surface-container-high p-6">
                        <div class="flex items-center gap-4">
                            <h3 class="font-headline-sm text-primary">Lesson Records</h3>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex items-center gap-2 rounded-lg border border-outline-variant bg-surface px-4 py-2 transition-colors hover:bg-surface-container-low">
                                <span class="material-symbols-outlined text-sm">filter_list</span>
                                Filter
                            </button>
                            <button class="flex items-center gap-2 rounded-lg border border-outline-variant bg-surface px-4 py-2 transition-colors hover:bg-surface-container-low">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Export CSV
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead class="bg-surface-container-low">
                                <tr>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">DATE</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">STUDENT NAME</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">STUDENT ID</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">CATEGORY</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">LESSON TYPE</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">DURATION</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">STATUS</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-on-surface-variant">EARNINGS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high">
                                @foreach ($teachingHistory as $lesson)
                                    <tr class="group transition-colors hover:bg-surface-container-low">
                                        <td class="px-6 py-5 font-semibold">{{ $lesson['date'] }}</td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-full {{ $lesson['initials_class'] }} text-[10px] font-bold">{{ $lesson['initials'] }}</div>
                                                <span class="font-semibold">{{ $lesson['student_name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 font-mono text-[13px] text-on-surface-variant">{{ $lesson['student_id'] }}</td>
                                        <td class="px-6 py-5">
                                            <span class="rounded-full border px-2.5 py-1 text-[11px] font-bold {{ $lesson['category_class'] }}">{{ $lesson['category'] }}</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="rounded-lg border border-outline-variant/30 bg-surface-container-high px-2.5 py-1 text-[12px] font-medium text-primary">{{ $lesson['lesson_type'] }}</span>
                                        </td>
                                        <td class="px-6 py-5">{{ $lesson['duration'] }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center rounded px-2 py-0.5 text-[12px] font-bold {{ $lesson['status_class'] }}">{{ $lesson['status'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 font-bold text-primary">{{ $lesson['earnings'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-surface-container-high p-4">
                        <p class="text-[13px] text-on-surface-variant">Showing 1 to 6 of 128 entries</p>
                        <div class="flex gap-2">
                            <button class="rounded border border-outline-variant px-3 py-1.5 transition-colors hover:bg-surface disabled:opacity-50" disabled>
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </button>
                            <button class="rounded bg-primary px-3 py-1.5 text-sm font-bold text-on-primary">1</button>
                            <button class="rounded border border-outline-variant px-3 py-1.5 text-sm transition-colors hover:bg-surface">2</button>
                            <button class="rounded border border-outline-variant px-3 py-1.5 text-sm transition-colors hover:bg-surface">3</button>
                            <button class="rounded border border-outline-variant px-3 py-1.5 transition-colors hover:bg-surface">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        </div>
                    </div>
                @endif
            </section>
        </div>

        <footer class="mt-auto flex justify-between border-t border-surface-container-high bg-surface px-gutter py-6 text-[12px] text-on-surface-variant">
            <p>&copy; 2024 SpeakRyt ESL Management. All rights reserved.</p>
            <div class="flex gap-6">
                <a class="transition-colors hover:text-primary" href="#">Privacy Policy</a>
                <a class="transition-colors hover:text-primary" href="#">Help Center</a>
                <a class="transition-colors hover:text-primary" href="#">Support</a>
            </div>
        </footer>
    </main>
</body>
</html>
