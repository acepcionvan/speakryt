<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Schedule | SpeakRyt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        try {
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            secondary: '#006397',
                            'primary-fixed-dim': '#adc8f5',
                            outline: '#74777f',
                            'primary-fixed': '#d5e3ff',
                            'surface-tint': '#455f87',
                            background: '#f7f9fb',
                            'on-tertiary-fixed': '#001e2c',
                            'active-accent': '#00bfff',
                            'secondary-fixed': '#cce5ff',
                            'on-secondary': '#ffffff',
                            'surface-dim': '#d8dadc',
                            'on-error-container': '#93000a',
                            success: '#27ae60',
                            'secondary-container': '#5cb8fd',
                            'on-error': '#ffffff',
                            'on-surface-variant': '#43474e',
                            primary: '#022448',
                            'on-primary-fixed-variant': '#2d486d',
                            surface: '#f7f9fb',
                            'on-background': '#191c1e',
                            'tertiary-container': '#003e56',
                            'outline-variant': '#c4c6cf',
                            'on-primary-fixed': '#001c3b',
                            'surface-container-highest': '#e0e3e5',
                            'on-secondary-container': '#00476e',
                            'secondary-fixed-dim': '#92ccff',
                            'on-tertiary-container': '#00afea',
                            'surface-bright': '#f7f9fb',
                            tertiary: '#002738',
                            'on-primary-container': '#8aa4cf',
                            'inverse-on-surface': '#eff1f3',
                            'inverse-primary': '#adc8f5',
                            'on-surface': '#191c1e',
                            error: '#e74c3c',
                            'on-tertiary-fixed-variant': '#004c69',
                            warning: '#f1c40f',
                            'on-primary': '#ffffff',
                            'text-primary': '#333333',
                            'surface-container-high': '#e6e8ea',
                            'surface-container': '#eceef0',
                            'on-secondary-fixed-variant': '#004b73',
                            'primary-container': '#1e3a5f',
                            'surface-variant': '#e0e3e5',
                            'error-container': '#ffdad6',
                            'on-secondary-fixed': '#001d31',
                            'on-tertiary': '#ffffff',
                            'surface-container-lowest': '#ffffff',
                            'surface-container-low': '#f2f4f6',
                            'tertiary-fixed': '#c3e8ff',
                            'tertiary-fixed-dim': '#7ad0ff',
                            'sidebar-bg': '#1e3a5f',
                            'header-blue': '#3498db',
                        },
                    },
                },
            };
        } catch (_e) {}
    </script>
    <style>
        body { font-family: Inter, sans-serif; }
        .nav-item-active { border-left: 4px solid #fff; }
        .nav-item:hover:not(.nav-item-active) { background-color: rgba(255, 255, 255, 0.1); }
        .slot-selected {
            box-shadow: inset 0 0 0 2px #022448;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-background text-on-surface antialiased">
    @include('partials.sidebar', ['activeSection' => 'schedule', 'sidebarClass' => 'hidden lg:flex'])

    <main class="relative flex h-screen flex-grow flex-col overflow-y-auto bg-[#f0f2f5]">
        <header class="flex h-16 flex-shrink-0 items-center justify-between bg-header-blue px-8 text-white shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center overflow-hidden rounded border border-white/20 bg-white/20 text-lg font-bold shadow-sm">V</div>
                <div class="flex flex-col">
                    <h1 class="text-xl font-bold leading-none">Welcome back, Van</h1>
                    <p class="text-[11px] font-medium opacity-90">Let's make it a Great Day!</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @foreach (['search', 'notifications', 'settings'] as $icon)
                    <button class="flex h-9 w-9 items-center justify-center rounded-full transition-colors hover:bg-white/10">
                        <span class="material-symbols-outlined text-xl text-white">{{ $icon }}</span>
                    </button>
                @endforeach
            </div>
        </header>

        <div class="mx-auto w-full max-w-[1600px] space-y-6 px-8 pb-24 pt-8">
            <section class="rounded-lg border border-surface-container-high bg-surface-container-lowest p-6 shadow-sm" id="schedule-control-panel">
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)]">
                    <div class="space-y-5">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                            <div class="max-w-2xl">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Schedule Access</p>
                                <h2 class="mt-1 text-xl font-bold text-primary">Editable Time Blocks</h2>
                                <p class="mt-1 text-sm leading-6 text-on-surface-variant">Teachers can only open or close empty slots. Once a student is assigned, only admin, manager, or supervisor can update that block, reassign it, or clear the booking.</p>
                            </div>
                            <div class="inline-flex rounded-lg border border-outline-variant bg-surface p-1">
                                @foreach (['teacher' => 'Teacher', 'admin' => 'Admin', 'manager' => 'Manager', 'supervisor' => 'Supervisor'] as $roleKey => $roleLabel)
                                    <button type="button" class="role-toggle rounded-md px-3 py-2 text-sm font-bold text-on-surface-variant transition-all" data-role="{{ $roleKey }}">{{ $roleLabel }}</button>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="rounded-lg border border-outline-variant bg-surface p-4">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Selected Block</p>
                                <h3 class="mt-1 text-lg font-bold text-primary" id="selected-slot-label">Choose a time block</h3>
                                <p class="mt-1 text-sm text-on-surface-variant" id="selected-slot-meta">Click any slot in the grid to manage it.</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Current Status</p>
                                        <p class="mt-1 text-base font-bold text-primary" id="selected-slot-status">No slot selected</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest" id="selected-slot-pill">Idle</span>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant" id="selected-slot-student">No assigned student yet.</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Active Permission</p>
                                        <p class="mt-1 text-base font-bold text-primary">Editing Role</p>
                                    </div>
                                    <span class="rounded-full bg-surface-container-low px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant" id="role-badge">Teacher Mode</span>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant" id="permission-hint">Teacher mode can only open or close empty blocks.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] xl:grid-cols-1">
                        <div class="rounded-lg border border-outline-variant bg-surface p-4">
                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student Name</label>
                            <input id="student-name-input" type="text" class="w-full rounded border border-outline-variant bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary" placeholder="Enter student name for this slot">
                            <label class="mb-1.5 mt-3 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student Category</label>
                            <select id="student-category-input" class="w-full rounded border border-outline-variant bg-white px-3 py-2 text-sm font-semibold focus:border-primary focus:ring-primary">
                                <option value="ADULTS">ADULTS</option>
                                <option value="KIDS">KIDS</option>
                            </select>
                            <p class="mt-2 text-xs text-on-surface-variant">Use this when assigning a student to an open block.</p>
                        </div>

                        <div class="rounded-lg border border-outline-variant bg-surface p-4">
                            <p class="mb-3 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Slot Actions</p>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" id="mark-open-button" class="rounded-lg border border-success/30 bg-success/5 px-4 py-2.5 text-sm font-bold text-success transition-all hover:bg-success/10 disabled:cursor-not-allowed disabled:opacity-40">Mark Open</button>
                                <button type="button" id="mark-closed-button" class="rounded-lg border border-error/30 bg-error/5 px-4 py-2.5 text-sm font-bold text-error transition-all hover:bg-error/10 disabled:cursor-not-allowed disabled:opacity-40">Mark Closed</button>
                                <button type="button" id="assign-student-button" class="col-span-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white transition-all hover:bg-primary/90 disabled:cursor-not-allowed disabled:opacity-40">Assign Student</button>
                                <button type="button" id="clear-assignment-button" class="col-span-2 rounded-lg border border-outline-variant bg-white px-4 py-2.5 text-sm font-bold text-on-surface-variant transition-all hover:bg-surface disabled:cursor-not-allowed disabled:opacity-40">Clear Assignment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="flex items-center justify-between rounded-lg border border-surface-container-high bg-surface-container-lowest p-4 shadow-sm">
                <div class="flex flex-wrap items-center gap-3">
                    @foreach ([
                        ['icon' => 'print', 'label' => 'Print', 'class' => 'border-outline-variant text-on-surface-variant hover:bg-surface'],
                        ['icon' => 'send', 'label' => 'Send', 'class' => 'border-outline-variant text-on-surface-variant hover:bg-surface'],
                        ['icon' => 'picture_as_pdf', 'label' => 'Download PDF', 'class' => 'border-error/30 text-error hover:bg-error/5'],
                        ['icon' => 'file_download', 'label' => 'Export', 'class' => 'border-success/30 text-success hover:bg-success/5'],
                    ] as $action)
                        <button class="flex h-10 items-center gap-2 rounded border px-4 text-sm font-bold transition-all {{ $action['class'] }}">
                            <span class="material-symbols-outlined text-lg">{{ $action['icon'] }}</span>
                            {{ $action['label'] }}
                        </button>
                    @endforeach
                </div>
                <button class="flex h-10 items-center gap-2 rounded border border-error px-4 text-sm font-bold text-error transition-all hover:bg-error/10">
                    <span class="material-symbols-outlined text-lg">delete</span>
                    Clear Week
                </button>
            </section>

            <section class="rounded-lg border border-surface-container-high bg-surface-container-lowest p-6 shadow-sm">
                <div class="grid grid-cols-1 items-end gap-5 md:grid-cols-2 lg:grid-cols-5">
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Teacher's Name / ID</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2 text-lg text-outline">search</span>
                            <input class="w-full rounded border border-outline-variant bg-white py-2 pl-10 pr-3 text-sm focus:border-primary focus:ring-primary" placeholder="Search teacher..." type="text">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student's Name / ID</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2 text-lg text-outline">search</span>
                            <input class="w-full rounded border border-outline-variant bg-white py-2 pl-10 pr-3 text-sm focus:border-primary focus:ring-primary" placeholder="Search student..." type="text">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Student Category</label>
                        <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm font-semibold focus:border-primary focus:ring-primary">
                            <option>All Categories</option>
                            <option>KIDS</option>
                            <option>ADULTS</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Country</label>
                        <select class="w-full rounded border border-outline-variant bg-white py-2 text-sm focus:border-primary focus:ring-primary">
                            <option>All Countries</option>
                            @foreach ($countryOptions as $country)
                                <option>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Select Date</label>
                        <input class="w-full rounded border border-outline-variant bg-white p-2 text-sm focus:border-primary focus:ring-primary" type="date">
                    </div>
                    <div>
                        <button class="h-10 w-full rounded border border-outline-variant px-6 text-sm font-bold text-on-surface-variant transition-all hover:bg-surface active:scale-95">
                            Reset Filters
                        </button>
                    </div>
                </div>
            </section>

            <section class="w-full overflow-hidden rounded-lg border border-surface-container-high bg-surface-container-lowest shadow-sm">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full w-full table-fixed border-collapse text-center">
                        <thead class="bg-surface-container-low">
                            <tr>
                                <th class="w-24 border-b border-r border-surface-container-high py-3"></th>
                                @foreach ($scheduleDays as $day)
                                    <th class="border-b border-surface-container-high px-2 py-3 text-xs font-bold {{ $loop->last ? '' : 'border-r' }} {{ $day['highlighted'] ? 'bg-warning/20 text-primary' : 'text-on-surface-variant' }}">
                                        <div>{{ $day['label'] }}</div>
                                        <div>{{ $day['date'] }}</div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($scheduleSlots as $slot)
                                <tr>
                                    <td class="border-b border-r border-surface-container-high py-2 font-bold text-on-surface-variant">{{ $slot['label'] }}</td>
                                    @foreach ($scheduleDays as $day)
                                        @php
                                            $entry = $scheduleEntries[$slot['key'] . '-' . $day['key']] ?? null;
                                        @endphp
                                        <td class="border-b border-surface-container-high p-1 {{ $loop->last ? '' : 'border-r' }} {{ $day['highlighted'] ? 'bg-warning/10' : '' }}">
                                            <button
                                                type="button"
                                                class="schedule-slot w-full rounded border px-2 py-2 text-[10px] font-bold transition-all hover:opacity-90"
                                                data-slot-key="{{ $slot['key'] }}"
                                                data-day-key="{{ $day['key'] }}"
                                                data-slot-label="{{ $slot['label'] }}"
                                                data-day-label="{{ $day['label'] }}"
                                                data-day-date="{{ $day['date'] }}"
                                                data-entry='@json($entry ?? ['type' => 'open'])'
                                            >
                                                <span class="slot-label block leading-tight"></span>
                                                <span class="slot-subtitle mt-1 block text-[9px] font-semibold uppercase tracking-wider opacity-80"></span>
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <script>
        (() => {
            const roleButtons = Array.from(document.querySelectorAll('.role-toggle'));
            const slotButtons = Array.from(document.querySelectorAll('.schedule-slot'));
            const studentInput = document.getElementById('student-name-input');
            const studentCategoryInput = document.getElementById('student-category-input');
            const selectedSlotLabel = document.getElementById('selected-slot-label');
            const selectedSlotMeta = document.getElementById('selected-slot-meta');
            const selectedSlotStatus = document.getElementById('selected-slot-status');
            const selectedSlotPill = document.getElementById('selected-slot-pill');
            const selectedSlotStudent = document.getElementById('selected-slot-student');
            const roleBadge = document.getElementById('role-badge');
            const permissionHint = document.getElementById('permission-hint');
            const markOpenButton = document.getElementById('mark-open-button');
            const markClosedButton = document.getElementById('mark-closed-button');
            const assignStudentButton = document.getElementById('assign-student-button');
            const clearAssignmentButton = document.getElementById('clear-assignment-button');

            const storageKey = 'speakryt-schedule-editor-v2';
            const elevatedRoles = ['admin', 'manager', 'supervisor'];
            let activeRole = 'teacher';
            let selectedKey = null;

            const defaultEntries = Object.fromEntries(slotButtons.map((button) => {
                const buttonKey = `${button.dataset.slotKey}-${button.dataset.dayKey}`;
                return [buttonKey, JSON.parse(button.dataset.entry)];
            }));

            const savedEntries = (() => {
                try {
                    return JSON.parse(localStorage.getItem(storageKey) || '{}');
                } catch (_error) {
                    return {};
                }
            })();

            const slotEntries = { ...defaultEntries, ...savedEntries };

            const getVisualState = (entry) => {
                if (entry.type === 'booked') {
                    return {
                        label: entry.student || 'Assigned Student',
                        subtitle: entry.category ? `${entry.category} booked` : 'Booked',
                        buttonClass: 'bg-primary/10 text-primary border-primary/30',
                        pillClass: 'bg-primary/10 text-primary',
                        statusText: 'Assigned to student',
                    };
                }

                if (entry.type === 'closed') {
                    return {
                        label: 'CLOSE',
                        subtitle: 'Teacher unavailable',
                        buttonClass: 'bg-error/10 text-error border-error/30',
                        pillClass: 'bg-error/10 text-error',
                        statusText: 'Closed block',
                    };
                }

                return {
                    label: 'OPEN',
                    subtitle: 'Ready for assignment',
                    buttonClass: 'bg-success/10 text-success border-success/30',
                    pillClass: 'bg-success/10 text-success',
                    statusText: 'Open block',
                };
            };

            const persistEntries = () => {
                localStorage.setItem(storageKey, JSON.stringify(slotEntries));
            };

            const updateRoleUI = () => {
                roleButtons.forEach((button) => {
                    const active = button.dataset.role === activeRole;
                    button.classList.toggle('bg-primary', active);
                    button.classList.toggle('text-white', active);
                    button.classList.toggle('shadow-sm', active);
                    button.classList.toggle('text-on-surface-variant', !active);
                });

                const roleLabel = activeRole.charAt(0).toUpperCase() + activeRole.slice(1);
                roleBadge.textContent = `${roleLabel} Mode`;
                permissionHint.textContent = elevatedRoles.includes(activeRole)
                    ? 'Admin, manager, and supervisor can open, close, assign, or clear any block.'
                    : 'Teacher mode can only open or close empty blocks. Assigned slots are locked.';
            };

            const renderSlots = () => {
                slotButtons.forEach((button) => {
                    const buttonKey = `${button.dataset.slotKey}-${button.dataset.dayKey}`;
                    const entry = slotEntries[buttonKey] || { type: 'open' };
                    const visual = getVisualState(entry);
                    const label = button.querySelector('.slot-label');
                    const subtitle = button.querySelector('.slot-subtitle');

                    button.className = `schedule-slot w-full rounded border px-2 py-2 text-[10px] font-bold transition-all hover:opacity-90 ${visual.buttonClass}`;
                    if (buttonKey === selectedKey) {
                        button.classList.add('slot-selected');
                    }

                    label.textContent = visual.label;
                    subtitle.textContent = visual.subtitle;
                });
            };

            const updateSelectedPanel = () => {
                if (!selectedKey) {
                    selectedSlotLabel.textContent = 'Choose a time block';
                    selectedSlotMeta.textContent = 'Click any slot in the grid to manage it.';
                    selectedSlotStatus.textContent = 'No slot selected';
                    selectedSlotPill.textContent = 'Idle';
                    selectedSlotPill.className = 'rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest bg-surface-container-low text-on-surface-variant';
                    selectedSlotStudent.textContent = 'No assigned student yet.';
                    studentInput.value = '';
                    studentCategoryInput.value = 'ADULTS';
                    [markOpenButton, markClosedButton, assignStudentButton, clearAssignmentButton].forEach((button) => {
                        button.disabled = true;
                    });
                    return;
                }

                const button = slotButtons.find((slot) => `${slot.dataset.slotKey}-${slot.dataset.dayKey}` === selectedKey);
                const entry = slotEntries[selectedKey] || { type: 'open' };
                const visual = getVisualState(entry);
                const teacherLocked = activeRole === 'teacher' && entry.type === 'booked';
                const isElevated = elevatedRoles.includes(activeRole);

                selectedSlotLabel.textContent = `${button.dataset.dayLabel}, ${button.dataset.dayDate}`;
                selectedSlotMeta.textContent = button.dataset.slotLabel;
                selectedSlotStatus.textContent = visual.statusText;
                selectedSlotPill.textContent = entry.type === 'booked' ? 'Assigned' : entry.type === 'closed' ? 'Closed' : 'Open';
                selectedSlotPill.className = `rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest ${visual.pillClass}`;
                selectedSlotStudent.textContent = entry.type === 'booked'
                    ? `Assigned student: ${entry.student} (${entry.category || 'ADULTS'})`
                    : 'No assigned student yet.';
                studentInput.value = entry.type === 'booked' ? entry.student : '';
                studentCategoryInput.value = entry.type === 'booked' ? (entry.category || 'ADULTS') : 'ADULTS';

                markOpenButton.disabled = activeRole === 'teacher' ? teacherLocked || entry.type === 'open' : false;
                markClosedButton.disabled = activeRole === 'teacher' ? teacherLocked || entry.type === 'closed' : false;
                assignStudentButton.disabled = !isElevated;
                clearAssignmentButton.disabled = !isElevated || entry.type !== 'booked';
            };

            const selectSlot = (buttonKey) => {
                selectedKey = buttonKey;
                renderSlots();
                updateSelectedPanel();
            };

            roleButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    activeRole = button.dataset.role;
                    updateRoleUI();
                    updateSelectedPanel();
                });
            });

            slotButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    selectSlot(`${button.dataset.slotKey}-${button.dataset.dayKey}`);
                });
            });

            markOpenButton.addEventListener('click', () => {
                if (!selectedKey) return;
                const entry = slotEntries[selectedKey] || { type: 'open' };
                if (activeRole === 'teacher' && entry.type === 'booked') return;
                slotEntries[selectedKey] = { type: 'open' };
                persistEntries();
                renderSlots();
                updateSelectedPanel();
            });

            markClosedButton.addEventListener('click', () => {
                if (!selectedKey) return;
                const entry = slotEntries[selectedKey] || { type: 'open' };
                if (activeRole === 'teacher' && entry.type === 'booked') return;
                slotEntries[selectedKey] = { type: 'closed' };
                persistEntries();
                renderSlots();
                updateSelectedPanel();
            });

            assignStudentButton.addEventListener('click', () => {
                if (!selectedKey || !elevatedRoles.includes(activeRole)) return;
                const studentName = studentInput.value.trim();
                const studentCategory = studentCategoryInput.value;
                if (!studentName) {
                    studentInput.focus();
                    return;
                }
                slotEntries[selectedKey] = { type: 'booked', student: studentName, category: studentCategory };
                persistEntries();
                renderSlots();
                updateSelectedPanel();
            });

            clearAssignmentButton.addEventListener('click', () => {
                if (!selectedKey || !elevatedRoles.includes(activeRole)) return;
                slotEntries[selectedKey] = { type: 'open' };
                persistEntries();
                renderSlots();
                updateSelectedPanel();
            });

            updateRoleUI();
            renderSlots();
            updateSelectedPanel();
            if (slotButtons.length > 0) {
                selectSlot(`${slotButtons[0].dataset.slotKey}-${slotButtons[0].dataset.dayKey}`);
            }
        })();
    </script>
</body>
</html>
