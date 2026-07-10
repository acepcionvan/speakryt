<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lessons &amp; Programs | SpeakRyt</title>
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
                        'tertiary-fixed': '#c3e8ff',
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
            justify-content: center;
            min-height: 46px;
            border: 1px solid #c4c6cf;
            border-bottom: 0;
            border-radius: 12px 12px 0 0;
            background: #d5e3ff;
            color: #244166;
            padding: 12px 28px;
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
    @include('partials.sidebar', ['activeSection' => 'lessons', 'sidebarClass' => 'hidden lg:flex'])

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
                    <h2 class="text-3xl font-bold text-primary">Lessons &amp; Programs</h2>
                    <p class="mt-1 text-sm text-text-secondary">Manage curriculum levels, modules, and lesson counts across adult and kids programs.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button class="flex h-10 items-center gap-2 rounded-lg border border-secondary bg-white px-5 text-sm font-bold text-secondary transition-colors hover:bg-secondary-fixed">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Export Data
                    </button>
                    <button class="flex h-10 items-center gap-2 rounded-lg bg-primary px-5 text-sm font-bold text-white shadow-md transition-all hover:opacity-90 active:scale-95">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        Create Program
                    </button>
                </div>
            </div>

            <section class="grid grid-cols-1 gap-6 md:grid-cols-4">
                @foreach ($lessonStats as $stat)
                    <div class="flex items-center gap-4 rounded-xl border border-surface-container-high bg-surface-container-lowest p-card-padding shadow-sm">
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

            <section class="overflow-hidden rounded-xl border border-surface-container-high bg-surface-container-lowest shadow-sm">
                <div class="flex flex-col justify-between gap-4 bg-white px-6 py-5 md:flex-row md:items-center">
                    <div>
                        <h3 class="text-lg font-bold text-primary">Program Library</h3>
                        <p class="mt-1 text-sm text-text-secondary">Switch between adult and kids lesson programs.</p>
                    </div>
                </div>
                <div class="folder-tab-strip">
                    <button class="program-tab folder-tab folder-tab-active text-sm font-bold uppercase tracking-wide transition-all" data-program-tab="Adults" type="button">Adults</button>
                    <button class="program-tab folder-tab text-sm font-bold uppercase tracking-wide transition-all hover:bg-white" data-program-tab="Kids" type="button">Kids</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[1050px] w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-surface-container-high">
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Program Name</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Audience</th>
                                <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Levels</th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Modules</th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Lessons</th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">PDFs</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @foreach ($lessonPrograms as $program)
                                <tr class="group transition-colors hover:bg-surface-container-low {{ $program['audience'] === 'Kids' ? 'hidden' : '' }}" data-program-row data-audience="{{ $program['audience'] }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $program['icon_class'] }}">
                                                <span class="material-symbols-outlined">{{ $program['icon'] }}</span>
                                            </div>
                                            @if (isset($program['href']))
                                                <a class="font-bold text-primary transition-colors hover:text-secondary hover:underline" href="{{ $program['href'] }}">{{ $program['name'] }}</a>
                                            @else
                                                <span class="font-bold text-primary">{{ $program['name'] }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-surface-container px-3 py-1 text-[12px] font-semibold text-text-secondary">{{ $program['audience'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-on-surface">{{ $program['levels'] }}</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $program['modules'] }}</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $program['lessons'] }}</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $program['pdfs'] }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 transition-opacity lg:opacity-0 lg:group-hover:opacity-100">
                                            <button class="rounded-lg p-2 text-primary transition-colors hover:bg-primary-fixed" title="Edit">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            @if (isset($program['href']))
                                                <a class="rounded-lg p-2 text-secondary transition-colors hover:bg-secondary-fixed" href="{{ $program['href'] }}" title="View details">
                                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                                </a>
                                            @else
                                                <button class="rounded-lg p-2 text-secondary transition-colors hover:bg-secondary-fixed" title="View details">
                                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between border-t border-outline-variant bg-surface-container-low px-6 py-4">
                    <p class="text-sm text-text-secondary">Showing <span id="visible-program-count">{{ collect($lessonPrograms)->where('audience', 'Adults')->count() }}</span> of <span id="total-program-count">{{ collect($lessonPrograms)->where('audience', 'Adults')->count() }}</span> Programs</p>
                    <div class="flex items-center gap-2">
                        <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant text-text-secondary opacity-50" disabled>
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-sm font-bold text-white">1</button>
                        <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-outline-variant text-text-secondary opacity-50" disabled>
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>

            <section class="flex items-center gap-4 rounded-r-xl border-l-4 border-active-accent bg-[#f0f4f9] p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-active-accent text-active-accent">
                    <span class="material-symbols-outlined font-semibold">info</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-primary">System Notice</p>
                    <p class="text-sm text-primary/90">Each program contains 10 modules by default except CEFR. Each module contains 30 lessons with corresponding PDF files.</p>
                </div>
            </section>
        </div>
    </main>
    <script>
        document.querySelectorAll('[data-program-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                const selectedAudience = tab.dataset.programTab;
                const rows = document.querySelectorAll('[data-program-row]');
                let visibleCount = 0;

                document.querySelectorAll('[data-program-tab]').forEach((button) => {
                    const isActive = button.dataset.programTab === selectedAudience;
                    button.classList.toggle('folder-tab-active', isActive);
                    button.classList.toggle('hover:bg-white', !isActive);
                });

                rows.forEach((row) => {
                    const shouldShow = row.dataset.audience === selectedAudience;
                    row.classList.toggle('hidden', !shouldShow);
                    if (shouldShow) {
                        visibleCount += 1;
                    }
                });

                document.getElementById('visible-program-count').textContent = visibleCount;
                document.getElementById('total-program-count').textContent = visibleCount;
            });
        });
    </script>
</body>
</html>
