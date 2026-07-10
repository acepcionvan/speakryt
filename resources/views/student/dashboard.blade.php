<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My SpeakRyt Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        mist: '#eff9ff',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 18px 44px rgba(21, 34, 53, 0.08)',
                        glow: '0 24px 70px rgba(83, 201, 245, 0.18)',
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-[#f5f9fc] font-sans text-ink antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 lg:px-8">
            <a class="flex items-center gap-3" href="{{ route('website.home') }}">
                <img class="h-10 w-auto" src="{{ asset('images/website/srlogo.png') }}" alt="SpeakRyt logo">
            </a>

            <div class="flex items-center gap-3">
                <a class="hidden rounded-full border border-slate-300 px-4 py-2 text-sm font-extrabold text-ink transition hover:border-skyblue hover:text-skyblue sm:inline-flex" href="{{ route('website.home') }}">Website</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="rounded-full bg-ink px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-skyblue" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8">
        <section class="overflow-hidden rounded-[2rem] bg-white shadow-card">
            <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="bg-gradient-to-br from-mist via-white to-lemon/20 p-8 lg:p-10">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Student Dashboard</p>
                    <h1 class="mt-4 text-4xl font-black tracking-tight text-ink sm:text-5xl">Welcome back, {{ $student['name'] }}</h1>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-softink">View your own lessons, package credits, teacher details, and learning progress in one place.</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl bg-white p-5 shadow-sm">
                            <p class="text-sm font-bold text-softink">Level</p>
                            <p class="mt-2 text-3xl font-black text-ink">{{ $student['level'] }}</p>
                        </div>
                        <div class="rounded-2xl bg-white p-5 shadow-sm">
                            <p class="text-sm font-bold text-softink">Remaining Lessons</p>
                            <p class="mt-2 text-3xl font-black text-skyblue">{{ $package['remaining'] }}</p>
                        </div>
                        <div class="rounded-2xl bg-white p-5 shadow-sm">
                            <p class="text-sm font-bold text-softink">Student Type</p>
                            <p class="mt-2 text-3xl font-black text-ink">{{ $student['category'] }}</p>
                        </div>
                    </div>
                </div>

                <aside class="border-t border-slate-200 bg-ink p-8 text-white lg:border-l lg:border-t-0 lg:p-10">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-sky-200">My Teacher</p>
                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-xl font-black text-ink">{{ $student['teacher_initials'] }}</div>
                        <div>
                            <p class="text-2xl font-black">{{ $student['teacher'] }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-300">Assigned SpeakRyt Teacher</p>
                        </div>
                    </div>

                    <div class="mt-8 rounded-2xl bg-white/10 p-5">
                        <p class="text-sm font-bold text-slate-200">Current Package</p>
                        <p class="mt-2 text-xl font-black">{{ $package['name'] }}</p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">{{ $package['renewal_note'] }}</p>
                    </div>

                    <a class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-skyblue px-5 py-3 text-sm font-black text-white transition hover:bg-white hover:text-ink" href="#student-packages">Buy More Lessons</a>
                </aside>
            </div>
        </section>

        @if (session('status'))
            <div class="mt-8 rounded-[1.5rem] border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold leading-6 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-8 rounded-[1.5rem] border border-red-200 bg-red-50 px-6 py-4 text-sm font-bold leading-6 text-red-800">
                Please choose one of the available packages in your student dashboard.
            </div>
        @endif

        <section id="student-packages" class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.85fr]">
            <div class="rounded-[2rem] bg-white p-6 shadow-card">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">My Packages</p>
                        <h2 class="mt-2 text-2xl font-black text-ink">Available Plans for {{ $pricingCountry }}</h2>
                        <p class="mt-2 max-w-2xl text-sm font-semibold leading-6 text-softink">These plans match your registered country and student type, so you do not need to register again to view package options.</p>
                    </div>
                    <span class="w-fit rounded-full {{ $pricingCategory === 'Kids English' ? 'bg-yellow-100 text-yellow-800' : 'bg-indigo-50 text-indigo-700' }} px-4 py-2 text-xs font-black uppercase tracking-wider">{{ $pricingCategory }}</span>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($availablePlans as $plan)
                        <article class="rounded-[1.5rem] border {{ $pricingCategory === 'Kids English' ? 'border-yellow-200 bg-yellow-50/80' : 'border-slate-200 bg-white' }} p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-glow">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-wider text-softink">{{ $plan['lessons'] }} lessons</p>
                                    <h3 class="mt-1 text-2xl font-black text-ink">{{ $plan['tier'] }}</h3>
                                </div>
                                @if ($plan['discount'] !== '-')
                                    <span class="rounded-full bg-leaf/20 px-3 py-1 text-xs font-black text-green-700">{{ $plan['discount'] }}</span>
                                @endif
                            </div>
                            <p class="mt-4 text-4xl font-black text-skyblue">{{ $plan['price'] }}</p>
                            <p class="mt-2 text-sm font-bold text-softink">{{ $plan['duration'] }} per lesson</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-softink">{{ $plan['validity'] }}</p>

                            <div class="mt-5 grid gap-2">
                                @foreach (['PayPal', 'Debit/Credit Card via PayPal'] as $paymentMethod)
                                    <form action="{{ route('student.packages.purchase') }}" method="POST">
                                        @csrf
                                        <input name="tier" type="hidden" value="{{ $plan['tier'] }}">
                                        <input name="payment_method" type="hidden" value="{{ $paymentMethod }}">
                                        <button class="w-full rounded-full border px-4 py-3 text-xs font-black uppercase tracking-wider transition hover:-translate-y-0.5 {{ $paymentMethod === 'PayPal' ? 'border-skyblue/40 bg-skyblue/15 text-sky-800 hover:bg-skyblue/25' : 'border-leaf/50 bg-leaf/20 text-green-800 hover:bg-leaf/30' }}" type="submit">
                                            {{ $paymentMethod === 'PayPal' ? 'Pay with PayPal' : 'Debit/Credit Card via PayPal' }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                @if ($purchaseIntent)
                    <div class="rounded-[2rem] border border-skyblue/30 bg-white p-6 shadow-card">
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Checkout Summary</p>
                        <h2 class="mt-2 text-2xl font-black text-ink">{{ $purchaseIntent['tier'] }} · {{ $purchaseIntent['category'] }}</h2>
                        <p class="mt-2 text-sm font-semibold leading-6 text-softink">{{ $purchaseIntent['lessons'] }} lessons · {{ $purchaseIntent['duration'] }} per lesson · {{ $purchaseIntent['validity'] }}</p>
                        <div class="mt-5 rounded-2xl bg-mist p-5">
                            <p class="text-xs font-black uppercase tracking-wider text-softink">Selected Payment</p>
                            <p class="mt-1 text-lg font-black text-ink">{{ $purchaseIntent['payment_method'] }}</p>
                            <p class="mt-4 text-xs font-black uppercase tracking-wider text-softink">Amount</p>
                            <p class="mt-1 text-4xl font-black text-skyblue">{{ $purchaseIntent['price'] }}</p>
                        </div>
                        <p class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs font-bold leading-5 text-amber-800">Payment gateway connection is ready for setup. PayPal and debit/credit card payments will both be processed through SpeakRyt PayPal.</p>
                    </div>
                @endif

                <div class="rounded-[2rem] bg-white p-6 shadow-card">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Package Records</p>
                    <h2 class="mt-2 text-2xl font-black text-ink">Purchase History</h2>
                    <div class="mt-5 space-y-3">
                        @foreach ($purchaseHistory as $history)
                            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-black text-ink">{{ $history['plan'] }}</p>
                                        <p class="mt-1 text-xs font-semibold text-softink">{{ $history['date'] }} · {{ $history['method'] }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-wider {{ $history['status_class'] }}">{{ $history['status'] }}</span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-3 text-xs font-bold text-softink">
                                    <p>{{ $history['lessons'] }} lessons</p>
                                    <p>{{ $history['duration'] }}</p>
                                    <p>{{ $history['validity'] }}</p>
                                    <p class="text-right text-base font-black text-ink">{{ $history['amount'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-8 grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="rounded-[2rem] bg-white p-6 shadow-card">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Schedule</p>
                        <h2 class="mt-2 text-2xl font-black text-ink">Upcoming Lessons</h2>
                    </div>
                    <span class="rounded-full {{ $package['status_class'] }} px-4 py-2 text-xs font-black uppercase tracking-wider">{{ $package['status'] }}</span>
                </div>

                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-mist text-xs font-black uppercase tracking-wider text-softink">
                            <tr>
                                <th class="px-5 py-4">Date</th>
                                <th class="px-5 py-4">Time</th>
                                <th class="px-5 py-4">Lesson</th>
                                <th class="px-5 py-4">Platform</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($upcomingLessons as $lesson)
                                <tr>
                                    <td class="px-5 py-4 font-bold text-ink">{{ $lesson['date'] }}</td>
                                    <td class="px-5 py-4 text-softink">{{ $lesson['time'] }}</td>
                                    <td class="px-5 py-4">
                                        <a class="font-bold text-ink underline decoration-skyblue/40 underline-offset-4 transition hover:text-skyblue" href="{{ $lesson['topic_pdf_url'] }}" target="_blank">{{ $lesson['topic'] }}</a>
                                        <p class="mt-1 text-xs text-softink">Click topic to view PDF · {{ $lesson['teacher'] }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-softink">{{ $lesson['platform'] }}</td>
                                    <td class="px-5 py-4">
                                        <button class="lesson-entry-button rounded-full bg-amber-50 px-4 py-2 text-xs font-black uppercase tracking-wider text-amber-700 transition disabled:cursor-not-allowed" data-start-at="{{ $lesson['starts_at_iso'] }}" data-meeting-url="{{ $lesson['meeting_url'] }}" type="button" disabled>Pending</button>
                                    </td>
                                    <td class="px-5 py-4">
                                        <button class="reschedule-button rounded-full px-4 py-2 text-xs font-black uppercase tracking-wider transition {{ $lesson['can_reschedule'] ? 'bg-skyblue text-white hover:bg-ink' : 'cursor-not-allowed bg-slate-100 text-slate-400' }}" data-lesson-topic="{{ $lesson['topic'] }}" data-reschedule-note="{{ $lesson['reschedule_note'] }}" type="button" @disabled(! $lesson['can_reschedule'])>Reschedule</button>
                                        <p class="mt-2 text-[11px] font-semibold text-softink">{{ $lesson['reschedule_note'] }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white p-6 shadow-card">
                <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Progress</p>
                <h2 class="mt-2 text-2xl font-black text-ink">Learning Goals</h2>

                <div class="mt-6 space-y-5">
                    @foreach ($learningGoals as $goal)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <p class="font-bold text-ink">{{ $goal['label'] }}</p>
                                <p class="font-black text-skyblue">{{ $goal['progress'] }}%</p>
                            </div>
                            <div class="mt-2 h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-gradient-to-r from-skyblue to-leaf" style="width: {{ $goal['progress'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 rounded-2xl bg-mist p-5">
                    <p class="font-black text-ink">Need help?</p>
                    <p class="mt-2 text-sm leading-6 text-softink">Contact SpeakRyt if you need to reschedule, buy more lessons, or ask about your package.</p>
                </div>
            </div>
        </section>

        <section class="mt-8 rounded-[2rem] bg-white p-6 shadow-card">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">My Records</p>
                    <h2 class="mt-2 text-2xl font-black text-ink">Recent Lesson History</h2>
                </div>
                <p class="text-sm font-semibold text-softink">Only your own lesson records are shown here.</p>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <table class="w-full text-left text-sm">
                    <thead class="bg-mist text-xs font-black uppercase tracking-wider text-softink">
                        <tr>
                            <th class="px-5 py-4">Date</th>
                            <th class="px-5 py-4">Time</th>
                            <th class="px-5 py-4">Lesson Topic</th>
                            <th class="px-5 py-4">Teacher</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">PDF</th>
                            <th class="px-5 py-4">Teacher Feedback</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach (array_slice($recentLessons, 0, 5) as $lesson)
                            <tr>
                                <td class="px-5 py-4 font-bold text-ink">{{ $lesson['date'] }}</td>
                                <td class="px-5 py-4 text-softink">{{ $lesson['time'] }}</td>
                                <td class="px-5 py-4 text-softink">{{ $lesson['lesson'] }}</td>
                                <td class="px-5 py-4 text-softink">{{ $lesson['teacher'] }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-ink">{{ $lesson['status'] }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <a class="font-black text-skyblue hover:text-ink" href="{{ $lesson['topic_pdf_url'] }}" target="_blank">View PDF</a>
                                </td>
                                <td class="px-5 py-4">
                                    <button class="feedback-view-button font-black text-skyblue hover:text-ink" data-feedback='{!! json_encode($lesson['feedback'], JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) !!}' type="button">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div id="feedback-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-ink/60 p-4">
        <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-[2rem] bg-white p-6 shadow-glow">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-skyblue">Teacher Feedback</p>
                    <h3 id="feedback-title" class="mt-2 text-2xl font-black text-ink">Lesson Feedback</h3>
                    <p id="feedback-meta" class="mt-1 text-sm font-semibold text-softink"></p>
                </div>
                <button id="feedback-close" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-xl font-black text-ink transition hover:bg-ink hover:text-white" type="button">×</button>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-mist p-5">
                    <p class="text-sm font-black uppercase tracking-wider text-softink">Vocabulary</p>
                    <p id="feedback-vocabulary" class="mt-3 text-sm leading-7 text-ink"></p>
                </div>
                <div class="rounded-2xl bg-mist p-5">
                    <p class="text-sm font-black uppercase tracking-wider text-softink">Grammar</p>
                    <p id="feedback-grammar" class="mt-3 text-sm leading-7 text-ink"></p>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-slate-200 p-5">
                <p class="text-sm font-black uppercase tracking-wider text-softink">English Feedback</p>
                <p id="feedback-english" class="mt-3 whitespace-pre-line text-sm leading-7 text-ink"></p>
            </div>

            <div class="mt-4 rounded-2xl border border-slate-200 p-5">
                <p class="text-sm font-black uppercase tracking-wider text-softink">Chinese Feedback</p>
                <p id="feedback-chinese" class="mt-3 whitespace-pre-line text-sm leading-7 text-ink"></p>
            </div>
        </div>
    </div>

    <div id="toast" class="fixed bottom-5 left-1/2 z-50 hidden -translate-x-1/2 rounded-full bg-ink px-5 py-3 text-sm font-black text-white shadow-glow"></div>

    <script>
        const entryButtons = Array.from(document.querySelectorAll('.lesson-entry-button'));
        const rescheduleButtons = Array.from(document.querySelectorAll('.reschedule-button'));
        const feedbackButtons = Array.from(document.querySelectorAll('.feedback-view-button'));
        const feedbackModal = document.getElementById('feedback-modal');
        const toast = document.getElementById('toast');

        function showToast(message) {
            if (!toast) return;
            toast.textContent = message;
            toast.classList.remove('hidden');
            window.setTimeout(() => toast.classList.add('hidden'), 2800);
        }

        function refreshLessonEntryButtons() {
            const now = Date.now();

            entryButtons.forEach((button) => {
                const startAt = new Date(button.dataset.startAt).getTime();
                const minutesUntilStart = (startAt - now) / 60000;
                const canEnter = minutesUntilStart <= 3 && minutesUntilStart >= -55;

                button.disabled = !canEnter;
                button.textContent = canEnter ? 'ENTER' : 'Pending';
                button.classList.toggle('bg-skyblue', canEnter);
                button.classList.toggle('text-white', canEnter);
                button.classList.toggle('hover:bg-ink', canEnter);
                button.classList.toggle('bg-amber-50', !canEnter);
                button.classList.toggle('text-amber-700', !canEnter);
            });
        }

        entryButtons.forEach((button) => {
            button.addEventListener('click', () => {
                if (button.disabled) return;
                window.open(button.dataset.meetingUrl, '_blank', 'noopener');
            });
        });

        rescheduleButtons.forEach((button) => {
            button.addEventListener('click', () => {
                showToast(`Reschedule request opened for ${button.dataset.lessonTopic}. Admin will confirm the new time.`);
            });
        });

        feedbackButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const feedback = JSON.parse(button.dataset.feedback || '{}');
                document.getElementById('feedback-title').textContent = feedback.lesson_topic || 'Lesson Feedback';
                document.getElementById('feedback-meta').textContent = `${feedback.teacher_name || 'Teacher'} · ${feedback.date_time || ''} · ${feedback.status || 'Saved'}`;
                document.getElementById('feedback-vocabulary').textContent = feedback.vocabulary_corrections || 'No vocabulary notes saved.';
                document.getElementById('feedback-grammar').textContent = feedback.grammar_corrections || 'No grammar notes saved.';
                document.getElementById('feedback-english').textContent = feedback.english_feedback || 'No English feedback saved.';
                document.getElementById('feedback-chinese').textContent = feedback.chinese_feedback || 'No Chinese feedback saved.';
                feedbackModal.classList.remove('hidden');
                feedbackModal.classList.add('flex');
            });
        });

        document.getElementById('feedback-close')?.addEventListener('click', () => {
            feedbackModal.classList.add('hidden');
            feedbackModal.classList.remove('flex');
        });

        feedbackModal?.addEventListener('click', (event) => {
            if (event.target === feedbackModal) {
                feedbackModal.classList.add('hidden');
                feedbackModal.classList.remove('flex');
            }
        });

        refreshLessonEntryButtons();
        window.setInterval(refreshLessonEntryButtons, 30000);
    </script>
</body>
</html>
