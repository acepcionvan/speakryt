@php
    $activeSection = $activeSection ?? 'students';
    $sidebarClass = $sidebarClass ?? 'hidden lg:flex';
    $currentRole = session('user_role', app()->environment('local') ? 'admin' : null);
    $items = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-table-columns', 'href' => route('home'), 'admin_only' => true],
        ['key' => 'students', 'label' => 'Students', 'icon' => 'fa-id-card', 'href' => route('students.index')],
        ['key' => 'teachers', 'label' => 'Teachers', 'icon' => 'fa-chalkboard-user', 'href' => route('teachers.index')],
        ['key' => 'staff', 'label' => 'Staff', 'icon' => 'fa-id-badge', 'href' => route('staff.index')],
        ['key' => 'schedule', 'label' => 'Schedule Editor', 'icon' => 'fa-calendar-check', 'href' => route('schedule.index')],
        ['key' => 'payments', 'label' => 'Payments & Refunds', 'icon' => 'fa-user-tag', 'href' => route('payments.index')],
        ['key' => 'packages', 'label' => 'Packages & Pricing', 'icon' => 'fa-layer-group', 'href' => route('packages.index')],
        ['key' => 'lessons', 'label' => 'Lessons', 'icon' => 'fa-earth-americas', 'href' => route('lessons.index')],
        ['key' => 'documents', 'label' => 'Company Documents', 'icon' => 'fa-file-lines', 'href' => route('documents.index')],
        [
            'key' => 'communication',
            'label' => 'Communication',
            'icon' => 'fa-comments',
            'href' => route('communication.index'),
            'children' => [
                ['key' => 'feedback', 'label' => 'Feedback Entry', 'href' => route('communication.feedback-entry')],
                ['key' => 'slack', 'label' => 'Slack', 'href' => route('communication.index', ['tool' => 'slack'])],
            ],
        ],
        [
            'key' => 'message-center',
            'label' => 'Message Center',
            'icon' => 'fa-message',
            'href' => route('message-center.index'),
            'admin_only' => true,
            'children' => [
                ['key' => 'whatsapp', 'label' => 'WhatsApp', 'href' => route('message-center.index', ['channel' => 'whatsapp']), 'admin_only' => true],
                ['key' => 'email', 'label' => 'Email', 'href' => route('message-center.index', ['channel' => 'email']), 'admin_only' => true],
                ['key' => 'wechat', 'label' => 'WeChat Generator', 'href' => route('message-center.index', ['channel' => 'wechat']), 'admin_only' => true],
                ['key' => 'facebook', 'label' => 'Facebook Message', 'href' => route('message-center.index', ['channel' => 'facebook']), 'admin_only' => true],
            ],
        ],
        ['key' => 'users', 'label' => 'User Management', 'icon' => 'fa-user-plus', 'href' => route('users.index'), 'admin_only' => true],
        ['key' => 'profile', 'label' => 'My Profile', 'icon' => 'fa-id-card-clip', 'href' => route('profile.index')],
    ];
@endphp

<aside class="{{ $sidebarClass }} w-56 flex-shrink-0 flex-col bg-[#244166] text-white">
    <div class="flex h-[72px] items-center border-b border-white/10 px-4 py-3">
        <a class="flex h-11 w-full items-center rounded-lg bg-white px-3 shadow-sm" href="{{ route('home') }}" aria-label="SpeakRyt dashboard">
            <img class="h-8 w-auto object-contain" src="{{ asset('images/website/srlogo.png') }}" alt="SpeakRyt logo">
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-2">
        @foreach ($items as $item)
            @continue(($item['admin_only'] ?? false) && $currentRole !== 'admin')
            @if ($loop->first)
                <div class="mb-2">
                    <a class="nav-item {{ $activeSection === $item['key'] ? 'nav-item-active bg-[#00aeef]' : '' }} flex items-center px-4 py-2.5 transition-colors" href="{{ $item['href'] }}">
                        <i class="fa-solid {{ $item['icon'] }} mr-2.5 w-5 text-[13px]"></i>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ $item['label'] }}</span>
                    </a>
                    <div class="mx-4 my-1 w-20 border-t border-white/20"></div>
                </div>
            @elseif ($item['key'] === 'schedule')
                <div class="mb-2">
                    <a class="nav-item {{ $activeSection === $item['key'] ? 'nav-item-active bg-[#00aeef]' : '' }} flex items-center px-4 py-2.5 transition-colors" href="{{ $item['href'] }}">
                        <i class="fa-solid {{ $item['icon'] }} mr-2.5 w-5 text-[13px]"></i>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ $item['label'] }}</span>
                    </a>
                    <div class="mx-4 mb-1 mt-2 w-20 border-t border-white/20"></div>
                </div>
            @else
                <div class="mb-1">
                    <a class="nav-item {{ $activeSection === $item['key'] ? 'nav-item-active bg-[#00aeef]' : '' }} flex items-center px-4 py-2.5 transition-colors" href="{{ $item['href'] }}">
                        <i class="fa-solid {{ $item['icon'] }} mr-2.5 w-5 text-[13px]"></i>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ $item['label'] }}</span>
                    </a>
                    @if (! empty($item['children']))
                        <div class="ml-8 mr-2 mt-1 space-y-0.5 border-l border-white/15 pl-3">
                            @foreach ($item['children'] as $child)
                                @continue(($child['admin_only'] ?? false) && $currentRole !== 'admin')
                                <a class="block rounded px-2 py-1.5 text-[10px] font-bold uppercase tracking-wide text-white/75 transition-colors hover:bg-white/10 hover:text-white" href="{{ $child['href'] }}">
                                    {{ $child['label'] }}
                                    @if ($child['admin_only'] ?? false)
                                        <span class="ml-1 rounded bg-white/15 px-1.5 py-0.5 text-[8px] text-white/80">Admin</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </nav>

    <div class="mt-auto border-t border-white/10 p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-600 py-2 text-xs font-bold text-white shadow-lg transition-all hover:bg-gray-500 active:scale-95" type="submit">
            <i class="fa-solid fa-door-open"></i>
            <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
