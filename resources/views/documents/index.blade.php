<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company Documents | SpeakRyt</title>
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
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'documents', 'sidebarClass' => 'hidden lg:flex'])

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
                    <h2 class="text-3xl font-bold tracking-tight text-primary">Company Documents</h2>
                    <p class="mt-1 text-sm text-text-secondary">Manage institutional files, internal policies, legal records, and operating manuals.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button class="flex h-10 items-center gap-2 rounded-lg border border-secondary bg-white px-5 text-sm font-bold text-secondary transition-colors hover:bg-secondary-fixed">
                        <span class="material-symbols-outlined text-lg">upload_file</span>
                        Upload File
                    </button>
                    <button class="flex h-10 items-center gap-2 rounded-lg bg-primary px-5 text-sm font-bold text-white shadow-md transition-all hover:opacity-90 active:scale-95">
                        <span class="material-symbols-outlined text-lg">create_new_folder</span>
                        New Folder
                    </button>
                </div>
            </div>

            <section class="grid grid-cols-1 gap-6 md:grid-cols-4">
                @foreach ($documentStats as $stat)
                    <div class="flex items-center gap-4 rounded-xl border border-surface-container-high bg-white p-5 shadow-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full {{ $stat['class'] }}">
                            <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-text-secondary">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-primary">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                <aside class="space-y-6 xl:col-span-3">
                    <div class="rounded-xl border border-surface-container-high bg-white p-5 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-primary">Storage Status</h3>
                            <span class="text-xs font-bold text-text-secondary">42%</span>
                        </div>
                        <div class="mb-2 flex justify-between text-xs text-text-secondary">
                            <span>Total Usage</span>
                            <span>4.2 GB / 10 GB</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-surface-container-high">
                            <div class="h-full rounded-full bg-active-accent" style="width: 42%;"></div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-surface-container-high bg-white p-5 shadow-sm">
                        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-primary">Quick Filters</h3>
                        <div class="flex flex-wrap gap-2">
                            <button class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">Urgent Review</button>
                            <button class="rounded-full bg-surface-container px-3 py-1 text-xs font-bold text-on-surface-variant">Tax 2024</button>
                            <button class="rounded-full bg-surface-container px-3 py-1 text-xs font-bold text-on-surface-variant">Accreditation</button>
                            <button class="rounded-full bg-surface-container px-3 py-1 text-xs font-bold text-on-surface-variant">Contracts</button>
                        </div>
                    </div>
                </aside>

                <div class="overflow-hidden rounded-xl border border-surface-container-high bg-white shadow-sm xl:col-span-9">
                    <div class="flex flex-col justify-between gap-4 bg-white px-6 py-5 md:flex-row md:items-center">
                        <div>
                            <h3 class="text-lg font-bold text-primary">Document Library</h3>
                            <p class="mt-1 text-sm text-text-secondary">Legal & Registration / Main Registry</p>
                        </div>
                        <div class="relative w-full md:w-80">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
                            <input class="h-10 w-full rounded-lg border border-outline-variant bg-white pl-10 pr-3 text-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="Search documents..." type="text">
                        </div>
                    </div>

                    <div class="folder-tab-strip">
                        @foreach ($documentCategories as $category)
                            <button class="folder-tab {{ $category['active'] ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold transition-all" type="button">
                                <span class="material-symbols-outlined text-[19px]">{{ $category['icon'] }}</span>
                                {{ $category['name'] }}
                            </button>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[980px] w-full border-collapse text-left">
                            <thead>
                                <tr class="bg-surface-container-high">
                                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Document Name</th>
                                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Type</th>
                                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Last Updated</th>
                                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Access Level</th>
                                    <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                @foreach ($companyDocuments as $document)
                                    <tr class="group transition-colors hover:bg-surface-container-low">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-[24px] {{ $document['icon_class'] }}" @if ($document['icon'] === 'folder') style="font-variation-settings: 'FILL' 1;" @endif>{{ $document['icon'] }}</span>
                                                <div>
                                                    <p class="font-bold text-primary transition-colors group-hover:text-secondary group-hover:underline">{{ $document['name'] }}</p>
                                                    <p class="text-xs text-text-secondary">{{ $document['meta'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-on-surface-variant">{{ $document['type'] }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-on-surface-variant">{{ $document['updated'] }}</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full border px-3 py-1 text-[10px] font-bold uppercase tracking-wider {{ $document['access_class'] }}">{{ $document['access'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-primary-fixed hover:text-primary" title="View">
                                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                                </button>
                                                <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-secondary-fixed hover:text-secondary" title="Download">
                                                    <span class="material-symbols-outlined text-[20px]">download</span>
                                                </button>
                                                <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-primary" title="More">
                                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-outline-variant bg-surface-container-low px-6 py-4">
                        <p class="text-sm text-text-secondary">Showing 1 to {{ count($companyDocuments) }} of 12 items</p>
                        <div class="flex items-center gap-2">
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant text-text-secondary opacity-50" disabled>
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                            </button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-sm font-bold text-white">1</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-sm font-bold text-text-secondary transition-all hover:bg-primary hover:text-white">2</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-text-secondary transition-all hover:bg-primary hover:text-white">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
