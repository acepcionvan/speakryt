<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Profile - {{ $student['name'] }} | SpeakRyt Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        warning: '#f1c40f',
                        'on-background': '#191c1e',
                        'surface-container-low': '#f2f4f6',
                        'on-secondary': '#ffffff',
                        'sidebar-bg': '#244166',
                        'text-primary': '#333333',
                        tertiary: '#002738',
                        'on-secondary-fixed-variant': '#004b73',
                        primary: '#022448',
                        'on-tertiary': '#ffffff',
                        outline: '#74777f',
                        error: '#e74c3c',
                        background: '#f7f9fb',
                        'surface-dim': '#d8dadc',
                        'on-error': '#ffffff',
                        'tertiary-container': '#003e56',
                        'surface-container-high': '#e6e8ea',
                        'outline-variant': '#c4c6cf',
                        'primary-fixed': '#d5e3ff',
                        'on-tertiary-container': '#00afea',
                        success: '#27ae60',
                        'surface-variant': '#e0e3e5',
                        surface: '#f7f9fb',
                        'active-accent': '#00aeef',
                        'surface-tint': '#455f87',
                        'tertiary-fixed': '#c3e8ff',
                        'surface-bright': '#f7f9fb',
                        'secondary-fixed-dim': '#92ccff',
                        'on-tertiary-fixed-variant': '#004c69',
                        'primary-fixed-dim': '#adc8f5',
                        'on-surface-variant': '#43474e',
                        'error-container': '#ffdad6',
                        'on-primary-fixed-variant': '#2d486d',
                        'inverse-on-surface': '#eff1f3',
                        'inverse-primary': '#adc8f5',
                        'secondary-fixed': '#cce5ff',
                        'on-secondary-container': '#00476e',
                        'on-primary-fixed': '#001c3b',
                        'text-secondary': '#666666',
                        'on-primary-container': '#8aa4cf',
                        'on-tertiary-fixed': '#001e2c',
                        'surface-container-highest': '#e0e3e5',
                        'surface-container-lowest': '#ffffff',
                        'on-secondary-fixed': '#001d31',
                        'inverse-surface': '#2d3133',
                        secondary: '#006397',
                        'tertiary-fixed-dim': '#7ad0ff',
                        'on-error-container': '#93000a',
                        'on-surface': '#191c1e',
                        'on-primary': '#ffffff',
                        'primary-container': '#1e3a5f',
                        'surface-container': '#eceef0',
                        'secondary-container': '#5cb8fd',
                        'header-blue': '#3498db',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '0.75rem',
                    },
                    spacing: {
                        gutter: '24px',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: Inter, sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(36, 65, 102, 0.25); border-radius: 10px; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
        .folder-tab-strip {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-bottom: 1px solid #c4c6cf;
            background: #eef3f8;
            padding: 14px 24px 0;
        }
        .folder-tab {
            display: inline-flex;
            align-items: center;
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
    </style>
</head>
<body class="flex min-h-screen overflow-hidden bg-surface text-on-surface">
    @include('partials.sidebar', ['activeSection' => 'students', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-header-blue px-5 text-white sm:px-8">
            <div class="flex min-w-0 items-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full transition-colors hover:bg-white/10 lg:hidden">
                    <span class="material-symbols-outlined text-white">arrow_back</span>
                </a>
                <div class="hidden h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-md border border-white/20 bg-white/20 text-lg font-bold shadow-sm sm:flex">V</div>
                <div class="min-w-0">
                    <h1 class="truncate text-xl font-bold sm:text-2xl">Welcome back, Van</h1>
                    <p class="text-sm opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="flex h-10 w-10 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-white">search</span>
                </button>
                <button class="flex h-10 w-10 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                    <span class="material-symbols-outlined text-white">notifications</span>
                </button>
            </div>
        </header>

        <div class="custom-scrollbar flex-1 overflow-y-auto p-5 sm:p-gutter">
            <div class="mx-auto max-w-[1200px]">
                <div class="mb-4">
                    <x-back-button :href="route('home')" label="Back to Students" />
                </div>

                <nav class="mb-6 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    <a class="hover:text-header-blue" href="{{ route('home') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <a class="hover:text-header-blue" href="{{ route('home') }}">Students</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <span class="text-header-blue">{{ $student['name'] }}</span>
                </nav>

                <section class="mb-8 overflow-hidden rounded border border-outline-variant/30 bg-surface-container-lowest shadow-sm">
                    <div class="flex flex-col items-center gap-8 p-6 md:flex-row md:items-start md:p-8">
                        <div class="relative">
                            <div class="flex h-32 w-32 items-center justify-center rounded-lg border-4 border-surface-container-low bg-primary text-4xl font-bold text-white">
                                {{ collect(explode(' ', $student['name']))->map(fn ($part) => substr($part, 0, 1))->take(2)->implode('') }}
                            </div>
                            <div class="absolute -bottom-2 -right-2 h-6 w-6 rounded-full border-4 border-surface-container-lowest bg-success"></div>
                        </div>

                        <div class="flex-1">
                            <div class="mb-4 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                                <div>
                                    <h2 class="mb-1 text-3xl font-bold text-primary">{{ $student['name'] }}</h2>
                                    <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-on-surface-variant">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">badge</span>#{{ $student['id'] }}</span>
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm text-success">check_circle</span>{{ $student['status'] }}</span>
                                        <span class="rounded-full border px-2.5 py-0.5 text-[11px] font-bold {{ $student['category_class'] }}">{{ $student['category'] }}</span>
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span>{{ $student['city'] }}, {{ $student['country'] }}</span>
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">trending_up</span>Level: {{ $student['level'] }}</span>
                                    </div>
                                </div>
                                <button class="flex items-center gap-2 rounded bg-primary px-6 py-2.5 font-semibold text-white shadow transition-colors hover:bg-sidebar-bg">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                    Edit Profile
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-6 border-t border-outline-variant/20 pt-4 md:grid-cols-2 lg:grid-cols-5">
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-outline">Email Address</p>
                                    <p class="text-sm font-semibold text-primary">{{ $student['email'] }}</p>
                                </div>
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-outline">Phone / WhatsApp</p>
                                    <p class="text-sm font-semibold text-primary">{{ $student['phone'] }}</p>
                                </div>
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-outline">WeChat ID</p>
                                    <p class="text-sm font-semibold text-primary">{{ $student['wechat'] }}</p>
                                </div>
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-outline">Assigned Teacher</p>
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-5 w-5 items-center justify-center rounded-full bg-secondary-container text-[10px] font-bold text-on-secondary">{{ $student['teacher_initials'] }}</div>
                                        <a href="{{ route('teachers.index') }}" class="text-sm font-semibold text-primary hover:text-header-blue">{{ $student['teacher'] }}</a>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-outline">Country</p>
                                    <p class="text-sm font-semibold text-primary">{{ $student['country'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="overflow-hidden rounded border border-outline-variant/30 bg-surface-container-lowest shadow-sm">
                    <div class="folder-tab-strip">
                        <a href="{{ route('students.show', ['student' => $student['id'], 'tab' => 'payment']) }}" class="folder-tab {{ $activeTab === 'payment' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-widest transition-all">Payment History</a>
                        <a href="{{ route('students.show', ['student' => $student['id'], 'tab' => 'lesson']) }}" class="folder-tab {{ $activeTab === 'lesson' ? 'folder-tab-active' : 'hover:bg-white' }} text-sm font-bold uppercase tracking-widest transition-all">Lesson History</a>
                    </div>

                    <div class="p-4 sm:p-8">
                        @if ($activeTab === 'payment')
                            <div class="custom-scrollbar overflow-x-auto">
                                <table class="w-full border-collapse text-left">
                                    <thead>
                                        <tr class="border-b border-outline-variant/30 bg-surface-container-low">
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Time & Date</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Package Purchased</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Amount (Base)</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Discount (%)</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Amount Paid</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Refund</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-outline">Method</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-outline-variant/10 text-sm">
                                        @foreach ($payments as $payment)
                                            <tr class="transition-colors hover:bg-surface-container-low">
                                                <td class="px-6 py-4">{{ $payment['date'] }} <span class="block text-xs text-outline">{{ $payment['time'] }}</span></td>
                                                <td class="px-6 py-4 font-bold text-header-blue">{{ $payment['package'] }}</td>
                                                <td class="px-6 py-4">{{ $payment['base'] }}</td>
                                                <td class="px-6 py-4 {{ $payment['discount'] !== '0%' ? 'font-bold text-success' : 'text-outline' }}">{{ $payment['discount'] }}</td>
                                                <td class="px-6 py-4 font-bold text-primary">{{ $payment['paid'] }}</td>
                                                <td class="px-6 py-4">
                                                    @if ($payment['refund'])
                                                        <span class="rounded bg-error-container px-2 py-0.5 text-[10px] font-bold uppercase text-on-error-container">Yes</span>
                                                    @else
                                                        <span class="text-outline-variant">No</span>
                                                    @endif
                                                </td>
                                                <td class="flex items-center gap-2 px-6 py-4">
                                                    <span class="material-symbols-outlined text-sm">{{ $payment['icon'] }}</span>
                                                    {{ $payment['method'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="custom-scrollbar overflow-x-auto">
                                <table class="w-full border-collapse text-left">
                                    <thead>
                                        <tr class="border-b border-outline-variant/30 bg-surface-container-low">
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Date</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Time</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Student Name</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Lesson Name</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Teacher</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Status</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Feedback Summary</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-outline">Note (Admin)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lesson-history-body" class="divide-y divide-outline-variant/10 text-xs">
                                        @foreach ($lessons as $lesson)
                                            @php
                                                $lessonStatusClass = $lesson['status'] === 'Completed'
                                                    ? 'bg-success/10 text-success'
                                                    : 'bg-error/10 text-error';
                                                $lessonFeedback = [
                                                    'id' => 'FB-'.$student['id'].'-'.Str::slug($lesson['lesson']),
                                                    'student_id' => $student['id'],
                                                    'student_name' => $student['name'],
                                                    'teacher_id' => $student['teacher_id'],
                                                    'teacher_name' => $lesson['teacher'],
                                                    'date_time' => $lesson['date'].' '.$lesson['time'],
                                                    'lesson_topic' => $lesson['lesson'],
                                                    'vocabulary_corrections' => 'Review the key vocabulary from this lesson and use each new word in a complete sentence.',
                                                    'grammar_corrections' => 'Review the sentence patterns corrected during class and practice answering with complete sentences.',
                                                    'english_feedback' => $student['name'].' worked on '.$lesson['lesson'].'. Please review the vocabulary and grammar corrections before the next lesson.',
                                                    'chinese_feedback' => $student['name'].' 本节课学习了《'.$lesson['lesson'].'》。请在下节课前复习词汇和语法纠正。',
                                                    'status' => 'Saved',
                                                ];
                                            @endphp
                                            <tr class="lesson-history-row transition-colors hover:bg-surface-container-low" data-lesson-topic="{{ $lesson['lesson'] }}">
                                                <td class="px-6 py-4 font-semibold">{{ $lesson['date'] }}</td>
                                                <td class="px-6 py-4">{{ $lesson['time'] }}</td>
                                                <td class="px-6 py-4">{{ $lesson['student'] }}</td>
                                                <td class="px-6 py-4 font-bold text-header-blue">{{ $lesson['lesson'] }}</td>
                                                <td class="px-6 py-4"><a href="{{ route('teachers.index') }}" class="font-semibold text-header-blue hover:underline">{{ $lesson['teacher'] }}</a></td>
                                                <td class="px-6 py-4">
                                                    <span class="{{ $lessonStatusClass }} rounded-full px-2 py-1 text-xs font-bold uppercase tracking-tighter">{{ $lesson['status'] }}</span>
                                                </td>
                                                <td class="max-w-[200px] px-6 py-4 text-on-surface-variant">
                                                    <button class="view-feedback-button lesson-feedback-view font-semibold text-header-blue hover:underline" data-feedback='@json($lessonFeedback)' type="button">View</button>
                                                </td>
                                                <td class="px-6 py-4"><a href="#" class="text-xs font-semibold text-header-blue hover:underline">View Details</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </main>
    <div id="feedback-detail-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-slate-900/50 p-4">
        <div class="custom-scrollbar max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-lg bg-white shadow-2xl">
            <div class="flex items-start justify-between gap-4 border-b border-outline-variant/30 px-6 py-5">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-active-accent">Saved Feedback</p>
                    <h3 id="feedback-modal-title" class="mt-1 text-xl font-bold text-primary">Lesson Feedback</h3>
                    <p id="feedback-modal-meta" class="mt-1 text-sm text-on-surface-variant"></p>
                </div>
                <button id="close-feedback-modal" class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant text-primary transition-colors hover:bg-surface-container-low" type="button">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-4 p-6 lg:grid-cols-2">
                <div class="rounded-lg border border-outline-variant bg-surface-container-low p-4">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-outline">Vocabulary Corrections</p>
                    <p id="feedback-modal-vocabulary" class="text-sm leading-6 text-primary"></p>
                </div>
                <div class="rounded-lg border border-outline-variant bg-surface-container-low p-4">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-outline">Grammar Corrections</p>
                    <p id="feedback-modal-grammar" class="text-sm leading-6 text-primary"></p>
                </div>
                <div class="rounded-lg border border-outline-variant bg-white p-4">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-outline">Generated Feedback (English)</p>
                    <p id="feedback-modal-english" class="whitespace-pre-line text-sm leading-6 text-primary"></p>
                </div>
                <div class="rounded-lg border border-outline-variant bg-white p-4">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-outline">Generated Feedback (Chinese)</p>
                    <p id="feedback-modal-chinese" class="whitespace-pre-line text-sm leading-6 text-primary"></p>
                </div>
                <div class="rounded-lg border border-outline-variant bg-white p-4 lg:col-span-2">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-outline">Country Language Translation</p>
                    <p id="feedback-modal-translation" class="whitespace-pre-line text-sm leading-6 text-primary"></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        const currentStudentId = @json($student['id']);
        const feedbackStorageKey = 'advance_lesson_feedback_records';
        const lessonHistoryBody = document.querySelector('#lesson-history-body');
        const feedbackDetailModal = document.querySelector('#feedback-detail-modal');

        function storedFeedbackRecords() {
            try {
                return JSON.parse(localStorage.getItem(feedbackStorageKey) || '[]');
            } catch (_error) {
                return [];
            }
        }

        function statusClass(status) {
            return status === 'Sent to Student'
                ? 'bg-blue-50 text-blue-700'
                : 'bg-green-50 text-green-700';
        }

        function addFeedbackHistoryRow(feedback) {
            if (!lessonHistoryBody || document.querySelector(`[data-feedback-id="${feedback.id}"]`)) {
                return;
            }

            const matchingLessonButton = Array.from(document.querySelectorAll('.lesson-feedback-view'))
                .find((button) => {
                    try {
                        return JSON.parse(button.dataset.feedback || '{}').lesson_topic === feedback.lesson_topic;
                    } catch (_error) {
                        return false;
                    }
                });

            if (matchingLessonButton) {
                matchingLessonButton.dataset.feedback = JSON.stringify(feedback);
                matchingLessonButton.textContent = 'View';
                matchingLessonButton.classList.add('text-success');
                return;
            }

            const row = document.createElement('tr');
            row.className = 'lesson-history-row hover:bg-surface-container-low';
            row.dataset.feedbackId = feedback.id;
            row.dataset.lessonTopic = feedback.lesson_topic;
            row.innerHTML = `
                <td class="px-6 py-4 font-semibold">${feedback.date_time}</td>
                <td class="px-6 py-4">Saved</td>
                <td class="px-6 py-4">${feedback.student_name}</td>
                <td class="px-6 py-4 font-bold text-header-blue">${feedback.lesson_topic}</td>
                <td class="px-6 py-4"><a href="/teachers/${feedback.teacher_id}" class="font-semibold text-header-blue hover:underline">${feedback.teacher_name}</a></td>
                <td class="px-6 py-4"><span class="rounded-full px-2 py-1 text-xs font-bold uppercase tracking-tighter ${statusClass(feedback.status)}">${feedback.status}</span></td>
                <td class="max-w-[200px] px-6 py-4 text-on-surface-variant">
                    <button class="view-feedback-button lesson-feedback-view font-semibold text-header-blue hover:underline" data-feedback='${JSON.stringify(feedback).replace(/'/g, '&apos;')}' type="button">View</button>
                </td>
                <td class="px-6 py-4"><span class="text-xs font-semibold text-outline">Auto-saved</span></td>
            `;
            lessonHistoryBody.prepend(row);
        }

        function openFeedbackDetail(feedback) {
            document.querySelector('#feedback-modal-title').textContent = feedback.lesson_topic;
            document.querySelector('#feedback-modal-meta').textContent = `${feedback.student_name} · ${feedback.teacher_name} · ${feedback.date_time} · ${feedback.status}`;
            document.querySelector('#feedback-modal-vocabulary').textContent = feedback.vocabulary_corrections;
            document.querySelector('#feedback-modal-grammar').textContent = feedback.grammar_corrections;
            document.querySelector('#feedback-modal-english').textContent = feedback.english_feedback;
            document.querySelector('#feedback-modal-chinese').textContent = feedback.chinese_feedback;
            document.querySelector('#feedback-modal-translation').textContent = feedback.translated_feedback || 'No country language translation saved for this feedback.';
            feedbackDetailModal?.classList.remove('hidden');
            feedbackDetailModal?.classList.add('flex');
        }

        storedFeedbackRecords()
            .filter((feedback) => feedback.student_id === currentStudentId)
            .forEach(addFeedbackHistoryRow);

        document.addEventListener('click', (event) => {
            const viewButton = event.target.closest('.view-feedback-button');
            if (viewButton) {
                if (viewButton.dataset.feedback) {
                    openFeedbackDetail(JSON.parse(viewButton.dataset.feedback));
                }
            }
        });

        document.querySelector('#close-feedback-modal')?.addEventListener('click', () => {
            feedbackDetailModal?.classList.add('hidden');
            feedbackDetailModal?.classList.remove('flex');
        });

        feedbackDetailModal?.addEventListener('click', (event) => {
            if (event.target === feedbackDetailModal) {
                feedbackDetailModal.classList.add('hidden');
                feedbackDetailModal.classList.remove('flex');
            }
        });
    </script>
</body>
</html>
