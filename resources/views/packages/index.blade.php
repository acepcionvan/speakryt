<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Packages &amp; Pricing | SpeakRyt</title>
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
    @include('partials.sidebar', ['activeSection' => 'packages', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-hidden bg-background">
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

        <div class="flex-grow space-y-6 overflow-y-auto p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-primary">Packages &amp; Pricing</h2>
                    <p class="mt-1 text-sm text-on-surface-variant">Manage lesson packages and regional pricing tiers.</p>
                </div>
                <div class="rounded border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-bold text-amber-800">
                    Admin-only sensitive pricing
                </div>
            </div>

            <section class="grid grid-cols-1 gap-4 lg:grid-cols-12">
                <div class="rounded border border-surface-container-high bg-white p-5 shadow-sm lg:col-span-6">
                    <label class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Region Filter</label>
                    <div class="relative">
                        <select id="region-filter" class="w-full appearance-none rounded-sm border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="all">All Countries</option>
                            @foreach ($regionalPricing['countries'] as $country)
                                <option value="{{ Str::slug($country) }}">{{ $country }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-lg">expand_more</span>
                        </div>
                    </div>
                </div>
                @foreach ($packageStats as $stat)
                    <div class="rounded border border-surface-container-high bg-white p-5 shadow-sm lg:col-span-2">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">{{ $stat['label'] }}</p>
                                <p class="mt-1 text-2xl font-bold text-primary">{{ $stat['value'] }}</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded {{ $stat['class'] }}">
                                <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="rounded border border-surface-container-high bg-white p-5 shadow-sm">
                <div class="mb-4 flex flex-col justify-between gap-3 md:flex-row md:items-end">
                    <div>
                        <h3 class="text-xl font-bold text-primary">Regional Package Rules</h3>
                        <p class="mt-1 text-sm text-on-surface-variant">Pricing is grouped by region. Use the country filter below to view only one country at a time.</p>
                    </div>
                    <span class="rounded-full bg-primary/5 px-4 py-2 text-xs font-bold uppercase tracking-wider text-primary">Adult 50 min · Kids 25 min</span>
                </div>
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @foreach ($regionalPricing['groups'] as $group)
                        <div class="rounded border border-outline-variant bg-surface-container-lowest p-4">
                            <div class="mb-4">
                                <p class="text-sm font-bold text-primary">{{ $group['label'] }}</p>
                                <p class="mt-1 text-xs leading-5 text-on-surface-variant">{{ $group['description'] }}</p>
                            </div>
                            <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                @foreach ($group['categories'] as $category => $categoryData)
                                    <div class="overflow-hidden rounded border border-outline-variant bg-white">
                                        <div class="bg-primary px-4 py-3 text-white">
                                            <p class="text-sm font-bold">{{ $category }}</p>
                                            <p class="mt-0.5 text-xs opacity-80">{{ $categoryData['duration'] }} per lesson</p>
                                        </div>
                                        <div class="divide-y divide-outline-variant/60">
                                            @foreach ($categoryData['packages'] as $package)
                                                <div class="grid grid-cols-[1fr_auto] gap-3 px-4 py-3">
                                                    <div>
                                                        <p class="text-sm font-bold text-primary">{{ $package['tier'] }} · {{ $package['lessons'] }} lessons</p>
                                                        <p class="mt-1 text-xs text-on-surface-variant">{{ $package['validity'] }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-sm font-bold text-primary">{{ $package['price'] }}</p>
                                                        <p class="mt-1 text-xs font-semibold text-success">{{ $package['discount'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="flex min-h-[400px] flex-col overflow-hidden rounded border border-surface-container-high bg-white shadow-sm">
                <div class="flex-grow overflow-x-auto overflow-y-auto">
                    <table class="min-w-[1180px] w-full border-collapse text-left">
                        <thead class="sticky top-0 z-10">
                            <tr class="border-b border-surface-container-high bg-surface-container-low">
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Package Name</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Country</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Category</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Duration</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Lessons</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Price</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Validity</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Discount</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Status</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-high">
                            @foreach ($pricingPackages as $package)
                                <tr class="package-row group transition-colors {{ $package['category'] === 'Kids English' ? 'bg-cyan-50/80 hover:bg-cyan-100/80' : 'hover:bg-surface-container-low' }}" data-country="{{ Str::slug($package['country']) }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-sm transition-all group-hover:bg-white group-hover:shadow-sm {{ $package['icon_class'] }}">
                                                <span class="material-symbols-outlined text-xl">{{ $package['icon'] }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-primary">{{ $package['name'] }}</span>
                                                <span class="text-[11px] text-on-surface-variant">{{ $package['description'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">{{ $package['country'] }}</td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <span class="{{ $package['category'] === 'Kids English' ? 'rounded-full bg-cyan-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-cyan-700' : '' }}">{{ $package['category'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">{{ $package['duration'] }}</td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">{{ $package['lessons'] }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-primary">{{ $package['price'] }}</td>
                                    <td class="px-6 py-4 text-center text-xs font-semibold text-on-surface-variant">{{ $package['validity'] }}</td>
                                    <td class="px-6 py-4 text-center text-sm font-bold {{ $package['discount'] === '-' ? 'text-on-surface-variant' : 'text-success' }}">{{ $package['discount'] }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-full border px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-tight {{ $package['status_class'] }}">{{ $package['status'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="flex h-8 w-8 items-center justify-center rounded text-on-surface-variant transition-all hover:bg-primary/10 hover:text-primary" title="Edit package">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </button>
                                            <button class="flex h-8 w-8 items-center justify-center rounded text-on-surface-variant transition-all hover:bg-error/10 hover:text-error" title="Delete package">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-shrink-0 items-center justify-between border-t border-surface-container-high bg-surface-container-low px-6 py-3">
                    <p id="package-table-count" class="text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">Showing 1 to {{ count($pricingPackages) }} of {{ count($pricingPackages) }} entries</p>
                    <div class="flex items-center gap-1">
                        <button class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded border border-outline-variant bg-white text-on-surface-variant opacity-40">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </button>
                        <button class="flex h-8 w-8 items-center justify-center rounded bg-active-accent text-xs font-bold text-white shadow-sm">1</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-xs font-bold text-on-surface-variant hover:bg-surface-variant/50">2</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-xs font-bold text-on-surface-variant hover:bg-surface-variant/50">3</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded border border-outline-variant bg-white text-on-surface-variant transition-colors hover:bg-surface-variant/50">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        const regionFilter = document.getElementById('region-filter');
        const packageRows = Array.from(document.querySelectorAll('.package-row'));
        const packageTableCount = document.getElementById('package-table-count');
        const totalPackageRows = packageRows.length;

        function applyRegionFilter() {
            const selectedCountry = regionFilter.value;
            let visibleRows = 0;

            packageRows.forEach((row) => {
                const shouldShow = selectedCountry === 'all' || row.dataset.country === selectedCountry;
                row.classList.toggle('hidden', !shouldShow);
                if (shouldShow) {
                    visibleRows += 1;
                }
            });

            packageTableCount.textContent = visibleRows === 0
                ? `Showing 0 of ${totalPackageRows} entries`
                : `Showing 1 to ${visibleRows} of ${totalPackageRows} entries`;
        }

        regionFilter.addEventListener('change', applyRegionFilter);
        applyRegionFilter();
    </script>
</body>
</html>
