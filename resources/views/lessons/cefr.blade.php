<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CEFR Curriculum | SpeakRyt</title>
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
                        error: '#e74c3c',
                        outline: '#74777f',
                        'outline-variant': '#c4c6cf',
                        'surface-bright': '#f7f9fb',
                        'surface-container': '#eceef0',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-high': '#e6e8ea',
                        'surface-container-highest': '#e0e3e5',
                        'surface-container-lowest': '#ffffff',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#43474e',
                        'text-secondary': '#666666',
                        'active-accent': '#00bfff',
                        'primary-fixed': '#d5e3ff',
                        'secondary-fixed': '#cce5ff',
                        'tertiary-fixed': '#c3e8ff',
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
            padding: 14px 18px 0;
        }
        .folder-tab {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-[#f0f2f5] font-sans text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'lessons', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-grow flex-col overflow-y-auto">
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
            <x-back-button :href="route('lessons.index')" label="Back to Lessons" />

            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-text-secondary">
                        <a class="transition-colors hover:text-secondary" href="{{ route('lessons.index') }}">Curriculum</a>
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                        <span class="text-primary">CEFR</span>
                    </div>
                    <h2 class="text-3xl font-bold leading-tight text-primary">CEFR Curriculum</h2>
                </div>
                <div class="relative">
                    <select class="appearance-none rounded-xl border border-outline-variant bg-white py-2.5 pl-4 pr-10 text-sm font-semibold shadow-sm outline-none focus:ring-1 focus:ring-primary">
                        <option>Adult Programs</option>
                        <option>Kids Programs</option>
                        <option>Corporate Training</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">expand_more</span>
                </div>
            </div>

            <section class="grid grid-cols-12 items-center gap-6">
                <div class="folder-tab-strip col-span-12 rounded-t-xl border border-outline-variant border-b-0 shadow-sm lg:col-span-7">
                    @foreach ($cefrLevels as $level)
                        <button class="folder-tab {{ $loop->first ? 'folder-tab-active' : 'hover:bg-white' }} flex-1 text-sm font-bold transition-all">{{ $level }}</button>
                    @endforeach
                </div>
                <div class="col-span-12 grid grid-cols-1 gap-3 sm:grid-cols-3 lg:col-span-5">
                    <div class="flex items-center gap-3 rounded-xl border border-outline-variant bg-white p-3.5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-fixed text-primary">
                            <span class="material-symbols-outlined text-[22px]">folder_open</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold leading-none text-primary">10</p>
                            <p class="mt-1 text-[9px] font-bold uppercase text-text-secondary">Modules</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-outline-variant bg-white p-3.5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-tertiary-fixed text-secondary">
                            <span class="material-symbols-outlined text-[22px]">auto_stories</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold leading-none text-primary">300</p>
                            <p class="mt-1 text-[9px] font-bold uppercase text-text-secondary">Lessons</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-outline-variant bg-white p-3.5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-error">
                            <span class="material-symbols-outlined text-[22px]">picture_as_pdf</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold leading-none text-primary">300</p>
                            <p class="mt-1 text-[9px] font-bold uppercase text-text-secondary">PDF Files</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-12 items-start gap-6">
                <aside class="col-span-12 flex h-[700px] flex-col overflow-hidden rounded-xl border border-outline-variant bg-white shadow-sm lg:col-span-3">
                    <div class="flex items-center justify-between border-b border-outline-variant bg-surface-bright p-5">
                        <div>
                            <h3 class="font-bold text-primary">Modules (A1)</h3>
                            <p class="text-[10px] font-semibold uppercase tracking-tight text-text-secondary">Total: 10 Modules</p>
                        </div>
                        <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-fixed text-primary shadow-sm transition-all hover:bg-primary hover:text-white">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                    <div class="flex-1 space-y-1 overflow-y-auto p-2">
                        @foreach ($cefrModules as $module)
                            <button class="{{ $module['active'] ? 'border-primary bg-primary text-white shadow-md' : 'border-transparent hover:bg-surface-container-low' }} group flex w-full items-center gap-3 rounded-lg border p-4 text-left transition-all">
                                <div class="{{ $module['active'] ? 'bg-white/10' : 'bg-surface-container-high text-on-surface-variant group-hover:bg-white' }} flex h-10 w-10 items-center justify-center rounded-lg transition-all">
                                    <span class="material-symbols-outlined text-[22px]">folder</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="{{ $module['active'] ? 'text-white' : 'text-primary' }} truncate text-sm font-bold">{{ $module['name'] }}</p>
                                    <p class="{{ $module['active'] ? 'text-white/70' : 'text-text-secondary' }} text-[10px]">{{ $module['lessons'] }} Lessons</p>
                                </div>
                                <span class="{{ $module['active'] ? 'text-white/60' : 'text-outline group-hover:text-primary' }} material-symbols-outlined text-[18px] transition-all">more_vert</span>
                            </button>
                        @endforeach
                    </div>
                </aside>

                <div class="col-span-12 flex h-[700px] flex-col overflow-hidden rounded-xl border border-outline-variant bg-white shadow-sm lg:col-span-9">
                    <div class="flex flex-col justify-between gap-4 border-b border-outline-variant bg-surface-bright p-5 md:flex-row md:items-center">
                        <div class="flex flex-wrap items-center gap-4">
                            <h3 class="flex items-center gap-2 text-xl font-bold text-primary">
                                Module 1 (A1)
                                <button class="text-on-surface-variant transition-colors hover:text-primary">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                            </h3>
                            <span class="rounded-full bg-tertiary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-secondary">30 Lessons</span>
                        </div>
                        <button class="flex items-center justify-center gap-2 rounded-xl bg-primary px-5 py-2 text-xs font-bold uppercase tracking-wide text-white shadow-md transition-all hover:opacity-90">
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            Add Lesson
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto">
                        <table class="w-full table-fixed border-collapse text-left">
                            <thead class="sticky top-0 z-10 border-b border-outline-variant bg-surface-container-low">
                                <tr>
                                    <th class="w-14 p-4 text-center text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">#</th>
                                    <th class="w-1/2 p-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Lesson Title</th>
                                    <th class="w-1/4 p-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">PDF File</th>
                                    <th class="w-32 p-4 text-center text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                    <th class="w-40 p-4 pr-6 text-right text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                @foreach ($cefrLessons as $lesson)
                                    <tr class="{{ $lesson['active'] ? 'border-l-4 border-primary bg-surface-container-low/50' : 'hover:bg-surface-container-low' }} group transition-colors">
                                        <td class="p-4 text-center text-sm font-bold text-text-secondary">{{ $lesson['number'] }}</td>
                                        <td class="p-4">
                                            <p class="text-sm font-bold text-primary">{{ $lesson['title'] }}</p>
                                        </td>
                                        <td class="p-4">
                                            <button class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[22px] text-error" style="font-variation-settings: 'FILL' 1;">picture_as_pdf</span>
                                                <span class="text-sm font-bold text-secondary hover:underline">{{ $lesson['file'] }}</span>
                                            </button>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-success/10 px-3 py-1 text-[10px] font-bold uppercase text-success">
                                                <span class="h-1.5 w-1.5 rounded-full bg-success"></span>
                                                {{ $lesson['status'] }}
                                            </span>
                                        </td>
                                        <td class="p-4 pr-6 text-right">
                                            <div class="flex items-center justify-end gap-1 opacity-100 transition-opacity lg:opacity-0 lg:group-hover:opacity-100">
                                                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-on-surface-variant transition-all hover:bg-primary-fixed hover:text-primary" title="Preview">
                                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                                </button>
                                                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-on-surface-variant transition-all hover:bg-secondary-fixed hover:text-secondary" title="Download">
                                                    <span class="material-symbols-outlined text-[20px]">download</span>
                                                </button>
                                                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-on-surface-variant transition-all hover:bg-surface-container-highest hover:text-primary" title="More">
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
                        <p class="text-[12px] font-bold text-text-secondary">Showing 1 to 10 of 30 lessons</p>
                        <div class="flex items-center gap-2">
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-on-surface-variant opacity-30" disabled>
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                            </button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-sm font-bold text-white shadow-sm">1</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-sm font-bold text-on-surface-variant transition-all hover:bg-primary hover:text-white">2</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-sm font-bold text-on-surface-variant transition-all hover:bg-primary hover:text-white">3</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant bg-white text-on-surface-variant transition-all hover:bg-primary hover:text-white">
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
