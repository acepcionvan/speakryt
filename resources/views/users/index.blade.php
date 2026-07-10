<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management | SpeakRyt</title>
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
                        primary: '#022448',
                        secondary: '#006397',
                        success: '#27ae60',
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
        .folder-tab-strip {
            display: flex;
            gap: 6px;
            align-items: flex-end;
            overflow-x: auto;
            border-bottom: 1px solid #c4c6cf;
            background: #eef3f8;
            padding: 14px 24px 0;
        }
        .folder-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 46px;
            border: 1px solid #c4c6cf;
            border-bottom: 0;
            border-radius: 12px 12px 0 0;
            background: #d5e3ff;
            color: #244166;
            padding: 12px 22px;
            white-space: nowrap;
            box-shadow: inset 0 3px 0 #82cfff;
        }
        .folder-tab-active {
            background: #ffffff;
            color: #022448;
            box-shadow: inset 0 4px 0 #00aeef, 0 -2px 10px rgba(15, 23, 42, 0.08);
            transform: translateY(1px);
        }
        .permission-switch:checked + span {
            background: #022448;
        }
        .permission-switch:checked + span span {
            transform: translateX(20px);
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'users', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-y-auto bg-[#f0f2f5]">
        <header class="sticky top-0 z-40 flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white shadow-md">
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

        <div class="flex flex-col gap-6 p-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-primary">User Management</h2>
                    <p class="mt-1 max-w-3xl text-sm text-text-secondary">Control role access for sidebar sections, profile tabs, payroll data, earnings, payments, and sensitive packages/pricing information.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button class="flex h-10 items-center gap-2 rounded-lg border border-secondary bg-white px-5 text-sm font-bold text-secondary transition-colors hover:bg-secondary-fixed">
                        <span class="material-symbols-outlined text-lg">history</span>
                        Audit Log
                    </button>
                    <button class="flex h-10 items-center gap-2 rounded-lg bg-primary px-5 text-sm font-bold text-white shadow-md transition-all hover:opacity-90 active:scale-95">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Save Permissions
                    </button>
                </div>
            </div>

            <section class="overflow-hidden rounded-xl border border-surface-container-high bg-white shadow-sm">
                <div class="flex flex-col justify-between gap-4 px-6 py-5 lg:flex-row lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-active-accent">Admin Only</p>
                        <h3 class="mt-1 text-xl font-bold text-primary">User Accounts</h3>
                        <p class="mt-1 text-sm text-text-secondary">Add, edit, delete, and review platform users by account type.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="inline-flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-sm transition-all hover:opacity-90 active:scale-95" type="button">
                            <span class="material-symbols-outlined text-lg">person_add</span>
                            Add User
                        </button>
                        <button class="inline-flex h-10 items-center gap-2 rounded-lg border border-secondary bg-white px-4 text-sm font-bold text-secondary transition-colors hover:bg-secondary-fixed" type="button">
                            <span class="material-symbols-outlined text-lg">edit</span>
                            Edit Selected
                        </button>
                        <button class="inline-flex h-10 items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 text-sm font-bold text-red-700 transition-colors hover:bg-red-100" type="button">
                            <span class="material-symbols-outlined text-lg">delete</span>
                            Delete Selected
                        </button>
                    </div>
                </div>

                <div class="folder-tab-strip">
                    @foreach ([
                        'all' => ['label' => 'All Users', 'count' => count($managedUsers)],
                        'student' => ['label' => 'Students', 'count' => collect($managedUsers)->where('role', 'student')->count()],
                        'teacher' => ['label' => 'Teachers', 'count' => collect($managedUsers)->where('role', 'teacher')->count()],
                        'staff' => ['label' => 'Staff', 'count' => collect($managedUsers)->where('role', 'staff')->count()],
                    ] as $tabKey => $tab)
                        <button class="user-table-tab folder-tab {{ $loop->first ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold transition-all" data-user-tab="{{ $tabKey }}" type="button">
                            {{ $tab['label'] }}
                            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[11px] text-primary">{{ $tab['count'] }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 gap-3 border-b border-outline-variant bg-surface-container-low px-6 py-4 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block">
                        <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Search Users</span>
                        <input id="user-search-filter" class="h-10 w-full rounded-lg border border-outline-variant bg-white px-3 text-sm text-primary shadow-sm focus:border-primary focus:ring-primary/20" type="text" placeholder="Name, email, role, country...">
                    </label>
                    <label class="block">
                        <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Country</span>
                        <select id="user-country-filter" class="h-10 w-full rounded-lg border border-outline-variant bg-white px-3 text-sm text-primary shadow-sm focus:border-primary focus:ring-primary/20">
                            <option value="">All Countries</option>
                            @foreach ($countryOptions as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Position</span>
                        <select id="user-position-filter" class="h-10 w-full rounded-lg border border-outline-variant bg-white px-3 text-sm text-primary shadow-sm focus:border-primary focus:ring-primary/20">
                            <option value="">All Positions</option>
                            @foreach (['Student', 'Teacher', 'Operations Manager', 'Team Leader', 'Assistant', 'Trainer', 'CEO'] as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="flex items-end">
                        <button id="user-reset-filters" class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-lg border border-outline-variant bg-white px-4 text-sm font-bold text-secondary transition-colors hover:bg-secondary-fixed" type="button">
                            <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                            Reset Filters
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[1220px] w-full text-left">
                        <thead class="bg-surface-container-high">
                            <tr>
                                <th class="w-12 px-5 py-4">
                                    <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox" aria-label="Select all users">
                                </th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">User</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Role</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Position</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Country</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Last Login</th>
                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Access Summary</th>
                                <th class="px-5 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @foreach ($managedUsers as $user)
                                <tr class="user-row transition-colors hover:bg-surface-container-low"
                                    data-user-role="{{ $user['role'] }}"
                                    data-user-country="{{ $user['country'] }}"
                                    data-user-position="{{ $user['position'] }}"
                                    data-user-search="{{ Str::lower($user['name'].' '.$user['email'].' '.$user['type'].' '.$user['position'].' '.$user['country'].' '.$user['status'].' '.$user['access']) }}">
                                    <td class="px-5 py-4">
                                        <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox" aria-label="Select {{ $user['name'] }}">
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-fixed text-sm font-bold text-primary">
                                                {{ collect(explode(' ', $user['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                                            </div>
                                            <div>
                                                <a href="{{ $user['profile_url'] }}" class="font-bold text-primary transition-colors hover:text-active-accent hover:underline">{{ $user['name'] }}</a>
                                                <p class="mt-0.5 text-xs text-text-secondary">{{ $user['email'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full bg-secondary-fixed px-3 py-1 text-xs font-bold uppercase tracking-wider text-secondary">{{ $user['type'] }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full border border-outline-variant bg-white px-3 py-1 text-xs font-bold text-primary">{{ $user['position'] }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-sm font-bold text-on-surface-variant">{{ $user['country'] }}</td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $user['status_class'] }}">{{ $user['status'] }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-on-surface-variant">{{ $user['last_login'] }}</td>
                                    <td class="px-5 py-4 text-sm text-text-secondary">{{ $user['access'] }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <button class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-outline-variant bg-white text-secondary transition-colors hover:bg-secondary-fixed" type="button" aria-label="Edit {{ $user['name'] }}">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>
                                            <button class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-700 transition-colors hover:bg-red-100" type="button" aria-label="Delete {{ $user['name'] }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="user-empty-state" class="hidden">
                                <td colspan="9" class="px-5 py-12 text-center">
                                    <p class="text-sm font-bold text-primary">No users match these filters.</p>
                                    <p class="mt-1 text-xs text-text-secondary">Try another tab, country, position, or search term.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="user-pagination-footer" class="flex flex-col gap-3 border-t border-outline-variant bg-white px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm font-medium text-text-secondary">
                        Showing <span id="user-page-start" class="font-bold text-primary">1</span> to
                        <span id="user-page-end" class="font-bold text-primary">10</span> of
                        <span id="user-total-count" class="font-bold text-primary">{{ count($managedUsers) }}</span> users
                    </p>
                    <div id="user-pagination-controls" class="flex flex-wrap items-center gap-2">
                        <button id="user-prev-page" class="inline-flex h-9 items-center gap-1 rounded-lg border border-outline-variant bg-white px-3 text-xs font-bold text-secondary transition-colors hover:bg-secondary-fixed disabled:cursor-not-allowed disabled:opacity-40" type="button">
                            <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                            Previous
                        </button>
                        <div id="user-page-buttons" class="flex items-center gap-1"></div>
                        <button id="user-next-page" class="inline-flex h-9 items-center gap-1 rounded-lg border border-outline-variant bg-white px-3 text-xs font-bold text-secondary transition-colors hover:bg-secondary-fixed disabled:cursor-not-allowed disabled:opacity-40" type="button">
                            Next
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-6 md:grid-cols-5">
                @foreach ($roleSummaries as $role)
                    <button class="role-tab rounded-xl border border-surface-container-high bg-white p-5 text-left shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md {{ $role['active'] ? 'ring-2 ring-active-accent' : '' }}" data-role-tab="{{ $role['key'] }}" type="button">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $role['class'] }}">{{ $role['label'] }}</span>
                            <span class="text-2xl font-bold text-primary">{{ $role['users'] }}</span>
                        </div>
                        <p class="text-sm font-semibold text-primary">{{ $role['label'] }} Role</p>
                        <p class="mt-2 text-xs leading-5 text-text-secondary">{{ $role['description'] }}</p>
                    </button>
                @endforeach
            </section>

            <section class="overflow-hidden rounded-xl border border-surface-container-high bg-white shadow-sm">
                <div class="flex flex-col justify-between gap-4 bg-white px-6 py-5 md:flex-row md:items-center">
                    <div>
                        <h3 class="text-lg font-bold text-primary">Capability Controls</h3>
                        <p class="mt-1 text-sm text-text-secondary">Currently editing: <span id="selected-role-label" class="font-bold text-primary">Admin</span></p>
                    </div>
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        Money, payroll, earnings, payments, and pricing are marked sensitive.
                    </div>
                </div>

                <div class="folder-tab-strip">
                    @foreach ($permissionGroups as $group)
                        <button class="permission-group-tab folder-tab {{ $loop->first ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold transition-all" data-group-tab="{{ Str::slug($group['title']) }}" type="button">
                            {{ $group['title'] }}
                        </button>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 gap-6 p-6 xl:grid-cols-12">
                    <aside class="space-y-4 xl:col-span-3">
                        <div class="rounded-xl border border-surface-container-high bg-surface-container-low p-5">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Selected Role Rule</h4>
                            <p id="selected-role-description" class="mt-3 text-sm leading-6 text-text-secondary">{{ $roleSummaries[0]['description'] }}</p>
                        </div>
                        <div class="rounded-xl border border-red-200 bg-red-50 p-5">
                            <div class="flex items-center gap-2 text-red-800">
                                <span class="material-symbols-outlined text-[20px]">privacy_tip</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Student Contact Rule</h4>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-red-800">Student mobile numbers, email, WhatsApp, WeChat, and direct communication contacts are Admin-only by default. Use the Manager Contact Exception only when you intentionally approve it.</p>
                        </div>
                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                            <div class="flex items-center gap-2 text-amber-800">
                                <span class="material-symbols-outlined text-[20px]">shield_lock</span>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Suggested Default</h4>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-amber-800">Keep payroll, itemized lesson statements, payments, and packages/pricing restricted to Admin unless you intentionally delegate them.</p>
                        </div>
                    </aside>

                    <div class="xl:col-span-9">
                        @foreach ($permissionGroups as $group)
                            <div class="permission-group-panel {{ $loop->first ? '' : 'hidden' }}" data-group-panel="{{ Str::slug($group['title']) }}">
                                <div class="mb-4">
                                    <h4 class="text-xl font-bold text-primary">{{ $group['title'] }}</h4>
                                    <p class="mt-1 text-sm text-text-secondary">{{ $group['description'] }}</p>
                                </div>
                                <div class="overflow-hidden rounded-xl border border-outline-variant">
                                    <table class="min-w-[820px] w-full border-collapse text-left">
                                        <thead>
                                            <tr class="bg-surface-container-high">
                                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Capability</th>
                                                <th class="px-5 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Sensitivity</th>
                                                @foreach ($roleSummaries as $role)
                                                    <th class="px-5 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">{{ $role['label'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-outline-variant">
                                            @foreach ($group['items'] as $item)
                                                <tr class="transition-colors hover:bg-surface-container-low">
                                                    <td class="px-5 py-4">
                                                        <p class="font-bold text-primary">{{ $item['label'] }}</p>
                                                        <p class="mt-1 text-xs text-text-secondary">{{ $item['detail'] }}</p>
                                                    </td>
                                                    <td class="px-5 py-4">
                                                        @if ($item['sensitive'])
                                                            <span class="inline-flex items-center gap-1 rounded-full border border-red-200 bg-red-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-red-700">
                                                                <span class="material-symbols-outlined text-[14px]">lock</span>
                                                                Sensitive
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-700">
                                                                Standard
                                                            </span>
                                                        @endif
                                                    </td>
                                                    @foreach ($roleSummaries as $role)
                                                        <td class="px-5 py-4 text-center">
                                                            <label class="inline-flex cursor-pointer items-center justify-center">
                                                                <input class="permission-switch sr-only" type="checkbox" data-role-permission="{{ $role['key'] }}" @checked(in_array($role['key'], $item['roles'], true))>
                                                                <span class="relative inline-flex h-6 w-11 rounded-full bg-slate-300 transition-colors">
                                                                    <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                                                                </span>
                                                            </label>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        const roleDescriptions = @json(collect($roleSummaries)->mapWithKeys(fn ($role) => [$role['key'] => ['label' => $role['label'], 'description' => $role['description']]]));

        document.querySelectorAll('[data-role-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('[data-role-tab]').forEach((button) => button.classList.remove('ring-2', 'ring-active-accent'));
                tab.classList.add('ring-2', 'ring-active-accent');

                const role = roleDescriptions[tab.dataset.roleTab];
                document.getElementById('selected-role-label').textContent = role.label;
                document.getElementById('selected-role-description').textContent = role.description;
            });
        });

        document.querySelectorAll('[data-group-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                const selectedGroup = tab.dataset.groupTab;
                document.querySelectorAll('[data-group-tab]').forEach((button) => {
                    const active = button.dataset.groupTab === selectedGroup;
                    button.classList.toggle('folder-tab-active', active);
                    button.classList.toggle('hover:bg-white', !active);
                });
                document.querySelectorAll('[data-group-panel]').forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.groupPanel !== selectedGroup);
                });
            });
        });

        const userSearchFilter = document.querySelector('#user-search-filter');
        const userCountryFilter = document.querySelector('#user-country-filter');
        const userPositionFilter = document.querySelector('#user-position-filter');
        const userResetFilters = document.querySelector('#user-reset-filters');
        const userRows = Array.from(document.querySelectorAll('.user-row'));
        const userEmptyState = document.querySelector('#user-empty-state');
        const userPaginationFooter = document.querySelector('#user-pagination-footer');
        const userPaginationControls = document.querySelector('#user-pagination-controls');
        const userPageStart = document.querySelector('#user-page-start');
        const userPageEnd = document.querySelector('#user-page-end');
        const userTotalCount = document.querySelector('#user-total-count');
        const userPrevPage = document.querySelector('#user-prev-page');
        const userNextPage = document.querySelector('#user-next-page');
        const userPageButtons = document.querySelector('#user-page-buttons');
        const usersPerPage = 10;
        let selectedUserTab = 'all';
        let currentUserPage = 1;

        function applyUserFilters(resetPage = true) {
            if (resetPage) {
                currentUserPage = 1;
            }

            const search = (userSearchFilter?.value || '').trim().toLowerCase();
            const country = userCountryFilter?.value || '';
            const position = userPositionFilter?.value || '';
            const matchingRows = [];

            userRows.forEach((row) => {
                const matchesTab = selectedUserTab === 'all' || row.dataset.userRole === selectedUserTab;
                const matchesSearch = !search || row.dataset.userSearch.includes(search);
                const matchesCountry = !country || row.dataset.userCountry === country;
                const matchesPosition = !position || row.dataset.userPosition === position;

                row.classList.add('hidden');
                if (matchesTab && matchesSearch && matchesCountry && matchesPosition) {
                    matchingRows.push(row);
                }
            });

            const totalMatches = matchingRows.length;
            const totalPages = Math.max(1, Math.ceil(totalMatches / usersPerPage));
            currentUserPage = Math.min(currentUserPage, totalPages);

            const startIndex = (currentUserPage - 1) * usersPerPage;
            const endIndex = startIndex + usersPerPage;
            matchingRows.slice(startIndex, endIndex).forEach((row) => row.classList.remove('hidden'));

            userEmptyState?.classList.toggle('hidden', totalMatches > 0);
            userPaginationFooter?.classList.toggle('hidden', totalMatches === 0);
            userPaginationControls?.classList.toggle('hidden', totalMatches <= usersPerPage);

            if (userPageStart) userPageStart.textContent = totalMatches === 0 ? '0' : String(startIndex + 1);
            if (userPageEnd) userPageEnd.textContent = String(Math.min(endIndex, totalMatches));
            if (userTotalCount) userTotalCount.textContent = String(totalMatches);
            if (userPrevPage) userPrevPage.disabled = currentUserPage === 1;
            if (userNextPage) userNextPage.disabled = currentUserPage === totalPages;

            if (userPageButtons) {
                userPageButtons.innerHTML = '';

                for (let page = 1; page <= totalPages; page += 1) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = page;
                    button.className = [
                        'inline-flex h-9 w-9 items-center justify-center rounded-lg border text-xs font-bold transition-colors',
                        page === currentUserPage
                            ? 'border-primary bg-primary text-white'
                            : 'border-outline-variant bg-white text-secondary hover:bg-secondary-fixed',
                    ].join(' ');
                    button.addEventListener('click', () => {
                        currentUserPage = page;
                        applyUserFilters(false);
                    });
                    userPageButtons.appendChild(button);
                }
            }
        }

        document.querySelectorAll('[data-user-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                selectedUserTab = tab.dataset.userTab;
                document.querySelectorAll('[data-user-tab]').forEach((button) => {
                    const active = button.dataset.userTab === selectedUserTab;
                    button.classList.toggle('folder-tab-active', active);
                    button.classList.toggle('hover:bg-white', !active);
                });
                applyUserFilters(true);
            });
        });

        [userSearchFilter, userCountryFilter, userPositionFilter].forEach((field) => {
            field?.addEventListener('input', () => applyUserFilters(true));
            field?.addEventListener('change', () => applyUserFilters(true));
        });

        userResetFilters?.addEventListener('click', () => {
            if (userSearchFilter) userSearchFilter.value = '';
            if (userCountryFilter) userCountryFilter.value = '';
            if (userPositionFilter) userPositionFilter.value = '';
            applyUserFilters(true);
        });

        userPrevPage?.addEventListener('click', () => {
            if (currentUserPage > 1) {
                currentUserPage -= 1;
                applyUserFilters(false);
            }
        });

        userNextPage?.addEventListener('click', () => {
            currentUserPage += 1;
            applyUserFilters(false);
        });

        applyUserFilters(false);
    </script>
</body>
</html>
