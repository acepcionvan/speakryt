<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration | SpeakRyt</title>
    <meta name="description" content="Register for SpeakRyt online English lessons and free assessment.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#152235',
                        softink: '#526174',
                        skyblue: '#53c9f5',
                        leaf: '#9bdc65',
                        lemon: '#f3ff4f',
                        cream: '#fbffef',
                        mist: '#eff9ff',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 24px 70px rgba(83, 201, 245, 0.18)',
                        card: '0 18px 44px rgba(21, 34, 53, 0.08)',
                    },
                },
            },
        };
    </script>
    <style>
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 900; letter-spacing: 0.12em; text-transform: uppercase; color: #526174; }
        .required-mark { color: #dc2626; }
        .field-control { width: 100%; border-radius: 1rem; border-color: #cbd5e1; background: #fff; color: #152235; font-size: 0.95rem; }
        .field-control:focus { border-color: #53c9f5; box-shadow: 0 0 0 4px rgba(83, 201, 245, 0.18); }
        .error-text { margin-top: 0.45rem; font-size: 0.78rem; font-weight: 700; color: #dc2626; }
    </style>
</head>
<body class="bg-white font-sans text-ink antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 lg:px-8">
            <a class="flex items-center gap-3" href="{{ route('website.home') }}" aria-label="SpeakRyt homepage">
                <img class="h-11 w-auto" src="{{ asset('images/website/srlogo.png') }}" alt="SpeakRyt logo">
            </a>
            <div class="flex items-center gap-3">
                <a class="rounded-full border border-slate-300 px-5 py-3 text-sm font-extrabold text-ink transition hover:-translate-y-0.5 hover:border-skyblue hover:text-skyblue" href="{{ route('website.home') }}">Back to Website</a>
                <a class="hidden rounded-full bg-ink px-5 py-3 text-sm font-extrabold text-white shadow-card transition hover:-translate-y-0.5 hover:bg-skyblue sm:inline-flex" href="{{ route('student.login') }}">Student Login</a>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-gradient-to-br from-cream via-mist to-white py-16">
            <div class="mx-auto grid max-w-7xl gap-8 px-5 lg:grid-cols-[0.78fr_1.22fr] lg:px-8">
                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <p class="inline-flex rounded-full bg-white px-5 py-2 text-sm font-black uppercase tracking-[0.18em] text-sky-700 shadow-card">SpeakRyt Registration</p>
                    <h1 class="mt-6 text-4xl font-black tracking-tight text-ink sm:text-5xl">Register for your English learning assessment</h1>
                    <p class="mt-5 text-lg leading-8 text-softink">
                        Please complete this form so our team can understand the learner, recommend the right program, and prepare the student record in the dashboard. Adult students can register using their own contact details.
                    </p>

                    <div class="mt-8 rounded-[2rem] bg-white p-6 shadow-card ring-1 ring-slate-200">
                        <h2 class="text-lg font-black text-ink">What happens next?</h2>
                        <div class="mt-5 space-y-4">
                            @foreach ([
                                'SpeakRyt reviews the student information.',
                                'Our team contacts you through your preferred platform.',
                                'We confirm level, schedule, teacher match, and assessment details.',
                            ] as $step)
                                <div class="flex gap-3">
                                    <span class="mt-1 flex h-6 w-6 flex-none items-center justify-center rounded-full bg-skyblue text-xs font-black text-white">{{ $loop->iteration }}</span>
                                    <p class="text-sm font-semibold leading-6 text-softink">{{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <section class="rounded-[2rem] bg-white p-6 shadow-card ring-1 ring-slate-200 sm:p-8">
                    @if (session('status'))
                        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-bold leading-6 text-green-800">
                            <p>{{ session('status') }}</p>
                            <a class="mt-3 inline-flex rounded-full bg-green-700 px-4 py-2 text-xs font-black uppercase tracking-wider text-white transition hover:bg-ink" href="{{ route('website.registration-pricing') }}">View Recommended Pricing</a>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-bold leading-6 text-red-800">
                            Please check the highlighted fields before submitting.
                        </div>
                    @endif

                    <form class="space-y-8" action="{{ route('website.register.submit') }}" method="POST">
                        @csrf

                        <!-- Student information -->
                        <section>
                            <div class="border-b border-slate-200 pb-4">
                                <h2 class="text-2xl font-black text-ink">Student Information</h2>
                                <p class="mt-1 text-sm font-medium text-softink">Basic learner details for the student profile.</p>
                            </div>
                            <div class="mt-5 grid gap-4 md:grid-cols-2">
                                <label>
                                    <span class="field-label">First Name <span class="required-mark">*</span></span>
                                    <input class="field-control" name="student_first_name" type="text" value="{{ old('student_first_name') }}" placeholder="Example: Maria" required>
                                    @error('student_first_name') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Last Name <span class="required-mark">*</span></span>
                                    <input class="field-control" name="student_last_name" type="text" value="{{ old('student_last_name') }}" placeholder="Example: Santos" required>
                                    @error('student_last_name') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Age <span class="required-mark">*</span></span>
                                    <input class="field-control" name="student_age" type="number" min="3" max="90" value="{{ old('student_age') }}" placeholder="Example: 12" required>
                                    @error('student_age') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Learner Type <span class="required-mark">*</span></span>
                                    <select class="field-control" name="learner_type" required>
                                        @foreach (['Kids', 'Teens', 'Adults', 'University Student', 'Professional'] as $option)
                                            <option value="{{ $option }}" @selected(old('learner_type') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('learner_type') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Current English Level <span class="required-mark">*</span></span>
                                    <select class="field-control" name="english_level" required>
                                        @foreach (['Not sure', 'Beginner', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $option)
                                            <option value="{{ $option }}" @selected(old('english_level', 'Not sure') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('english_level') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Program Interest <span class="required-mark">*</span></span>
                                    <select class="field-control" name="program_interest" required>
                                        @foreach (['Kids English', 'Teen English', 'Adult English', 'Business English', 'IELTS / TOEFL Preparation', 'Job Interview English', 'Travel and Conversation English', 'Not sure yet'] as $option)
                                            <option value="{{ $option }}" @selected(old('program_interest') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('program_interest') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                            </div>
                        </section>

                        <!-- Student dashboard account -->
                        <section>
                            <div class="border-b border-slate-200 pb-4">
                                <h2 class="text-2xl font-black text-ink">Student Dashboard Account</h2>
                                <p class="mt-1 text-sm font-medium text-softink">Create the login details the student will use later to access lessons, feedback, packages, and schedules.</p>
                            </div>
                            <div class="mt-5 grid gap-4 md:grid-cols-2">
                                <label>
                                    <span class="field-label">Username <span class="required-mark">*</span></span>
                                    <input class="field-control" name="username" type="text" value="{{ old('username') }}" placeholder="Example: maria_santos2026" autocomplete="username" required>
                                    <p class="mt-2 text-xs font-semibold leading-5 text-softink">Use letters, numbers, dashes, or underscores. Minimum 4 characters.</p>
                                    @error('username') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <div class="rounded-2xl border border-skyblue/20 bg-mist p-4">
                                    <p class="text-sm font-black text-ink">Account Note</p>
                                    <p class="mt-2 text-sm font-semibold leading-6 text-softink">The email address below will also be used for important account and lesson notifications.</p>
                                </div>
                                <label>
                                    <span class="field-label">Password <span class="required-mark">*</span></span>
                                    <input class="field-control" name="password" type="password" autocomplete="new-password" placeholder="Minimum 8 characters" required>
                                    @error('password') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Confirm Password <span class="required-mark">*</span></span>
                                    <input class="field-control" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Re-type password" required>
                                </label>
                            </div>
                        </section>

                        <!-- Contact and location -->
                        <section>
                            <div class="border-b border-slate-200 pb-4">
                                <h2 class="text-2xl font-black text-ink">Contact & Location</h2>
                                <p class="mt-1 text-sm font-medium text-softink">Student contact details are required. Parent or guardian details are only needed for kids or teens.</p>
                            </div>
                            <div class="mt-5 grid gap-4 md:grid-cols-2">
                                <label>
                                    <span class="field-label">Parent / Guardian Name</span>
                                    <input class="field-control" name="parent_name" type="text" value="{{ old('parent_name') }}" placeholder="Example: Anna Santos, or leave blank for adult students">
                                    @error('parent_name') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Student Email Address <span class="required-mark">*</span></span>
                                    <input class="field-control" name="email" type="email" value="{{ old('email') }}" placeholder="Example: maria@email.com" required>
                                    @error('email') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Student Mobile / Contact Number <span class="required-mark">*</span></span>
                                    <input class="field-control" name="phone" type="text" value="{{ old('phone') }}" placeholder="Example: +86 138 1234 5678" required>
                                    @error('phone') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Preferred Contact <span class="required-mark">*</span></span>
                                    <select class="field-control" name="preferred_contact" required>
                                        @foreach (['WhatsApp', 'WeChat', 'Email', 'Phone', 'Facebook'] as $option)
                                            <option value="{{ $option }}" @selected(old('preferred_contact') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('preferred_contact') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Student WhatsApp ID / Number</span>
                                    <input class="field-control" name="whatsapp" type="text" value="{{ old('whatsapp') }}" placeholder="Example: +971 50 123 4567">
                                    @error('whatsapp') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Student WeChat ID</span>
                                    <input class="field-control" name="wechat" type="text" value="{{ old('wechat') }}" placeholder="Example: maria_english88">
                                    <p class="mt-2 text-xs font-semibold leading-5 text-softink">If the student is based in China and chooses WeChat, the mobile number should start with +86 or 0086.</p>
                                    @error('wechat') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">Country <span class="required-mark">*</span></span>
                                    <select id="country-select" class="field-control" name="country" required>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}" @selected(old('country') === $country)>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                    @error('country') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <label>
                                    <span class="field-label">City</span>
                                    <input class="field-control" name="city" type="text" value="{{ old('city') }}" placeholder="Example: Shanghai, Dubai, Tokyo">
                                    @error('city') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                                <div class="md:col-span-2 rounded-2xl border border-skyblue/20 bg-mist p-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-black text-ink">Detected Location</p>
                                            <p id="detected-location-label" class="mt-1 text-sm font-semibold leading-6 text-softink">Checking visitor country...</p>
                                        </div>
                                        <span id="detected-location-badge" class="w-fit rounded-full bg-white px-3 py-1 text-xs font-black uppercase tracking-wider text-softink">Automatic</span>
                                    </div>
                                    <p class="mt-3 text-xs font-semibold leading-5 text-softink">This helps SpeakRyt verify registration eligibility and schedule support. If detection is unavailable, your selected country will still be used.</p>
                                </div>
                                <input id="detected-country" name="detected_country" type="hidden" value="{{ old('detected_country') }}">
                                <input id="detected-country-code" name="detected_country_code" type="hidden" value="{{ old('detected_country_code') }}">
                                <input id="detected-timezone" name="detected_timezone" type="hidden" value="{{ old('detected_timezone') }}">
                                <input id="detected-locale" name="detected_locale" type="hidden" value="{{ old('detected_locale') }}">
                            </div>
                        </section>

                        <!-- Learning goals and schedule -->
                        <section>
                            <div class="border-b border-slate-200 pb-4">
                                <h2 class="text-2xl font-black text-ink">Learning Goals & Schedule</h2>
                                <p class="mt-1 text-sm font-medium text-softink">This helps SpeakRyt recommend a teacher, lesson type, and available class time.</p>
                            </div>
                            <div class="mt-5 grid gap-4">
                                <label>
                                    <span class="field-label">Main Learning Goal <span class="required-mark">*</span></span>
                                    <textarea class="field-control min-h-[130px]" name="learning_goal" required placeholder="Example: I want to improve speaking confidence for school presentations and daily conversation.">{{ old('learning_goal') }}</textarea>
                                    @error('learning_goal') <p class="error-text">{{ $message }}</p> @enderror
                                </label>

                                <div>
                                    <span class="field-label">Preferred Lesson Days <span class="required-mark">*</span></span>
                                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                            <label class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-mist/50 px-4 py-3 text-sm font-bold text-ink">
                                                <input class="rounded border-slate-300 text-skyblue focus:ring-skyblue/20" name="preferred_days[]" type="checkbox" value="{{ $day }}" @checked(in_array($day, old('preferred_days', []), true))>
                                                {{ $day }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('preferred_days') <p class="error-text">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <label>
                                        <span class="field-label">Preferred Time <span class="required-mark">*</span></span>
                                        <input class="field-control" name="preferred_time" type="text" value="{{ old('preferred_time') }}" placeholder="Example: Weekdays after 7:00 PM" required>
                                        @error('preferred_time') <p class="error-text">{{ $message }}</p> @enderror
                                    </label>
                                    <label>
                                        <span class="field-label">Preferred Lesson Duration <span class="required-mark">*</span></span>
                                        <select class="field-control" name="lesson_duration" required>
                                            @foreach (['25 minutes', '50 minutes', 'Not sure'] as $option)
                                                <option value="{{ $option }}" @selected(old('lesson_duration') === $option)>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('lesson_duration') <p class="error-text">{{ $message }}</p> @enderror
                                    </label>
                                </div>

                                <label>
                                    <span class="field-label">Teacher Preference</span>
                                    <textarea class="field-control min-h-[100px]" name="teacher_preference" placeholder="Example: Patient teacher for kids, business English teacher, or no preference.">{{ old('teacher_preference') }}</textarea>
                                    @error('teacher_preference') <p class="error-text">{{ $message }}</p> @enderror
                                </label>

                                <label>
                                    <span class="field-label">Additional Notes</span>
                                    <textarea class="field-control min-h-[110px]" name="notes" placeholder="Example: The student is shy at first, preparing for IELTS in December, or wants a free assessment first.">{{ old('notes') }}</textarea>
                                    @error('notes') <p class="error-text">{{ $message }}</p> @enderror
                                </label>
                            </div>
                        </section>

                        <section class="rounded-[1.5rem] border border-slate-200 bg-cream p-5">
                            <label class="flex gap-3">
                                <input class="mt-1 rounded border-slate-300 text-skyblue focus:ring-skyblue/20" name="privacy_consent" type="checkbox" value="1" @checked(old('privacy_consent')) required>
                                <span class="text-sm font-semibold leading-6 text-softink">
                                    <span class="required-mark">*</span> I confirm that the information provided is accurate, and I allow SpeakRyt to contact me about assessment, scheduling, lessons, and registration.
                                </span>
                            </label>
                            @error('privacy_consent') <p class="error-text">{{ $message }}</p> @enderror
                        </section>

                        <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm font-semibold leading-6 text-softink">Sensitive contact information should remain admin-controlled inside the dashboard.</p>
                            <button class="inline-flex items-center justify-center rounded-full bg-ink px-8 py-4 text-base font-black text-white shadow-card transition hover:-translate-y-1 hover:bg-skyblue" type="submit">
                                Submit Registration
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </section>
    </main>
    <script>
        const detectedCountry = document.getElementById('detected-country');
        const detectedCountryCode = document.getElementById('detected-country-code');
        const detectedTimezone = document.getElementById('detected-timezone');
        const detectedLocale = document.getElementById('detected-locale');
        const detectedLocationLabel = document.getElementById('detected-location-label');
        const detectedLocationBadge = document.getElementById('detected-location-badge');
        const countrySelect = document.getElementById('country-select');

        function setDetectedLocationLabel(country, code, source) {
            if (!country && !code) {
                detectedLocationLabel.textContent = 'Location could not be detected automatically.';
                detectedLocationBadge.textContent = 'Manual';
                return;
            }

            detectedLocationLabel.textContent = `${country || 'Unknown country'}${code ? ` (${code})` : ''}`;
            detectedLocationBadge.textContent = source;
        }

        function applyCountryIfAvailable(country) {
            if (!country || countrySelect.dataset.userChanged === 'true') return;

            const matchingOption = Array.from(countrySelect.options).find((option) => option.value.toLowerCase() === country.toLowerCase());
            if (matchingOption) {
                countrySelect.value = matchingOption.value;
            }
        }

        countrySelect.addEventListener('change', () => {
            countrySelect.dataset.userChanged = 'true';
        });

        detectedTimezone.value = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
        detectedLocale.value = navigator.language || '';

        fetch('https://ipapi.co/json/')
            .then((response) => response.ok ? response.json() : Promise.reject())
            .then((data) => {
                const countryName = data.country_name || '';
                const countryCode = data.country_code || '';

                detectedCountry.value = countryName;
                detectedCountryCode.value = countryCode;
                if (!detectedTimezone.value && data.timezone) {
                    detectedTimezone.value = data.timezone;
                }

                applyCountryIfAvailable(countryName);
                setDetectedLocationLabel(countryName, countryCode, 'IP');
            })
            .catch(() => {
                const localeRegion = (navigator.language || '').split('-')[1] || '';
                detectedCountryCode.value = localeRegion;
                setDetectedLocationLabel('', localeRegion, 'Browser');
            });
    </script>
</body>
</html>
