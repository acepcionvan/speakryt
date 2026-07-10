<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Directory | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        try {
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            surface: '#f7f9fb',
                            'surface-dim': '#d8dadc',
                            'surface-bright': '#f7f9fb',
                            'surface-container-lowest': '#ffffff',
                            'surface-container-low': '#f2f4f6',
                            'surface-container': '#eceef0',
                            'surface-container-high': '#e6e8ea',
                            'surface-container-highest': '#e0e3e5',
                            'on-surface': '#191c1e',
                            'on-surface-variant': '#43474e',
                            outline: '#74777f',
                            'outline-variant': '#c4c6cf',
                            primary: '#022448',
                            'on-primary': '#ffffff',
                            'primary-container': '#1e3a5f',
                            'on-primary-container': '#8aa4cf',
                            secondary: '#006397',
                            'on-secondary': '#ffffff',
                            'secondary-container': '#5cb8fd',
                            'on-secondary-container': '#00476e',
                            tertiary: '#002738',
                            'on-tertiary': '#ffffff',
                            'tertiary-container': '#003e56',
                            'on-tertiary-container': '#00afea',
                            error: '#e74c3c',
                            'on-error': '#ffffff',
                            'error-container': '#ffdad6',
                            'on-error-container': '#93000a',
                            background: '#f7f9fb',
                            'on-background': '#191c1e',
                            'sidebar-bg': '#244166',
                            'header-blue': '#3498db',
                            'active-accent': '#00aeef',
                            success: '#27ae60',
                            warning: '#f1c40f',
                            'text-primary': '#333333',
                            'text-secondary': '#666666',
                        },
                        spacing: {
                            gutter: '24px',
                        },
                    },
                },
            };
        } catch (_e) {}
    </script>
    <style>
        body { font-family: Roboto, sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(116, 119, 127, 0.35); border-radius: 999px; }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-gray-50 text-on-surface">
    @include('partials.sidebar', ['activeSection' => 'staff', 'sidebarClass' => 'hidden lg:flex'])

    <div class="flex flex-1 flex-col overflow-hidden">
        <header class="flex h-24 flex-shrink-0 items-center justify-between bg-header-blue px-8 text-white">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md border border-white/20 bg-white/20"></div>
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold">Welcome back, Van</h1>
                    <p class="text-sm opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/70">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input id="staff-header-search" type="text" class="block w-full rounded-lg border-none bg-white/20 py-2 pl-10 pr-3 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 sm:text-sm" placeholder="Search staff, ID or region...">
            </div>
        </header>

        <main class="custom-scrollbar flex-1 overflow-y-auto p-8">
            <div class="flex flex-col space-y-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Staff Directory</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage organizational staff, assigned territories, and employment status.</p>
                    </div>
                    <button class="flex items-center gap-2 rounded bg-primary px-6 py-2.5 font-bold text-white shadow-md transition-all hover:bg-primary-container active:scale-95">
                        <i class="fa-solid fa-user-plus"></i>
                        Add New Staff
                    </button>
                </div>

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Filters</span>
                        <div class="h-px flex-1 bg-gray-200"></div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="relative w-full md:w-96">
                            <input id="staff-search-filter" type="text" placeholder="Quick search..." class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm shadow-sm focus:border-transparent focus:ring-2 focus:ring-active-accent">
                            <div class="absolute left-3 top-3 text-gray-400">
                                <i class="fa-solid fa-filter"></i>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="relative">
                                <select id="staff-country-filter" class="block appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-4 pr-10 text-sm text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:border-active-accent focus:ring-2 focus:ring-active-accent">
                                    <option value="">All Countries</option>
                                    @foreach ($countryOptions as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select id="staff-position-filter" class="block appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-4 pr-10 text-sm text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:border-active-accent focus:ring-2 focus:ring-active-accent">
                                    <option value="">All Positions</option>
                                    @foreach (collect($staffMembers)->pluck('role')->unique()->sort()->values() as $position)
                                        <option value="{{ $position }}">{{ $position }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select id="staff-manager-filter" class="block appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-4 pr-10 text-sm text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:border-active-accent focus:ring-2 focus:ring-active-accent">
                                    <option value="">All Reporting Lines</option>
                                    @foreach (collect($staffMembers)->pluck('direct_manager')->unique()->sort()->values() as $manager)
                                        <option value="{{ $manager }}">{{ $manager }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select id="staff-status-filter" class="block appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-4 pr-10 text-sm text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:border-active-accent focus:ring-2 focus:ring-active-accent">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Suspended">Suspended</option>
                                    <option value="Terminated">Terminated</option>
                                    <option value="Resigned">Resigned</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <button id="staff-reset-filters" class="rounded-lg border border-gray-300 bg-white p-2.5 text-primary shadow-sm transition-colors hover:bg-surface-container" type="button" aria-label="Reset staff filters">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-1 flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="custom-scrollbar overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Staff ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Staff Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Country Assigned</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Direct Manager / Position</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Hire Date</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Assigned Teachers</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status of Employment</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($staffMembers as $member)
                                    <tr class="staff-row transition-colors hover:bg-gray-50"
                                        data-search="{{ Str::lower($member['id'].' '.$member['name'].' '.$member['role'].' '.$member['country'].' '.$member['direct_manager'].' '.$member['manager_position'].' '.$member['status']) }}"
                                        data-country="{{ $member['country'] }}"
                                        data-position="{{ $member['role'] }}"
                                        data-manager="{{ $member['direct_manager'] }}"
                                        data-status="{{ $member['status'] }}">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-primary">
                                            <a href="{{ route('staff.show', ['staff' => $member['id']]) }}" class="hover:underline">{{ $member['id'] }}</a>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 items-center justify-center rounded-full {{ $member['avatar_class'] }} text-xs font-bold">{{ $member['initials'] }}</div>
                                                <div>
                                                    <a href="{{ route('staff.show', ['staff' => $member['id']]) }}" class="text-sm font-bold text-gray-800 hover:text-active-accent">{{ $member['name'] }}</a>
                                                    <p class="text-[11px] text-gray-500">{{ $member['role'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-[11px] font-bold text-gray-600">{{ $member['country'] }}</span>
                                        </td>
                                        <td class="min-w-56 px-6 py-4">
                                            <p class="text-sm font-bold text-gray-800">{{ $member['direct_manager'] }}</p>
                                            <p class="mt-0.5 text-[11px] font-medium text-gray-500">{{ $member['manager_position'] }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex rounded-md bg-surface-container px-2.5 py-1 text-xs font-bold text-gray-700">{{ $member['hire_date'] }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-center">
                                            <span class="text-sm font-bold text-secondary">{{ $member['assigned_teachers'] }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold {{ $member['status_class'] }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $member['dot_class'] }}"></span>
                                                {{ $member['status'] }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <button class="text-gray-400 transition-colors hover:text-active-accent">
                                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="staff-empty-state" class="hidden">
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <p class="text-sm font-bold text-gray-700">No staff members match these filters.</p>
                                        <p class="mt-1 text-xs text-gray-500">Try another country, position, reporting line, or status.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-auto flex items-center justify-between border-t border-gray-200 bg-white px-6 py-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Showing <span class="font-bold text-gray-700">1</span> to <span id="staff-visible-count" class="font-bold text-gray-700">{{ count($staffMembers) }}</span> of <span class="font-bold text-gray-700">{{ count($staffMembers) }}</span> staff members</p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-3 py-2 text-xs font-bold text-gray-500 transition-colors hover:bg-gray-50">
                                    <i class="fa-solid fa-chevron-left mr-1"></i> Previous
                                </a>
                                <a href="#" aria-current="page" class="relative z-10 inline-flex items-center border border-primary bg-primary px-4 py-2 text-sm font-bold text-white">1</a>
                                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-50">2</a>
                                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-50">3</a>
                                <a href="#" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-3 py-2 text-xs font-bold text-gray-500 transition-colors hover:bg-gray-50">
                                    Next <i class="fa-solid fa-chevron-right ml-1"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        const staffHeaderSearch = document.querySelector('#staff-header-search');
        const staffSearchFilter = document.querySelector('#staff-search-filter');
        const staffCountryFilter = document.querySelector('#staff-country-filter');
        const staffPositionFilter = document.querySelector('#staff-position-filter');
        const staffManagerFilter = document.querySelector('#staff-manager-filter');
        const staffStatusFilter = document.querySelector('#staff-status-filter');
        const staffResetFilters = document.querySelector('#staff-reset-filters');
        const staffRows = Array.from(document.querySelectorAll('.staff-row'));
        const staffEmptyState = document.querySelector('#staff-empty-state');
        const staffVisibleCount = document.querySelector('#staff-visible-count');

        function applyStaffFilters(sourceInput = null) {
            if (sourceInput === staffHeaderSearch && staffSearchFilter) {
                staffSearchFilter.value = staffHeaderSearch.value;
            }

            if (sourceInput === staffSearchFilter && staffHeaderSearch) {
                staffHeaderSearch.value = staffSearchFilter.value;
            }

            const search = (staffSearchFilter?.value || staffHeaderSearch?.value || '').trim().toLowerCase();
            const country = staffCountryFilter?.value || '';
            const position = staffPositionFilter?.value || '';
            const manager = staffManagerFilter?.value || '';
            const status = staffStatusFilter?.value || '';
            let visibleRows = 0;

            staffRows.forEach((row) => {
                const matchesSearch = !search || row.dataset.search.includes(search);
                const matchesCountry = !country || row.dataset.country === country;
                const matchesPosition = !position || row.dataset.position === position;
                const matchesManager = !manager || row.dataset.manager === manager;
                const matchesStatus = !status || row.dataset.status === status;
                const isVisible = matchesSearch && matchesCountry && matchesPosition && matchesManager && matchesStatus;

                row.classList.toggle('hidden', !isVisible);
                if (isVisible) {
                    visibleRows += 1;
                }
            });

            staffEmptyState?.classList.toggle('hidden', visibleRows > 0);
            if (staffVisibleCount) {
                staffVisibleCount.textContent = visibleRows;
            }
        }

        [staffHeaderSearch, staffSearchFilter].forEach((input) => {
            input?.addEventListener('input', () => applyStaffFilters(input));
        });

        [staffCountryFilter, staffPositionFilter, staffManagerFilter, staffStatusFilter].forEach((select) => {
            select?.addEventListener('change', () => applyStaffFilters());
        });

        staffResetFilters?.addEventListener('click', () => {
            [staffHeaderSearch, staffSearchFilter, staffCountryFilter, staffPositionFilter, staffManagerFilter, staffStatusFilter].forEach((field) => {
                if (field) {
                    field.value = '';
                }
            });

            applyStaffFilters();
        });
    </script>
</body>
</html>
