<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Communication | SpeakRyt</title>
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
    @include('partials.sidebar', ['activeSection' => 'communication', 'sidebarClass' => 'hidden lg:flex'])

    <main class="flex h-screen flex-1 flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-[#3498db] px-8 text-white">
            <div>
                <h1 class="text-2xl font-bold">Communication</h1>
                <p class="text-sm opacity-90">Advance tools for manual feedback records and internal updates.</p>
            </div>
            <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-bold uppercase tracking-wider">Advance</span>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-[1280px] space-y-6">
                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-active-accent">Communication Center</p>
                            <h2 class="mt-1 text-3xl font-bold text-primary">Communication tools</h2>
                            <p class="mt-2 max-w-3xl text-sm leading-6 text-on-surface-variant">Use this area for teacher-written lesson feedback and internal team updates. WhatsApp, Email, WeChat, and Facebook drafts now live in Message Center.</p>
                        </div>
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-bold text-amber-800">
                            No external messaging API is connected.
                        </div>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @foreach ($communicationTools as $key => $tool)
                        <a class="rounded-xl border p-4 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md {{ $activeTool === $key ? 'border-active-accent bg-white ring-2 ring-active-accent/20' : 'border-outline-variant bg-surface-container-lowest' }}" href="{{ $key === 'feedback' ? $tool['href'] : route('communication.index', ['tool' => $key]) }}">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <span class="material-symbols-outlined rounded-lg bg-surface-container-low p-2 text-secondary">{{ $tool['icon'] }}</span>
                                @if ($tool['admin_only'])
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-red-700">Admin</span>
                                @endif
                            </div>
                            <p class="text-sm font-bold text-primary">{{ $tool['label'] }}</p>
                            <p class="mt-2 text-xs leading-5 text-on-surface-variant">{{ $tool['subtitle'] }}</p>
                        </a>
                    @endforeach
                </section>

                @php($tool = $communicationTools[$activeTool])
                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="border-b border-outline-variant px-6 py-5">
                        <div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center">
                            <div>
                                <h3 class="text-xl font-bold text-primary">{{ $tool['label'] }}</h3>
                                <p class="mt-1 text-sm text-on-surface-variant">{{ $tool['subtitle'] }}</p>
                            </div>
                            <span class="rounded-full bg-surface-container-low px-3 py-1 text-xs font-bold uppercase tracking-wider text-secondary">{{ $tool['status'] }}</span>
                        </div>
                    </div>
                    @if ($activeTool === 'wechat')
                        <div class="grid grid-cols-1 gap-6 p-5 xl:grid-cols-12">
                            <div class="space-y-5 xl:col-span-7">
                                <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-xs font-semibold text-blue-800">
                                    Messages are copied manually. No message is sent from the dashboard.
                                </div>

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

                                <div>
                                    <div class="mb-2 flex items-center justify-between gap-3">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant" for="generated-message">Editable Message Preview</label>
                                        <button id="copy-edited-message" class="inline-flex h-9 items-center gap-2 rounded-lg bg-primary px-3 text-xs font-bold text-white transition-colors hover:bg-secondary" type="button">
                                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            Copy Edited Message
                                        </button>
                                    </div>
                                    <textarea id="generated-message" class="min-h-[300px] w-full rounded-lg border border-outline-variant bg-white p-4 text-sm leading-6 text-primary shadow-sm focus:border-active-accent focus:ring-active-accent/20" placeholder="Click a message button, then edit anything you need before copying again."></textarea>
                                </div>
                            </div>

                            <div class="space-y-5 xl:col-span-5">
                                <div class="rounded-lg border border-outline-variant bg-white p-5">
                                    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                        <div>
                                            <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Message Variables</h4>
                                            <p class="mt-1 text-xs text-on-surface-variant">These details are inserted into the message automatically.</p>
                                        </div>
                                        <form action="{{ route('communication.index') }}" method="GET">
                                            <input type="hidden" name="tool" value="wechat">
                                            <label class="block">
                                                <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student</span>
                                                <select class="h-10 rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" name="student" onchange="this.form.submit()">
                                                    @foreach ($wechatStudents as $studentOption)
                                                        <option value="{{ $studentOption['id'] }}" @selected($studentOption['id'] === $wechatStudent['id'])>
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
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Add Reminder</h4>
                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <label class="sm:col-span-2">
                                            <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Reminder Title</span>
                                            <input class="h-10 w-full rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="text" value="Send reminder to {{ $wechatStudent['name'] }}">
                                        </label>
                                        <label>
                                            <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Message Type</span>
                                            <select class="h-10 w-full rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20">
                                                <option>Class Reminder</option>
                                                <option>Payment</option>
                                                <option>Follow-up</option>
                                            </select>
                                        </label>
                                        <label>
                                            <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Status</span>
                                            <select class="h-10 w-full rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20">
                                                <option>Pending</option>
                                                <option>Completed</option>
                                            </select>
                                        </label>
                                        <label>
                                            <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Date</span>
                                            <input class="h-10 w-full rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="date" value="{{ now()->toDateString() }}">
                                        </label>
                                        <label>
                                            <span class="mb-1 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Time</span>
                                            <input class="h-10 w-full rounded-lg border-outline-variant text-sm focus:border-active-accent focus:ring-active-accent/20" type="time" value="19:00">
                                        </label>
                                    </div>
                                    <button class="mt-4 inline-flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-primary text-sm font-bold text-white transition-colors hover:bg-secondary" type="button">
                                        <span class="material-symbols-outlined text-[18px]">alarm_add</span>
                                        Save Reminder Draft
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-outline-variant px-5 pb-5">
                            <div class="overflow-x-auto rounded-lg border border-outline-variant bg-white">
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
                    @else
                        <div class="grid grid-cols-1 gap-5 p-6 lg:grid-cols-3">
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low p-5">
                                <p class="text-sm font-bold text-primary">Access Rule</p>
                                <p class="mt-2 text-sm leading-6 text-on-surface-variant">
                                    @if ($tool['admin_only'])
                                        This tool is admin-only by default because it may contain sensitive parent, student, payment, or direct-contact communication.
                                    @else
                                        This tool can be used for operations work while still following the permission settings in User Management.
                                    @endif
                                </p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low p-5">
                                <p class="text-sm font-bold text-primary">Suggested Workflow</p>
                                <p class="mt-2 text-sm leading-6 text-on-surface-variant">Prepare the note, review it, then save or copy it manually in the correct workflow.</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low p-5">
                                <p class="text-sm font-bold text-primary">Open Tool</p>
                                <a class="mt-4 inline-flex h-10 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold text-white transition-colors hover:bg-secondary" href="{{ $tool['href'] }}">
                                    Open {{ $tool['label'] }}
                                </a>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </main>
</body>
</html>
