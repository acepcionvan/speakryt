<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Message Center | SpeakRyt</title>
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
                        'surface-container-high': '#e6e8ea',
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
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background font-sans text-primary">
    @include('partials.sidebar', ['activeSection' => 'message-center', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white">
            <div>
                <h1 class="text-2xl font-bold">Message Center</h1>
                <p class="text-sm opacity-90">Admin-only manual message drafts for WhatsApp, Email, WeChat, and Facebook.</p>
            </div>
            <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-bold uppercase tracking-wider">No API Connected</span>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-[1280px] space-y-6">
                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-active-accent">Manual Messaging</p>
                            <h2 class="mt-1 text-3xl font-bold text-primary">{{ $messageChannels[$activeChannel]['label'] }}</h2>
                            <p class="mt-2 max-w-3xl text-sm leading-6 text-on-surface-variant">{{ $messageChannels[$activeChannel]['subtitle'] }}</p>
                        </div>
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-bold text-amber-800">
                            Messages are copied only. Nothing is sent automatically.
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex flex-wrap items-end gap-1">
                        @foreach ($messageChannels as $key => $channel)
                            <a class="-mb-px rounded-t-2xl border px-5 py-3 text-sm font-bold transition-all {{ $activeChannel === $key ? 'border-active-accent border-b-white bg-white text-primary shadow-sm' : 'border-outline-variant bg-surface-container-low text-on-surface-variant hover:bg-white hover:text-primary' }}" href="{{ route('message-center.index', ['channel' => $key, 'student' => $student['id']]) }}">
                                <span class="material-symbols-outlined mr-1 align-[-5px] text-[18px]">{{ $channel['icon'] }}</span>
                                {{ $channel['label'] }}
                            </a>
                        @endforeach
                    </div>

                    <div class="rounded-b-xl rounded-tr-xl border border-outline-variant bg-white p-5 shadow-sm">
                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                            <div class="space-y-5 xl:col-span-7">
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                    @foreach ([
                                        ['type' => 'class', 'label' => 'Class Reminder', 'icon' => 'event'],
                                        ['type' => 'payment', 'label' => 'Payment Reminder', 'icon' => 'payments'],
                                        ['type' => 'renewal', 'label' => 'Renewal Reminder', 'icon' => 'autorenew'],
                                        ['type' => 'followup', 'label' => 'Follow-up Message', 'icon' => 'forum'],
                                        ['type' => 'custom', 'label' => 'Custom Message', 'icon' => 'edit_note'],
                                    ] as $button)
                                        <button class="message-template-button flex min-h-[76px] items-center gap-3 rounded-lg border border-outline-variant bg-white px-4 py-3 text-left shadow-sm transition-all hover:-translate-y-0.5 hover:border-active-accent hover:shadow-md" data-message-type="{{ $button['type'] }}" type="button">
                                            <span class="material-symbols-outlined flex h-10 w-10 items-center justify-center rounded-lg bg-surface-container-low text-secondary">{{ $button['icon'] }}</span>
                                            <span>
                                                <span class="block text-sm font-bold text-primary">{{ $button['label'] }}</span>
                                                <span class="mt-0.5 block text-[11px] font-medium text-on-surface-variant">Generate and copy</span>
                                            </span>
                                        </button>
                                    @endforeach
                                </div>

                                @if ($activeChannel === 'email')
                                    <label class="block">
                                        <span class="mb-2 block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Email Subject</span>
                                        <input id="message-subject" class="h-11 w-full rounded-lg border border-outline-variant bg-white text-sm focus:border-active-accent focus:ring-active-accent/20" value="SpeakRyt Lesson Update for {{ $student['name'] }}">
                                    </label>
                                @endif

                                <div>
                                    <div class="mb-2 flex items-center justify-between gap-3">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant" for="generated-message">Editable Message Preview</label>
                                        <button id="copy-edited-message" class="inline-flex h-9 items-center gap-2 rounded-lg bg-primary px-3 text-xs font-bold text-white transition-colors hover:bg-secondary" type="button">
                                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            Copy Edited Message
                                        </button>
                                    </div>
                                    <textarea id="generated-message" class="min-h-[330px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary shadow-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="Click a message button, then edit anything you need before copying again."></textarea>
                                </div>
                            </div>

                            <div class="space-y-5 xl:col-span-5">
                                <div class="rounded-lg border border-outline-variant bg-white p-5">
                                    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                        <div>
                                            <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Message Variables</h4>
                                            <p class="mt-1 text-xs text-on-surface-variant">These details are inserted automatically.</p>
                                        </div>
                                        <form action="{{ route('message-center.index') }}" method="GET">
                                            <input type="hidden" name="channel" value="{{ $activeChannel }}">
                                            <label class="block">
                                                <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student</span>
                                                <select class="h-10 rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" name="student" onchange="this.form.submit()">
                                                    @foreach ($students as $studentOption)
                                                        <option value="{{ $studentOption['id'] }}" @selected($studentOption['id'] === $student['id'])>
                                                            {{ $studentOption['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </form>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <div class="rounded-lg bg-surface-container-low p-3">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student</p>
                                            <p class="mt-1 text-sm font-bold text-primary">{{ $communicationContext['student_name'] }}</p>
                                        </div>
                                        <div class="rounded-lg bg-surface-container-low p-3">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Lesson Time</p>
                                            <p class="mt-1 text-sm font-bold text-primary">{{ $communicationContext['lesson_time'] }}</p>
                                        </div>
                                        <div class="rounded-lg bg-surface-container-low p-3">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher</p>
                                            <p class="mt-1 text-sm font-bold text-primary">{{ $communicationContext['teacher_name'] }}</p>
                                        </div>
                                        <div class="rounded-lg bg-surface-container-low p-3">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Remaining Lessons</p>
                                            <p class="mt-1 text-sm font-bold text-primary">{{ $communicationContext['remaining_lessons'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-outline-variant bg-white p-5">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Reminder Draft</h4>
                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <input class="sm:col-span-2 h-10 rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="text" value="Send {{ $messageChannels[$activeChannel]['label'] }} to {{ $student['name'] }}">
                                        <input class="h-10 rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="date" value="{{ now()->toDateString() }}">
                                        <input class="h-10 rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="time" value="19:00">
                                    </div>
                                    <button class="mt-4 inline-flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-primary text-sm font-bold text-white transition-colors hover:bg-secondary" type="button">
                                        <span class="material-symbols-outlined text-[18px]">alarm_add</span>
                                        Save Reminder Draft
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 overflow-x-auto rounded-lg border border-outline-variant bg-white">
                            <table class="min-w-[760px] w-full text-left">
                                <thead class="bg-surface-container-low">
                                    <tr>
                                        <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Reminder Title</th>
                                        <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Message Type</th>
                                        <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Date</th>
                                        <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Time</th>
                                        <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/10">
                                    @foreach ($studentReminders as $reminder)
                                        <tr class="hover:bg-surface-container-low">
                                            <td class="px-5 py-4 text-sm font-bold text-primary">{{ $reminder['title'] }}</td>
                                            <td class="px-5 py-4 text-sm text-on-surface-variant">{{ $reminder['type'] }}</td>
                                            <td class="px-5 py-4 text-sm text-on-surface-variant">{{ $reminder['date'] }}</td>
                                            <td class="px-5 py-4 text-sm font-bold text-primary">{{ $reminder['time'] }}</td>
                                            <td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-[11px] font-bold {{ $reminder['status_class'] }}">{{ $reminder['status'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <div id="copy-toast" class="pointer-events-none fixed right-5 top-5 z-50 hidden rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white shadow-lg">
        {{ $messageChannels[$activeChannel]['copy_label'] }}
    </div>

    <script>
        const communicationContext = @json($communicationContext);
        const activeChannel = @json($activeChannel);
        const copyLabel = @json($messageChannels[$activeChannel]['copy_label']);
        const messageBox = document.querySelector('#generated-message');
        const subjectBox = document.querySelector('#message-subject');
        const copyToast = document.querySelector('#copy-toast');

        const baseTemplates = {
            class: ({ lesson_time: lessonTime, teacher_name: teacherName, company_name: companyName }) => `Hello! This is a friendly reminder that your lesson is scheduled today at ${lessonTime}.\n\nTeacher: ${teacherName}\n\nPlease make sure to be ready a few minutes before the class. We look forward to seeing you!\n\nThank you,\n${companyName}`,
            payment: ({ remaining_lessons: remainingLessons, company_name: companyName }) => `Hello! This is a kind reminder regarding your lesson package.\n\nYou currently have ${remainingLessons} lessons remaining. Please let us know if you would like to renew your package.\n\nThank you,\n${companyName}`,
            renewal: ({ remaining_lessons: remainingLessons, company_name: companyName }) => `Hello! We noticed that your lessons are almost finished.\n\nYou currently have ${remainingLessons} lessons left. We recommend renewing your package to continue your learning without interruption.\n\nPlease let us know if you would like to proceed.\n\nThank you,\n${companyName}`,
            followup: ({ company_name: companyName }) => `Hello! We just wanted to follow up and check how everything is going with your lessons.\n\nPlease let us know if you have any questions or if there is anything we can assist you with.\n\nThank you,\n${companyName}`,
            custom: ({ student_name: studentName, lesson_time: lessonTime, teacher_name: teacherName, remaining_lessons: remainingLessons, company_name: companyName }) => `Hello ${studentName},\n\nThis is ${companyName}. Your next lesson is scheduled at ${lessonTime} with ${teacherName}. You currently have ${remainingLessons} lessons remaining.\n\nPlease let us know if you need any assistance.\n\nThank you,\n${companyName}`,
        };

        const mandarinTemplates = {
            class: ({ lesson_time: lessonTime, teacher_name: teacherName, company_name: companyName }) => `\n\n您好！这是一个温馨提醒，您的课程安排在今天 ${lessonTime}。\n\n老师：${teacherName}\n\n请提前几分钟做好准备，我们期待在课堂上见到您！\n\n谢谢，\n${companyName}`,
            payment: ({ remaining_lessons: remainingLessons, company_name: companyName }) => `\n\n您好！这是关于您课程套餐的提醒。\n\n您目前还剩下 ${remainingLessons} 节课。如果您需要续费，请随时联系我们。\n\n谢谢，\n${companyName}`,
            renewal: ({ remaining_lessons: remainingLessons, company_name: companyName }) => `\n\n您好！我们注意到您的课程即将结束。\n\n您目前还剩下 ${remainingLessons} 节课。为了不影响您的学习进度，我们建议您尽快续费。\n\n如需继续课程，请随时联系我们。\n\n谢谢，\n${companyName}`,
            followup: ({ company_name: companyName }) => `\n\n您好！我们想跟进一下您目前的学习情况。\n\n如果您有任何问题或需要帮助，请随时告诉我们。\n\n谢谢，\n${companyName}`,
            custom: () => '',
        };

        function channelPrefix() {
            if (activeChannel === 'email') {
                return subjectBox?.value ? `Subject: ${subjectBox.value}\n\n` : '';
            }

            if (activeChannel === 'facebook') {
                return 'Facebook Messenger Draft\n\n';
            }

            if (activeChannel === 'whatsapp') {
                return 'WhatsApp Draft\n\n';
            }

            return '';
        }

        function generatedMessage(type) {
            const english = baseTemplates[type](communicationContext);
            const mandarin = activeChannel === 'wechat' ? (mandarinTemplates[type]?.(communicationContext) || '') : '';

            return `${channelPrefix()}${english}${mandarin}`;
        }

        async function copyMessage(message) {
            if (!message.trim()) return;

            try {
                await navigator.clipboard.writeText(message);
            } catch (_error) {
                const temporaryField = document.createElement('textarea');
                temporaryField.value = message;
                temporaryField.setAttribute('readonly', '');
                temporaryField.style.position = 'fixed';
                temporaryField.style.opacity = '0';
                document.body.appendChild(temporaryField);
                temporaryField.select();
                document.execCommand('copy');
                temporaryField.remove();
            }

            copyToast.textContent = copyLabel;
            copyToast.classList.remove('hidden');
            window.clearTimeout(window.copyToastTimer);
            window.copyToastTimer = window.setTimeout(() => copyToast.classList.add('hidden'), 2200);
        }

        document.querySelectorAll('.message-template-button').forEach((button) => {
            button.addEventListener('click', () => {
                const message = generatedMessage(button.dataset.messageType);
                messageBox.value = message;
                messageBox.focus();
                copyMessage(message);
            });
        });

        document.querySelector('#copy-edited-message')?.addEventListener('click', () => {
            copyMessage(messageBox?.value || '');
        });
    </script>
</body>
</html>
