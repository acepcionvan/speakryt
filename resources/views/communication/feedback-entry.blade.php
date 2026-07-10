<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lesson Feedback Entry | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#022448',
                        secondary: '#006397',
                        background: '#f7f9fb',
                        'surface-container-low': '#f2f4f6',
                        'surface-container-lowest': '#ffffff',
                        'outline-variant': '#c4c6cf',
                        'on-surface-variant': '#43474e',
                        'active-accent': '#00aeef',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-primary">
    @include('partials.sidebar', ['activeSection' => 'communication', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white">
            <div>
                <h1 class="text-2xl font-bold">Lesson Feedback Entry</h1>
                <p class="text-sm opacity-90">Teacher-written feedback saved directly to the student lesson record.</p>
            </div>
            <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-bold uppercase tracking-wider">Manual Input</span>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-[1380px] space-y-6">
                <x-back-button :href="route('communication.index')" label="Back to Communication" />

                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-active-accent">Teacher Feedback Record</p>
                            <h2 class="mt-1 text-3xl font-bold text-primary">Write and save lesson feedback manually</h2>
                            <p class="mt-2 max-w-3xl text-sm leading-6 text-on-surface-variant">
                                Teachers can type the exact feedback, vocabulary notes, and correction notes they want stored. Nothing is generated automatically.
                            </p>
                        </div>
                        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-bold text-green-800">
                            Saved feedback appears in Student Profile → Lesson History
                        </div>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                    <div class="space-y-6 xl:col-span-8">
                        <section class="rounded-xl border border-outline-variant bg-white p-5 shadow-sm">
                            <div class="mb-5 flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-bold text-primary">Lesson Details</h3>
                                    <p class="mt-1 text-sm text-on-surface-variant">Choose the lesson record where this feedback should be attached.</p>
                                </div>
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-blue-700">Student linked</span>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                <label class="lg:col-span-2">
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Current Lesson Session</span>
                                    <select id="feedback-session-select" class="h-11 w-full rounded-lg border border-outline-variant bg-white text-sm focus:border-primary focus:ring-primary/20">
                                        @foreach ($feedbackSessions as $session)
                                            <option value="{{ $loop->index }}">
                                                {{ $session['student_name'] }} | {{ $session['lesson_topic'] }} | {{ $session['date_time'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher</span>
                                    <input id="feedback-teacher-name" class="h-11 w-full rounded-lg border border-outline-variant bg-surface-container-low text-sm font-semibold text-primary" type="text" value="{{ $teacher['name'] }}" readonly>
                                </label>
                                <label class="lg:col-span-2">
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Lesson Topic</span>
                                    <input id="feedback-lesson-topic" class="h-11 w-full rounded-lg border border-outline-variant bg-white text-sm focus:border-primary focus:ring-primary/20" type="text">
                                </label>
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</span>
                                    <select id="feedback-status" class="h-11 w-full rounded-lg border border-outline-variant bg-white text-sm focus:border-primary focus:ring-primary/20">
                                        <option>Saved</option>
                                        <option>Sent to Student</option>
                                    </select>
                                </label>
                            </div>
                        </section>

                        <section class="rounded-xl border border-outline-variant bg-white p-5 shadow-sm">
                            <div class="mb-5">
                                <h3 class="text-xl font-bold text-primary">Teacher Feedback</h3>
                                <p class="mt-1 text-sm text-on-surface-variant">Type the exact notes to store in the student record.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Vocabulary Notes</span>
                                    <textarea id="vocabulary-notes" class="min-h-[130px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary focus:border-primary focus:ring-primary/20" placeholder="Example: Practice: confident, improve, pronunciation. Meaning and examples may be typed here by the teacher."></textarea>
                                </label>
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Grammar / Sentence Corrections</span>
                                    <textarea id="grammar-notes" class="min-h-[130px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary focus:border-primary focus:ring-primary/20" placeholder="Example: Incorrect: He go to school. Correct: He goes to school."></textarea>
                                </label>
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Final Feedback</span>
                                    <textarea id="final-feedback" class="min-h-[220px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary focus:border-primary focus:ring-primary/20" placeholder="Write the teacher's respectful and professional feedback here." required></textarea>
                                </label>
                                <label>
                                    <span class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Optional Parent / Student Translation Note</span>
                                    <textarea id="translated-feedback" class="min-h-[130px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary focus:border-primary focus:ring-primary/20" placeholder="Optional: teacher or admin can paste a translated version here."></textarea>
                                </label>
                            </div>
                        </section>
                    </div>

                    <aside class="space-y-6 xl:col-span-4">
                        <section class="rounded-xl border border-outline-variant bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-bold text-primary">Save Target</h3>
                            <div class="mt-4 grid grid-cols-1 gap-3">
                                <div class="rounded-lg bg-surface-container-low p-4">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student</p>
                                    <p id="target-student" class="mt-1 text-sm font-bold text-primary">Select a lesson session.</p>
                                </div>
                                <div class="rounded-lg bg-surface-container-low p-4">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student ID</p>
                                    <p id="target-student-id" class="mt-1 text-sm font-bold text-primary">-</p>
                                </div>
                                <div class="rounded-lg bg-surface-container-low p-4">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Lesson Date & Time</p>
                                    <p id="target-date" class="mt-1 text-sm font-bold text-primary">-</p>
                                </div>
                                <div class="rounded-lg bg-surface-container-low p-4">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher ID</p>
                                    <p id="target-teacher-id" class="mt-1 text-sm font-bold text-primary">-</p>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-xl border border-outline-variant bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-bold text-primary">Actions</h3>
                            <p class="mt-1 text-sm leading-6 text-on-surface-variant">Saving writes the record to the same feedback history used by the student lesson table.</p>

                            <div id="save-feedback-alert" class="mt-4 hidden rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-bold text-green-700">
                                Feedback saved to student record.
                            </div>

                            <div id="save-feedback-error" class="mt-4 hidden rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
                                Please add a lesson topic and final feedback before saving.
                            </div>

                            <div class="mt-5 grid grid-cols-1 gap-3">
                                <button id="save-feedback-button" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-primary px-5 text-sm font-bold text-white transition-colors hover:bg-secondary" type="button">
                                    <span class="material-symbols-outlined text-[18px]">save</span>
                                    Save Feedback
                                </button>
                                <button id="copy-feedback-button" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-secondary bg-white px-5 text-sm font-bold text-secondary transition-colors hover:bg-blue-50 disabled:cursor-not-allowed disabled:opacity-40" type="button" disabled>
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                    Copy Saved Feedback
                                </button>
                                <a id="open-student-record" class="hidden h-11 items-center justify-center gap-2 rounded-lg border border-outline-variant bg-surface-container-low px-5 text-sm font-bold text-primary transition-colors hover:bg-white" href="#">
                                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                    Open Student Record
                                </a>
                            </div>
                        </section>

                        <section class="rounded-xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-900">Reminder</h3>
                            <p class="mt-2 text-sm leading-6 text-blue-800">
                                This page does not create feedback automatically. Teachers are responsible for typing the feedback they want saved.
                            </p>
                        </section>
                    </aside>
                </section>
            </div>
        </div>
    </main>

    <div id="feedback-toast" class="pointer-events-none fixed right-5 top-5 z-50 hidden rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white shadow-lg">
        Copied.
    </div>

    <script>
        const feedbackSessions = @json($feedbackSessions);
        const feedbackStorageKey = 'advance_lesson_feedback_records';
        const studentRecordUrlTemplate = @json(route('students.show', ['student' => '__STUDENT__']).'?tab=lesson');
        let savedRecord = null;

        const sessionSelect = document.getElementById('feedback-session-select');
        const lessonTopicInput = document.getElementById('feedback-lesson-topic');
        const feedbackStatus = document.getElementById('feedback-status');
        const vocabularyNotes = document.getElementById('vocabulary-notes');
        const grammarNotes = document.getElementById('grammar-notes');
        const finalFeedback = document.getElementById('final-feedback');
        const translatedFeedback = document.getElementById('translated-feedback');
        const targetStudent = document.getElementById('target-student');
        const targetStudentId = document.getElementById('target-student-id');
        const targetDate = document.getElementById('target-date');
        const targetTeacherId = document.getElementById('target-teacher-id');
        const saveAlert = document.getElementById('save-feedback-alert');
        const saveError = document.getElementById('save-feedback-error');
        const copyButton = document.getElementById('copy-feedback-button');
        const openStudentRecord = document.getElementById('open-student-record');
        const toast = document.getElementById('feedback-toast');

        function selectedSession() {
            return feedbackSessions[Number(sessionSelect.value)] || feedbackSessions[0];
        }

        function updateSessionFields() {
            const session = selectedSession();
            if (! session) return;

            lessonTopicInput.value = session.lesson_topic || '';
            vocabularyNotes.value = session.vocabulary_corrections || '';
            grammarNotes.value = session.grammar_corrections || '';
            finalFeedback.value = '';
            translatedFeedback.value = '';
            savedRecord = null;

            targetStudent.textContent = session.student_name;
            targetStudentId.textContent = session.student_id;
            targetDate.textContent = session.date_time;
            targetTeacherId.textContent = session.teacher_id;

            saveAlert.classList.add('hidden');
            saveError.classList.add('hidden');
            copyButton.disabled = true;
            openStudentRecord.classList.add('hidden');
            openStudentRecord.classList.remove('inline-flex');
        }

        function storedRecords() {
            try {
                return JSON.parse(localStorage.getItem(feedbackStorageKey)) || [];
            } catch (error) {
                return [];
            }
        }

        function saveRecords(records) {
            localStorage.setItem(feedbackStorageKey, JSON.stringify(records));
        }

        function recordText(record) {
            return [
                `Student: ${record.student_name}`,
                `Teacher: ${record.teacher_name}`,
                `Date & Time: ${record.date_time}`,
                `Lesson Topic: ${record.lesson_topic}`,
                '',
                'Vocabulary Notes:',
                record.vocabulary_corrections || 'No vocabulary notes entered.',
                '',
                'Grammar / Sentence Corrections:',
                record.grammar_corrections || 'No grammar notes entered.',
                '',
                'Final Feedback:',
                record.english_feedback || '',
                record.translated_feedback ? `\nTranslation Note:\n${record.translated_feedback}` : '',
            ].filter(Boolean).join('\n');
        }

        function showToast(message) {
            toast.textContent = message;
            toast.classList.remove('hidden');
            window.setTimeout(() => toast.classList.add('hidden'), 1800);
        }

        document.getElementById('save-feedback-button').addEventListener('click', () => {
            const session = selectedSession();
            const lessonTopic = lessonTopicInput.value.trim();
            const feedback = finalFeedback.value.trim();

            if (! lessonTopic || ! feedback) {
                saveAlert.classList.add('hidden');
                saveError.classList.remove('hidden');
                return;
            }

            const record = {
                id: `FB-${session.student_id}-${Date.now()}`,
                student_id: session.student_id,
                student_name: session.student_name,
                teacher_id: session.teacher_id,
                teacher_name: session.teacher_name,
                date_time: session.date_time,
                lesson_topic: lessonTopic,
                vocabulary_corrections: vocabularyNotes.value.trim(),
                grammar_corrections: grammarNotes.value.trim(),
                english_feedback: feedback,
                chinese_feedback: translatedFeedback.value.trim(),
                translated_feedback: translatedFeedback.value.trim(),
                status: feedbackStatus.value,
                linked_lesson_session: `${session.student_id}-${session.teacher_id}-${session.date_time}`,
            };

            const records = storedRecords().filter((item) => item.id !== record.id);
            records.unshift(record);
            saveRecords(records);
            savedRecord = record;

            saveError.classList.add('hidden');
            saveAlert.classList.remove('hidden');
            copyButton.disabled = false;
            openStudentRecord.href = studentRecordUrlTemplate.replace('__STUDENT__', encodeURIComponent(record.student_id));
            openStudentRecord.classList.remove('hidden');
            openStudentRecord.classList.add('inline-flex');
            showToast('Feedback saved to student record.');
        });

        copyButton.addEventListener('click', async () => {
            if (! savedRecord) return;
            await navigator.clipboard.writeText(recordText(savedRecord));
            showToast('Saved feedback copied.');
        });

        sessionSelect.addEventListener('change', updateSessionFields);
        updateSessionFields();
    </script>
</body>
</html>
