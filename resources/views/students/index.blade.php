<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Directory | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#022448',
                        secondary: '#006397',
                        'header-blue': '#3498db',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-high': '#e6e8ea',
                        'text-secondary': '#666666',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-gray-50 font-sans text-slate-900">
    @include('partials.sidebar', ['activeSection' => 'students', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-header-blue px-8 text-white">
            <div>
                <h1 class="text-2xl font-bold">Student Directory</h1>
                <p class="text-sm opacity-90">Manage student profiles, package status, and assigned teachers.</p>
            </div>
            <a class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold shadow-sm hover:bg-primary/90" href="{{ route('students.create') }}">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Add Student
            </a>
        </header>

        <section class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-[1400px]">
                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-800 shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-5 grid gap-4 md:grid-cols-3">
                    <a class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md" href="{{ route('students.create') }}">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined rounded-lg bg-cyan-50 p-2 text-header-blue">person_add</span>
                            <div>
                                <p class="text-sm font-bold text-primary">Create Student Account</p>
                                <p class="mt-1 text-xs leading-5 text-slate-500">Add login email, temporary password, country, category, teacher, and starting package.</p>
                            </div>
                        </div>
                    </a>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined rounded-lg bg-white p-2 text-amber-600">manage_accounts</span>
                            <div>
                                <p class="text-sm font-bold text-amber-900">Account Controls</p>
                                <p class="mt-1 text-xs leading-5 text-amber-700">Reset passwords, disable inactive accounts, and keep student access separate from team access.</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined rounded-lg bg-white p-2 text-indigo-600">inventory</span>
                            <div>
                                <p class="text-sm font-bold text-indigo-900">Package Tracking</p>
                                <p class="mt-1 text-xs leading-5 text-indigo-700">Assign plans, record remaining lesson credits, and keep Kids/Adults labels visible.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 grid gap-4 xl:grid-cols-[minmax(0,1fr)_auto] xl:items-start">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400">search</span>
                        <input id="student-search-filter" class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm shadow-sm focus:border-header-blue focus:ring-header-blue/20" placeholder="Search student name, ID, country, or teacher">
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="student-quick-filter rounded-lg border border-slate-200 bg-primary px-4 py-3 text-xs font-bold uppercase tracking-wider text-white shadow-sm" data-filter-type="all" data-filter-value="all" type="button">All Students</button>
                        <button class="student-quick-filter rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-xs font-bold uppercase tracking-wider text-cyan-700" data-filter-type="category" data-filter-value="KIDS" type="button">Kids</button>
                        <button class="student-quick-filter rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3 text-xs font-bold uppercase tracking-wider text-indigo-700" data-filter-type="category" data-filter-value="ADULTS" type="button">Adults</button>
                        <button class="student-quick-filter rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs font-bold uppercase tracking-wider text-amber-700" data-filter-type="status" data-filter-value="Renewal Due" type="button">Renewal Due</button>
                        <button class="student-quick-filter rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs font-bold uppercase tracking-wider text-red-700" data-filter-type="status" data-filter-value="Low Balance" type="button">Low Balance</button>
                    </div>
                </div>

                <div class="mb-5 grid gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500" for="student-category-filter">Category</label>
                        <select id="student-category-filter" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-primary focus:border-header-blue focus:ring-header-blue/20">
                            <option value="">All Categories</option>
                            <option value="KIDS">KIDS</option>
                            <option value="ADULTS">ADULTS</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500" for="student-country-filter">Country</label>
                        <select id="student-country-filter" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-primary focus:border-header-blue focus:ring-header-blue/20">
                            <option value="">All Countries</option>
                            @foreach ($countryOptions as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500" for="student-teacher-filter">Assigned Teacher</label>
                        <select id="student-teacher-filter" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-primary focus:border-header-blue focus:ring-header-blue/20">
                            <option value="">All Teachers</option>
                            @foreach (collect($students)->pluck('teacher')->unique()->sort()->values() as $teacher)
                                <option value="{{ $teacher }}">{{ $teacher }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1180px] w-full text-left">
                            <thead class="bg-surface-container-high">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Student ID</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Student Name</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Login Email</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Category</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Country</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Level</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Assigned Teacher</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Package</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Remaining</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Admin Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($students as $student)
                                    @php
                                        $profile = $studentProfiles[$student['id']] ?? null;
                                    @endphp
                                    <tr class="student-row hover:bg-slate-50" data-search="{{ Str::lower($student['id'].' '.$student['name'].' '.$student['country'].' '.$student['teacher'].' '.$student['category'].' '.$student['status']) }}" data-category="{{ $student['category'] }}" data-country="{{ $student['country'] }}" data-teacher="{{ $student['teacher'] }}" data-status="{{ $student['status'] }}">
                                        <td class="px-6 py-4">
                                            <a class="text-sm font-bold text-secondary hover:underline" href="{{ route('students.show', ['student' => $student['id']]) }}">{{ $student['id'] }}</a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a class="text-sm font-bold text-primary hover:text-secondary" href="{{ route('students.show', ['student' => $student['id']]) }}">{{ $student['name'] }}</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $profile['email'] ?? 'Not set' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $student['category_class'] }}">{{ $student['category'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student['country'] }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-primary">{{ $student['level'] }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student['teacher'] }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student['package'] }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-primary">{{ $student['remaining'] }} lessons</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $student['status_class'] }}">{{ $student['status'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-primary hover:border-header-blue hover:text-header-blue" href="{{ route('students.edit', ['student' => $student['id']]) }}">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                    Edit
                                                </a>
                                                <form action="{{ route('students.reset-password', ['student' => $student['id']]) }}" method="POST">
                                                    @csrf
                                                    <input name="temporary_password" type="hidden" value="SpeakRyt{{ now()->format('md') }}!">
                                                    <button class="inline-flex items-center gap-1 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100" type="submit">
                                                        <span class="material-symbols-outlined text-[16px]">key</span>
                                                        Reset
                                                    </button>
                                                </form>
                                                <form action="{{ route('students.status', ['student' => $student['id']]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input name="status" type="hidden" value="{{ $student['status'] === 'Active' ? 'Disabled' : 'Active' }}">
                                                    <button class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100" type="submit">
                                                        <span class="material-symbols-outlined text-[16px]">{{ $student['status'] === 'Active' ? 'block' : 'check_circle' }}</span>
                                                        {{ $student['status'] === 'Active' ? 'Disable' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="student-empty-state" class="hidden">
                                    <td class="px-6 py-10 text-center text-sm font-semibold text-slate-500" colspan="11">No students match the selected filters.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        (() => {
            const searchInput = document.getElementById('student-search-filter');
            const categoryFilter = document.getElementById('student-category-filter');
            const countryFilter = document.getElementById('student-country-filter');
            const teacherFilter = document.getElementById('student-teacher-filter');
            const rows = Array.from(document.querySelectorAll('.student-row'));
            const emptyState = document.getElementById('student-empty-state');
            const quickFilters = Array.from(document.querySelectorAll('.student-quick-filter'));
            let quickStatus = '';

            const setQuickFilterStyle = (activeButton) => {
                quickFilters.forEach((button) => {
                    const active = button === activeButton;
                    button.classList.toggle('bg-primary', active);
                    button.classList.toggle('text-white', active);
                    button.classList.toggle('shadow-sm', active);
                });
            };

            const applyFilters = () => {
                const search = searchInput.value.trim().toLowerCase();
                const category = categoryFilter.value;
                const country = countryFilter.value;
                const teacher = teacherFilter.value;
                let visibleCount = 0;

                rows.forEach((row) => {
                    const visible = (!search || row.dataset.search.includes(search))
                        && (!category || row.dataset.category === category)
                        && (!country || row.dataset.country === country)
                        && (!teacher || row.dataset.teacher === teacher)
                        && (!quickStatus || row.dataset.status === quickStatus);

                    row.classList.toggle('hidden', !visible);
                    if (visible) visibleCount += 1;
                });

                emptyState.classList.toggle('hidden', visibleCount > 0);
            };

            quickFilters.forEach((button) => {
                button.addEventListener('click', () => {
                    setQuickFilterStyle(button);

                    if (button.dataset.filterType === 'all') {
                        searchInput.value = '';
                        categoryFilter.value = '';
                        countryFilter.value = '';
                        teacherFilter.value = '';
                        quickStatus = '';
                    }

                    if (button.dataset.filterType === 'category') {
                        categoryFilter.value = button.dataset.filterValue;
                        quickStatus = '';
                    }

                    if (button.dataset.filterType === 'status') {
                        quickStatus = button.dataset.filterValue;
                    }

                    applyFilters();
                });
            });

            [searchInput, categoryFilter, countryFilter, teacherFilter].forEach((input) => {
                input.addEventListener('input', () => {
                    setQuickFilterStyle(null);
                    quickStatus = '';
                    applyFilters();
                });
                input.addEventListener('change', () => {
                    setQuickFilterStyle(null);
                    quickStatus = '';
                    applyFilters();
                });
            });
        })();
    </script>
</body>
</html>
