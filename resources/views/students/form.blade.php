<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $mode === 'edit' ? 'Edit Student' : 'Add Student' }} | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
        .required-dot { color: #dc2626; }
    </style>
</head>
<body class="flex min-h-screen bg-gray-50 font-sans text-slate-900">
    @include('partials.sidebar', ['activeSection' => 'students', 'sidebarClass' => 'hidden lg:flex'])

    @php
        $isEdit = $mode === 'edit';
        $teacherId = old('teacher_id', $student['teacher_id'] ?? '');
        $selectedPackage = old('package', $isEdit ? 'Adult Silver - 15 lessons' : '');
        $selectedStatus = old('status', $student['status'] ?? 'Pending');
    @endphp

    <main class="flex min-h-screen flex-1 flex-col">
        <header class="flex min-h-16 flex-wrap items-center justify-between gap-4 bg-header-blue px-8 py-4 text-white">
            <div>
                <h1 class="text-2xl font-bold">{{ $isEdit ? 'Edit Student Account' : 'Create Student Account' }}</h1>
                <p class="text-sm opacity-90">Admin-only setup for student login, package, teacher assignment, and contact record.</p>
            </div>
            <x-back-button :href="route('students.index')" label="Back to Students" />
        </header>

        <section class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-[1180px]">
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        Please complete the required fields marked with a red asterisk.
                    </div>
                @endif

                <form class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]" action="{{ $isEdit ? route('students.update', ['student' => $student['id']]) : route('students.store') }}" method="POST">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="space-y-5">
                        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="mb-5 flex items-center gap-3">
                                <span class="material-symbols-outlined rounded-lg bg-blue-50 p-2 text-header-blue">lock_person</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-primary">Student Login</h2>
                                    <p class="text-xs text-slate-500">This is the account the student will use at /students/login.</p>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Student Full Name <span class="required-dot">*</span></span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="name" value="{{ old('name', $student['name'] ?? '') }}" placeholder="Example: Mira Chen" required>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Login Email / Username <span class="required-dot">*</span></span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="email" type="email" value="{{ old('email', $student['email'] ?? '') }}" placeholder="student@email.com" required>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Temporary Password {{ $isEdit ? '' : '*' }}</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="temporary_password" type="text" placeholder="Minimum 8 characters" {{ $isEdit ? '' : 'required' }}>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Account Status <span class="required-dot">*</span></span>
                                    <select class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="status" required>
                                        @foreach (['Pending', 'Active', 'Disabled'] as $status)
                                            <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="mb-5 flex items-center gap-3">
                                <span class="material-symbols-outlined rounded-lg bg-cyan-50 p-2 text-cyan-700">school</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-primary">Learner Details</h2>
                                    <p class="text-xs text-slate-500">Use this to avoid confusion when assigning lessons and teachers.</p>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-3">
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Category <span class="required-dot">*</span></span>
                                    <select class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="category" required>
                                        <option value="">Choose one</option>
                                        <option value="KIDS" @selected(old('category', $student['category'] ?? '') === 'KIDS')>KIDS</option>
                                        <option value="ADULTS" @selected(old('category', $student['category'] ?? '') === 'ADULTS')>ADULTS</option>
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Country <span class="required-dot">*</span></span>
                                    <select class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="country" required>
                                        <option value="">Select country</option>
                                        @foreach ($countryOptions as $country)
                                            <option value="{{ $country }}" @selected(old('country', $student['country'] ?? '') === $country)>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">City</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="city" value="{{ old('city', $student['city'] ?? '') }}" placeholder="Example: Shanghai">
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">English Level <span class="required-dot">*</span></span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="level" value="{{ old('level', $student['level'] ?? '') }}" placeholder="Example: A2, B1, IELTS 6.0" required>
                                </label>
                                <label class="block md:col-span-2">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Assigned Teacher <span class="required-dot">*</span></span>
                                    <select class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="teacher_id" required>
                                        <option value="">Assign teacher</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher['id'] }}" @selected($teacherId === $teacher['id'])>{{ $teacher['name'] }} - {{ $teacher['specialty'] }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="mb-5 flex items-center gap-3">
                                <span class="material-symbols-outlined rounded-lg bg-amber-50 p-2 text-amber-600">contact_phone</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-primary">Contact Information</h2>
                                    <p class="text-xs text-slate-500">Guardian details are optional for adult students.</p>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Mobile / Contact Number <span class="required-dot">*</span></span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="phone" value="{{ old('phone', $student['phone'] ?? '') }}" placeholder="Example: +86 138 0000 0000" required>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">WhatsApp</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Example: +971 50 000 0000">
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">WeChat ID</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="wechat" value="{{ old('wechat', $student['wechat'] ?? '') }}" placeholder="Example: mira_english">
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Guardian Name</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="guardian_name" value="{{ old('guardian_name') }}" placeholder="Only if student is a minor">
                                </label>
                                <label class="block md:col-span-2">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Guardian Contact</span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="guardian_contact" value="{{ old('guardian_contact') }}" placeholder="Phone, WhatsApp, WeChat, or email">
                                </label>
                            </div>
                        </div>
                    </div>

                    <aside class="space-y-5">
                        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h2 class="text-base font-extrabold text-primary">Package & Access</h2>
                            <div class="mt-4 space-y-4">
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Package <span class="required-dot">*</span></span>
                                    <select class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="package" required>
                                        <option value="">Choose package</option>
                                        @foreach ($packageOptions as $package)
                                            <option value="{{ $package }}" @selected($selectedPackage === $package)>{{ $package }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Remaining Lessons <span class="required-dot">*</span></span>
                                    <input class="w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="remaining_lessons" type="number" min="0" max="500" value="{{ old('remaining_lessons', $isEdit ? 8 : 0) }}" required>
                                </label>
                                <label class="block">
                                    <span class="mb-1.5 block text-xs font-bold text-slate-600">Admin Notes</span>
                                    <textarea class="min-h-32 w-full rounded-lg border-slate-200 text-sm focus:border-header-blue focus:ring-header-blue/20" name="admin_notes" placeholder="Internal notes only. Do not show this to students.">{{ old('admin_notes') }}</textarea>
                                </label>
                            </div>
                        </div>

                        <div class="rounded-xl border border-cyan-200 bg-cyan-50 p-5 text-sm text-cyan-900 shadow-sm">
                            <p class="font-extrabold">Access reminder</p>
                            <p class="mt-2 leading-6">Students log in only through the student portal. Admins, teachers, staff, and managers use the team portal.</p>
                        </div>

                        <button class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-5 py-4 text-sm font-extrabold text-white shadow-lg transition hover:bg-secondary" type="submit">
                            <span class="material-symbols-outlined text-[20px]">{{ $isEdit ? 'save' : 'person_add' }}</span>
                            {{ $isEdit ? 'Save Student Changes' : 'Create Student Account' }}
                        </button>
                    </aside>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
