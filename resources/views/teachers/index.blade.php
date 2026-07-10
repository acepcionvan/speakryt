<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Directory | SpeakRyt Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        try {
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            warning: '#f1c40f',
                            'on-background': '#191c1e',
                            'surface-container-low': '#f2f4f6',
                            'on-secondary': '#ffffff',
                            'sidebar-bg': '#244166',
                            'text-primary': '#333333',
                            tertiary: '#002738',
                            'on-secondary-fixed-variant': '#004b73',
                            primary: '#022448',
                            'on-tertiary': '#ffffff',
                            outline: '#74777f',
                            error: '#e74c3c',
                            background: '#f7f9fb',
                            'surface-dim': '#d8dadc',
                            'on-error': '#ffffff',
                            'tertiary-container': '#003e56',
                            'surface-container-high': '#e6e8ea',
                            'outline-variant': '#c4c6cf',
                            'primary-fixed': '#d5e3ff',
                            'on-tertiary-container': '#00afea',
                            success: '#27ae60',
                            'surface-variant': '#e0e3e5',
                            surface: '#f7f9fb',
                            'active-accent': '#00aeef',
                            'surface-tint': '#455f87',
                            'tertiary-fixed': '#c3e8ff',
                            'surface-bright': '#f7f9fb',
                            'secondary-fixed-dim': '#92ccff',
                            'on-tertiary-fixed-variant': '#004c69',
                            'primary-fixed-dim': '#adc8f5',
                            'on-surface-variant': '#43474e',
                            'error-container': '#ffdad6',
                            'on-primary-fixed-variant': '#2d486d',
                            'inverse-on-surface': '#eff1f3',
                            'inverse-primary': '#adc8f5',
                            'secondary-fixed': '#cce5ff',
                            'on-secondary-container': '#00476e',
                            'on-primary-fixed': '#001c3b',
                            'text-secondary': '#666666',
                            'on-primary-container': '#8aa4cf',
                            'on-tertiary-fixed': '#001e2c',
                            'surface-container-highest': '#e0e3e5',
                            'surface-container-lowest': '#ffffff',
                            'on-secondary-fixed': '#001d31',
                            'inverse-surface': '#2d3133',
                            secondary: '#006397',
                            'tertiary-fixed-dim': '#7ad0ff',
                            'on-error-container': '#93000a',
                            'on-surface': '#191c1e',
                            'on-primary': '#ffffff',
                            'primary-container': '#1e3a5f',
                            'surface-container': '#eceef0',
                            'secondary-container': '#5cb8fd',
                            'header-blue': '#3498db',
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                    },
                },
            }
        } catch (_e) {}
    </script>
    <style>
        body { font-family: Inter, sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(36, 65, 102, 0.2); border-radius: 10px; }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex min-h-screen overflow-hidden bg-gray-50 text-on-surface">
    @include('partials.sidebar', ['activeSection' => 'teachers', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-header-blue px-5 text-white sm:px-8">
            <div class="flex min-w-0 items-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full transition-colors hover:bg-white/10 lg:hidden">
                    <span class="material-symbols-outlined text-white">arrow_back</span>
                </a>
                <div class="hidden h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-md border border-white/20 bg-white/20 text-lg font-bold shadow-sm sm:flex">V</div>
                <div class="min-w-0">
                    <h1 class="truncate text-xl font-bold sm:text-2xl">Welcome back, Van</h1>
                    <p class="text-sm opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
        </header>

        <div class="custom-scrollbar flex-1 overflow-y-auto p-4">
            <div class="mx-auto max-w-[1400px]">
                <div class="mb-4 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h2 class="mb-1 text-2xl font-semibold text-gray-800">Teacher Directory</h2>
                        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <span>Dashboard</span>
                            <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                            <span class="text-header-blue">Teachers</span>
                        </nav>
                    </div>
                    <button class="flex items-center gap-2 rounded bg-[#022448] px-6 py-2.5 font-medium text-on-primary shadow-md transition-colors hover:bg-sidebar-bg">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        Add New Teacher
                    </button>
                </div>

                <div class="mb-8">
                    <div class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                        <span>Filters</span>
                        <div class="ml-2 flex-1 border-t border-gray-200"></div>
                    </div>
                    <div class="flex flex-col gap-4 md:flex-row">
                        <div class="relative flex-1">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">search</span>
                            <input type="text" placeholder="Search teachers..." class="w-full rounded border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-sm shadow-sm outline-none transition-all focus:border-header-blue focus:ring-2 focus:ring-header-blue/20">
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <div class="relative">
                                <select class="min-w-[160px] cursor-pointer appearance-none rounded border border-gray-200 bg-white px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 shadow-sm outline-none focus:border-header-blue focus:ring-2 focus:ring-header-blue/20">
                                    <option>All Countries</option>
                                    @foreach ($countryOptions as $country)
                                        <option>{{ $country }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">expand_more</span>
                            </div>
                            <div class="relative">
                                <select class="min-w-[160px] cursor-pointer appearance-none rounded border border-gray-200 bg-white px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 shadow-sm outline-none focus:border-header-blue focus:ring-2 focus:ring-header-blue/20">
                                    <option>All Supervisors</option>
                                    <option>Michael Chen</option>
                                    <option>Emma Wilson</option>
                                    <option>David Miller</option>
                                    <option>Sarah Jenkins</option>
                                    <option>James Lee</option>
                                    <option>Linda Thompson</option>
                                    <option>Robert Wilson</option>
                                    <option>Sophia Garcia</option>
                                    <option>Marcus Chen</option>
                                    <option>Elena Rodriguez</option>
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">expand_more</span>
                            </div>
                            <div class="relative">
                                <select class="min-w-[160px] cursor-pointer appearance-none rounded border border-gray-200 bg-white px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 shadow-sm outline-none focus:border-header-blue focus:ring-2 focus:ring-header-blue/20">
                                    <option>All Status</option>
                                    <option>Full-Time</option>
                                    <option>Part-Time</option>
                                    <option>Contract</option>
                                    <option>Suspended</option>
                                    <option>Terminated</option>
                                    <option>Resigned</option>
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="custom-scrollbar overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Teacher ID</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Teacher Name</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Specialty</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Assigned Country</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Students Assigned</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Supervisor Name</th>
                                    <th class="px-6 py-2 text-xs font-medium uppercase tracking-wider text-gray-500">Status of Employment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($teachers as $teacher)
                                    @php
                                        $initials = collect(explode(' ', $teacher['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('');
                                        $teacherUrl = route('teachers.show', ['teacher' => $teacher['id']]);
                                    @endphp
                                    <tr class="group transition-colors hover:bg-gray-50">
                                        <td class="px-6 py-2">
                                            <a class="text-sm font-bold text-header-blue hover:underline" href="{{ $teacherUrl }}">{{ $teacher['id'] }}</a>
                                        </td>
                                        <td class="px-6 py-2">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-gray-100 text-xs font-bold text-primary">{{ $initials }}</div>
                                                <a class="text-sm font-semibold text-gray-800 transition-colors hover:text-header-blue" href="{{ $teacherUrl }}">{{ $teacher['name'] }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 text-sm text-gray-600">{{ $teacher['specialty'] }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-600">{{ $teacher['country'] }}</td>
                                        <td class="px-6 py-2">
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-[12px] font-bold text-header-blue">{{ $teacher['students_assigned'] }}</span>
                                        </td>
                                        <td class="px-6 py-2"><a href="{{ route('teachers.index') }}" class="text-sm font-semibold text-header-blue hover:underline">{{ $teacher['supervisor'] }}</a></td>
                                        <td class="px-6 py-2"><span class="{{ $teacher['employment_class'] }} rounded-full px-2 py-1 text-xs font-semibold">{{ $teacher['employment_status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-6">
                        <div>
                            <p class="text-sm text-gray-700">Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">84</span> results</p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                                </a>
                                <a href="#" aria-current="page" class="relative z-10 inline-flex items-center border border-header-blue bg-blue-50 px-4 py-2 text-sm font-medium text-header-blue">1</a>
                                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50">2</a>
                                <a href="#" class="relative hidden items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 md:inline-flex">3</a>
                                <span class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">...</span>
                                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50">9</a>
                                <a href="#" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
