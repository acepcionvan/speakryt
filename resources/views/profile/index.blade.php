<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
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
        .preference-switch:checked + span {
            background: #022448;
        }
        .preference-switch:checked + span span {
            transform: translateX(20px);
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'profile', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-y-auto bg-[#eef3f8]">
        <header class="sticky top-0 z-40 flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center overflow-hidden rounded border border-white/20 bg-white/20 text-lg font-bold shadow-sm">{{ $profile['photo_initials'] }}</div>
                <div class="flex flex-col">
                    <h1 class="text-xl font-bold leading-none">Welcome back, {{ $profile['name'] }}</h1>
                    <p class="text-[11px] font-medium opacity-90">You're managing the most sensitive parts of the system today.</p>
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

        <div class="mx-auto flex min-h-[calc(100vh-64px)] w-full max-w-[1440px] flex-col gap-6 p-6">
            <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                <div class="grid grid-cols-1 gap-6 p-6 xl:grid-cols-12 xl:items-center">
                    <div class="xl:col-span-6">
                        <div class="flex items-center gap-5">
                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[linear-gradient(135deg,#022448_0%,#00aeef_100%)] text-3xl font-bold text-white shadow-lg">{{ $profile['photo_initials'] }}</div>
                            <div>
                                <p class="mb-2 inline-flex rounded-full bg-primary-fixed px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-primary">{{ $profile['status'] }} Account</p>
                                <h2 class="font-display text-3xl font-bold leading-tight text-primary">{{ $profile['name'] }}</h2>
                                <p class="mt-1 text-sm font-semibold text-secondary">{{ $profile['role'] }}</p>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-text-secondary">{{ $profile['bio'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 xl:col-span-6">
                        <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-text-secondary">Last Login</p>
                            <p class="mt-2 text-sm font-semibold text-primary">{{ $profile['last_login'] }}</p>
                        </div>
                        <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-text-secondary">Employee ID</p>
                            <p class="mt-2 text-sm font-semibold text-primary">{{ $profile['employee_id'] }}</p>
                        </div>
                        <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-text-secondary">Department</p>
                            <p class="mt-2 text-sm font-semibold text-primary">{{ $profile['department'] }}</p>
                        </div>
                        <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-text-secondary">Primary Access</p>
                            <p class="mt-2 text-sm font-semibold text-primary">Admin Controls</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid flex-1 grid-cols-1 gap-6 xl:grid-cols-12">
                <div class="space-y-6 xl:col-span-8">
                    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-outline-variant bg-surface-container-low px-6 py-4">
                            <div>
                                <h3 class="font-display text-2xl font-bold text-primary">Personal Information</h3>
                                <p class="mt-1 text-sm text-text-secondary">Core account identity and administrator contact details.</p>
                            </div>
                            <button class="rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white shadow-sm transition-all hover:opacity-90">Edit Details</button>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Full Name</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" type="text" value="{{ $profile['name'] }}">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Email Address</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" type="email" value="{{ $profile['email'] }}">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Phone Number</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" type="tel" value="{{ $profile['phone'] }}">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Language Preference</label>
                                <select class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20">
                                    <option selected>{{ $profile['language'] }}</option>
                                    <option>English (UK)</option>
                                    <option>Japanese</option>
                                    <option>Mandarin</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Department</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" type="text" value="{{ $profile['department'] }}">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Timezone</label>
                                <select class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20">
                                    <option selected>{{ $profile['timezone'] }}</option>
                                    <option>(GMT+00:00) UTC</option>
                                    <option>(GMT-08:00) Pacific Time (US & Canada)</option>
                                    <option>(GMT+09:00) Tokyo</option>
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-sm font-bold text-primary">Office / Work Location</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" type="text" value="{{ $profile['office'] }}">
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-outline-variant bg-surface-container-low px-6 py-4">
                            <div>
                                <h3 class="font-display text-2xl font-bold text-primary">Security & Password</h3>
                                <p class="mt-1 text-sm text-text-secondary">Protect your admin account with password and verification controls.</p>
                            </div>
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-700">Enhanced Protection</span>
                        </div>
                        <div class="space-y-6 p-6">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-primary">Current Password</label>
                                    <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="••••••••" type="password">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-primary">New Password</label>
                                    <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="Min. 8 characters" type="password">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-primary">Confirm Password</label>
                                    <input class="w-full rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="Confirm new password" type="password">
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 rounded-xl border border-outline-variant bg-surface-container-low p-5 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h4 class="text-sm font-bold text-primary">Two-Factor Authentication</h4>
                                    <p class="mt-1 text-sm text-text-secondary">Require a second verification step before allowing admin access.</p>
                                </div>
                                <label class="inline-flex cursor-pointer items-center">
                                    <input class="preference-switch sr-only" type="checkbox" @checked($profile['two_factor_enabled'])>
                                    <span class="relative inline-flex h-6 w-11 rounded-full bg-slate-300 transition-colors">
                                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                            <h3 class="font-display text-2xl font-bold text-primary">Admin Access Scope</h3>
                            <p class="mt-1 text-sm text-text-secondary">Sensitive areas attached to your administrator profile.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-4 p-6 lg:grid-cols-3">
                            @foreach ($accessScopes as $scope)
                                <div class="rounded-xl border border-outline-variant p-4">
                                    <div class="mb-3 flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary-fixed text-secondary">
                                            <span class="material-symbols-outlined">{{ $scope['icon'] }}</span>
                                        </div>
                                        <h4 class="font-bold text-primary">{{ $scope['title'] }}</h4>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach ($scope['items'] as $item)
                                            <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[16px] text-active-accent">check_circle</span>
                                                <span>{{ $item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="space-y-6 xl:col-span-4">
                    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                            <h3 class="font-display text-2xl font-bold text-primary">Notification Settings</h3>
                        </div>
                        <div class="space-y-4 p-6">
                            @foreach ($notificationSettings as $setting)
                                <div class="flex items-center justify-between gap-4 rounded-xl border border-outline-variant p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-fixed text-primary">
                                            <span class="material-symbols-outlined">{{ $setting['icon'] }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary">{{ $setting['label'] }}</p>
                                            <p class="mt-1 text-xs leading-5 text-text-secondary">{{ $setting['description'] }}</p>
                                        </div>
                                    </div>
                                    <label class="inline-flex cursor-pointer items-center">
                                        <input class="preference-switch sr-only" type="checkbox" @checked($setting['enabled'])>
                                        <span class="relative inline-flex h-6 w-11 rounded-full bg-slate-300 transition-colors">
                                            <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                            <h3 class="font-display text-2xl font-bold text-primary">Workspace Preferences</h3>
                        </div>
                        <div class="space-y-4 p-6">
                            <div class="flex items-center justify-between rounded-xl border border-outline-variant p-4">
                                <div>
                                    <p class="font-bold text-primary">Compact Tables</p>
                                    <p class="mt-1 text-xs text-text-secondary">Use denser rows across admin tables for faster scanning.</p>
                                </div>
                                <label class="inline-flex cursor-pointer items-center">
                                    <input class="preference-switch sr-only" type="checkbox" checked>
                                    <span class="relative inline-flex h-6 w-11 rounded-full bg-slate-300 transition-colors">
                                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between rounded-xl border border-outline-variant p-4">
                                <div>
                                    <p class="font-bold text-primary">Session Auto-Lock</p>
                                    <p class="mt-1 text-xs text-text-secondary">Require re-authentication after inactivity on sensitive pages.</p>
                                </div>
                                <label class="inline-flex cursor-pointer items-center">
                                    <input class="preference-switch sr-only" type="checkbox" checked>
                                    <span class="relative inline-flex h-6 w-11 rounded-full bg-slate-300 transition-colors">
                                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-primary">Theme Preference</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button class="rounded-lg border-2 border-active-accent bg-primary-fixed px-3 py-3 text-xs font-bold text-primary">Light</button>
                                    <button class="rounded-lg border border-outline-variant px-3 py-3 text-xs font-bold text-on-surface-variant">Neutral</button>
                                    <button class="rounded-lg border border-outline-variant px-3 py-3 text-xs font-bold text-on-surface-variant">System</button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined mt-0.5 text-red-700">privacy_tip</span>
                            <div>
                                <h3 class="font-bold text-red-800">Sensitive Admin Reminder</h3>
                                <p class="mt-2 text-sm leading-6 text-red-800">You currently control payroll visibility, student communication contacts, pricing access, and permission changes. Review these regularly and keep two-factor authentication enabled.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white shadow-sm">
                <div class="grid grid-cols-1 xl:grid-cols-12">
                    <div class="border-b border-outline-variant p-6 xl:col-span-5 xl:border-b-0 xl:border-r">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <h3 class="font-display text-2xl font-bold text-primary">Admin Review Queue</h3>
                                <p class="mt-1 text-sm text-text-secondary">A quick pass over the sensitive settings tied to your account.</p>
                            </div>
                            <span class="rounded-full bg-primary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-primary">4 Items</span>
                        </div>
                        <div class="space-y-3">
                            @foreach ($profileActivity as $activity)
                                <div class="flex items-center justify-between gap-4 rounded-xl border border-outline-variant bg-surface-container-low p-4">
                                    <div>
                                        <p class="font-bold text-primary">{{ $activity['title'] }}</p>
                                        <p class="mt-1 text-xs text-text-secondary">{{ $activity['time'] }}</p>
                                    </div>
                                    <span class="rounded-full border border-outline-variant bg-white px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-secondary">{{ $activity['status'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-b border-outline-variant p-6 xl:col-span-4 xl:border-b-0 xl:border-r">
                        <h3 class="font-display text-2xl font-bold text-primary">Security Checklist</h3>
                        <p class="mt-1 text-sm text-text-secondary">Keep the admin account tidy and controlled.</p>
                        <div class="mt-5 space-y-3">
                            @foreach ($profileChecklist as $item)
                                <div class="flex items-center gap-3 rounded-xl border border-outline-variant p-4">
                                    <span class="material-symbols-outlined text-[20px] {{ $item['done'] ? 'text-active-accent' : 'text-amber-600' }}">{{ $item['done'] ? 'check_circle' : 'warning' }}</span>
                                    <span class="text-sm font-semibold text-primary">{{ $item['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-6 xl:col-span-3">
                        <h3 class="font-display text-2xl font-bold text-primary">Quick Actions</h3>
                        <p class="mt-1 text-sm text-text-secondary">Admin shortcuts for sensitive account work.</p>
                        <div class="mt-5 grid gap-3">
                            <a class="flex items-center justify-between rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm font-bold text-primary transition-colors hover:bg-primary-fixed" href="{{ route('users.index') }}">
                                Permission Center
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a class="flex items-center justify-between rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm font-bold text-primary transition-colors hover:bg-primary-fixed" href="{{ route('payments.index') }}">
                                Payment Review
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a class="flex items-center justify-between rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm font-bold text-primary transition-colors hover:bg-primary-fixed" href="{{ route('packages.index') }}">
                                Pricing Controls
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <button class="flex items-center justify-between rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700 transition-colors hover:bg-red-100">
                                Revoke Other Sessions
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex justify-end gap-4 pb-4">
                <button class="px-8 py-3 text-secondary transition-colors hover:text-on-surface">Discard Changes</button>
                <button class="flex items-center gap-2 rounded-lg bg-primary px-10 py-3 font-bold text-white shadow-md transition-all hover:opacity-90 active:scale-[0.99]" onclick="handleSave()">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save Changes
                </button>
            </div>
        </div>
    </main>

    <div class="pointer-events-none fixed bottom-8 right-8 z-[100] flex translate-y-20 items-center gap-3 rounded-lg bg-[#2d3133] px-6 py-3 text-white opacity-0 shadow-2xl transition-all duration-300" id="toast">
        <span class="material-symbols-outlined text-[#00aeef]">check_circle</span>
        <span class="font-medium">Profile settings updated successfully.</span>
    </div>

    <script>
        function handleSave() {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }
    </script>
</body>
</html>
