<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Profile | {{ $staff['name'] }} - SpeakRyt</title>
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
                        tertiary: '#002738',
                        success: '#27ae60',
                        warning: '#f1c40f',
                        error: '#e74c3c',
                        outline: '#74777f',
                        'outline-variant': '#c4c6cf',
                        'surface-container': '#eceef0',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-high': '#e6e8ea',
                        'surface-container-highest': '#e0e3e5',
                        'surface-container-lowest': '#ffffff',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#43474e',
                        'text-primary': '#333333',
                        'text-secondary': '#666666',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '0.75rem',
                    },
                    spacing: {
                        gutter: '24px',
                        'card-padding': '20px',
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
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'staff', 'sidebarClass' => 'hidden lg:flex'])

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

        <div class="mx-auto w-full max-w-[1600px] space-y-6 p-8">
            <x-back-button :href="route('staff.index')" label="Back to Staff" />

            <section class="overflow-hidden rounded-lg border border-surface-container-high bg-surface-container-lowest shadow-sm">
                <div class="flex flex-col items-start gap-8 p-card-padding md:flex-row">
                    <div class="flex flex-shrink-0 flex-col items-center gap-4">
                        <div class="flex h-36 w-36 items-center justify-center overflow-hidden rounded-lg border-2 border-surface bg-primary text-4xl font-bold text-white shadow">
                            {{ collect(explode(' ', $staff['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="mb-1 inline-flex items-center rounded-full px-3 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $staff['status_badge_class'] }}">
                                <span class="mr-2 h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $staff['status_label'] }}
                            </span>
                            <span class="text-[10px] font-bold text-on-surface-variant">STAFF ID: {{ $staff['id'] }}</span>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div>
                                <h2 class="mb-1 text-2xl font-bold text-primary">{{ $staff['name'] }}</h2>
                                <p class="font-medium text-on-surface-variant">{{ $staff['role'] }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex items-center gap-2 rounded bg-primary px-4 py-2 text-sm font-bold text-white transition-colors hover:bg-primary/90">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                    Edit Profile
                                </button>
                                <button class="rounded border border-outline-variant px-2.5 py-2 text-on-surface transition-colors hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-6 lg:grid-cols-4">
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Date of Birth</p>
                                <p class="text-sm font-bold text-primary">{{ $staff['date_of_birth'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Mobile Number</p>
                                <p class="text-sm font-bold text-secondary">{{ $staff['mobile'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Emergency Contact</p>
                                <p class="text-sm font-bold text-primary">{{ $staff['emergency_contact'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Hourly Rate</p>
                                <p class="text-sm font-bold text-primary">{{ $staff['hourly_rate'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Assigned Country</p>
                                <p class="flex items-center gap-1 text-sm font-bold text-primary"><span class="material-symbols-outlined text-base text-[#00bfff]">public</span>{{ $staff['country'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Hire Date</p>
                                <p class="text-sm font-bold text-primary">{{ $staff['hire_date'] }}</p>
                            </div>
                            <div>
                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Employment Status</p>
                                <p class="text-sm font-bold text-primary">{{ $staff['employment_full'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="folder-tab-strip">
                    <a href="{{ route('staff.show', ['staff' => $staff['id'], 'tab' => 'overview']) }}" class="folder-tab {{ $activeTab === 'overview' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-wider transition-all">Profile Overview</a>
                    <a href="{{ route('staff.show', ['staff' => $staff['id'], 'tab' => 'payroll']) }}" class="folder-tab {{ $activeTab === 'payroll' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-wider transition-all">Payroll</a>
                    <a href="{{ route('schedule.index') }}" class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">Schedule</a>
                    <button class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">Notices &amp; Feedback</button>
                    <button class="folder-tab text-sm font-bold uppercase tracking-wider transition-all hover:bg-white">Documents</button>
                </div>
            </section>

            @if ($activeTab === 'payroll')
                <section class="rounded-lg border border-surface-container-high bg-surface-container-lowest p-6 shadow-sm">
                    <div class="grid grid-cols-1 items-end gap-5 md:grid-cols-2 lg:grid-cols-12">
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Staff Search</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-2 text-lg text-outline">search</span>
                                <input type="text" class="w-full rounded border border-outline-variant bg-white py-2 pl-10 pr-3 text-sm focus:border-primary focus:ring-primary" value="{{ $staff['name'] }}">
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Payroll Period</label>
                            <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                                <option>Monthly</option>
                                <option>Bi-weekly</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Start Date</label>
                            <input type="date" class="w-full rounded border border-outline-variant bg-white p-2 text-sm focus:border-primary focus:ring-primary" value="2024-01-01">
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">End Date</label>
                            <input type="date" class="w-full rounded border border-outline-variant bg-white p-2 text-sm focus:border-primary focus:ring-primary" value="2024-01-31">
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</label>
                            <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                                <option>All Status</option>
                                <option>Approved</option>
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
                            <button class="flex h-10 items-center gap-2 rounded bg-primary px-6 text-sm font-bold text-white shadow-sm transition-all active:scale-95 hover:bg-primary/90">Apply Filters</button>
                            <button class="h-10 rounded border border-outline-variant px-6 text-sm font-bold text-on-surface-variant transition-all active:scale-95 hover:bg-surface">Reset</button>
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
                </section>

                <section class="overflow-hidden rounded-lg border border-surface-container-high bg-surface-container-lowest shadow-sm">
                    <div class="flex items-center justify-between border-b border-surface-container-high px-6 py-5">
                        <h3 class="text-lg font-bold text-primary">Payroll History: {{ $staff['name'] }}</h3>
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Currency: PHP (P)</span>
                            <div class="h-4 w-px bg-surface-container-high"></div>
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
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Payroll Period</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Hourly Rate</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Monthly Fixed</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Gross Salary</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Bonus / Ded.</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Net Salary</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Status</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-center text-[10px] font-bold uppercase tracking-[0.1em] text-on-surface-variant">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high">
                                @foreach ($staffPayrollHistory as $record)
                                    <tr class="transition-colors hover:bg-surface-container-low/50">
                                        <td class="px-6 py-5 text-sm font-bold text-primary">
                                            <a href="{{ route('staff.payroll.show', ['staff' => $staff['id'], 'payroll' => $record['slug']]) }}" class="hover:underline">{{ $record['id'] }}</a>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['period'] }}</td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['hourly_rate'] }}</td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['monthly_fixed'] }}</td>
                                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $record['gross_salary'] }}</td>
                                        <td class="px-6 py-5 text-sm font-bold {{ $record['bonus_class'] }}">{{ $record['bonus_deduction'] }}</td>
                                        <td class="px-6 py-5 text-lg font-bold text-secondary">{{ $record['net_salary'] }}</td>
                                        <td class="px-6 py-5">
                                            <span class="rounded border px-3 py-1 text-[10px] font-bold uppercase tracking-wider {{ $record['status_class'] }}">{{ $record['status'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center"><a href="#" class="text-sm font-bold text-primary transition-all hover:underline">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-surface-container-low/30">
                                <tr class="border-t-2 border-surface-container-high font-bold">
                                    <td class="px-6 py-5 text-primary">YTD Totals</td>
                                    <td class="px-6 py-5">--</td>
                                    <td class="px-6 py-5 text-primary">P160,000.00</td>
                                    <td class="px-6 py-5 text-primary">P160,000.00</td>
                                    <td class="px-6 py-5 text-success">P7,000.00</td>
                                    <td class="px-6 py-5 text-lg text-secondary">P167,000.00</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="flex items-center justify-between border-t border-surface-container-high bg-surface-container-low px-6 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Showing 1 to {{ count($staffPayrollHistory) }} of 12 records</p>
                        <div class="flex gap-1.5">
                            <button class="flex h-9 w-9 items-center justify-center rounded border border-outline-variant transition-all hover:bg-white disabled:opacity-30" disabled>
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </button>
                            <button class="flex h-9 w-9 items-center justify-center rounded bg-primary text-sm font-bold text-white">1</button>
                            <button class="flex h-9 w-9 items-center justify-center rounded border border-outline-variant text-sm font-bold text-on-surface-variant transition-all hover:bg-white">2</button>
                            <button class="flex h-9 w-9 items-center justify-center rounded border border-outline-variant text-sm font-bold text-on-surface-variant transition-all hover:bg-white">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </section>
            @else
                <section class="overflow-hidden rounded-xl border border-surface-container-high bg-surface-container-lowest shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-surface-container-high p-6 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                            <h3 class="text-xl font-semibold text-primary">Team Management</h3>
                            <div class="rounded-full bg-surface-container-low px-3 py-1 text-[12px] font-semibold text-on-surface-variant">{{ count($managedTeachers) }} Teachers Managed</div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90">
                                <span class="material-symbols-outlined text-sm">add</span>
                                Assign Teacher
                            </button>
                            <button class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-on-surface transition-colors hover:bg-surface-container-low">
                                <span class="material-symbols-outlined text-sm">filter_list</span>
                                Filter
                            </button>
                            <button class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-on-surface transition-colors hover:bg-surface-container-low">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Export CSV
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead class="bg-surface-container-low">
                                <tr>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher ID</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher Name</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Employment Status</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Hourly Rate</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Assigned Country</th>
                                    <th class="border-b border-surface-container-high px-6 py-4 text-right text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high">
                                @foreach ($managedTeachers as $teacher)
                                    <tr class="transition-colors hover:bg-surface-container-low">
                                        <td class="px-6 py-5 font-mono text-[13px]">{{ $teacher['id'] }}</td>
                                        <td class="px-6 py-5 font-semibold">{{ $teacher['name'] }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center rounded px-2 py-0.5 text-[12px] font-bold {{ $teacher['status_class'] }}">{{ $teacher['employment_status'] }}</span>
                                        </td>
                                        <td class="px-6 py-5 font-bold text-primary">{{ $teacher['hourly_rate'] }}</td>
                                        <td class="px-6 py-5">{{ $teacher['country'] }}</td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-3">
                                                <button class="text-on-surface-variant transition-colors hover:text-primary" title="Reassign">
                                                    <span class="material-symbols-outlined text-[20px]">swap_horiz</span>
                                                </button>
                                                <button class="text-on-surface-variant transition-colors hover:text-error" title="Delete">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-surface-container-high p-4">
                        <p class="text-[13px] text-on-surface-variant">Showing 1 to {{ count($managedTeachers) }} of 128 entries</p>
                        <div class="flex gap-2">
                            <button class="rounded border border-gray-300 px-3 py-1.5 transition-colors hover:bg-surface disabled:opacity-50" disabled>
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </button>
                            <button class="rounded bg-primary px-3 py-1.5 text-sm font-bold text-white">1</button>
                            <button class="rounded border border-gray-300 px-3 py-1.5 text-sm transition-colors hover:bg-surface">2</button>
                            <button class="rounded border border-gray-300 px-3 py-1.5 text-sm transition-colors hover:bg-surface">3</button>
                            <button class="rounded border border-gray-300 px-3 py-1.5 transition-colors hover:bg-surface">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </main>
</body>
</html>
