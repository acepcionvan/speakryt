<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeakRyt Portal Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#022448',
                        accent: '#00aeef',
                        surface: '#f7f9fb',
                        muted: '#64748b',
                        line: '#d8e1ea',
                        danger: '#ba1a1a',
                    },
                    fontFamily: {
                        display: ['Hanken Grotesk', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="h-full bg-[#eef3f8] font-sans text-slate-900 antialiased">
    <main class="flex min-h-full">
        <section class="hidden min-h-full w-[44%] flex-col justify-between bg-[#244166] px-12 py-10 text-white lg:flex">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white text-2xl font-bold text-[#244166]">S</div>
                <div>
                    <p class="font-display text-2xl font-bold tracking-wide">SPEAKRYT</p>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-white/70">Secure Portal</p>
                </div>
            </div>

            <div class="max-w-xl">
                <p class="mb-4 inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-sky-100">SpeakRyt Portal</p>
                <h1 class="font-display text-5xl font-bold leading-tight">Access the right workspace for your SpeakRyt account.</h1>
            </div>

            <div class="grid grid-cols-3 gap-4 border-t border-white/15 pt-8">
                <div>
                    <p class="font-display text-3xl font-bold">3.3k</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-white/60">Lessons</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-bold">110</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-white/60">Modules</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-bold">24/7</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-white/60">Access</p>
                </div>
            </div>
        </section>

        <section class="flex min-h-full flex-1 items-center justify-center px-5 py-10 sm:px-8">
            <div class="w-full max-w-[440px]">
                <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#244166] text-2xl font-bold text-white">S</div>
                    <div>
                        <p class="font-display text-2xl font-bold tracking-wide text-primary">SPEAKRYT</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-muted">Secure Portal</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-line bg-white p-8 shadow-[0_24px_70px_rgba(15,23,42,0.12)] sm:p-10">
                    <div class="mb-8">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-accent">Secure Access</p>
                        <h2 class="font-display text-3xl font-bold text-primary">Welcome back</h2>
                        <p class="mt-2 text-sm leading-6 text-muted">Students, teachers, staff, managers, and admins are sent to the correct dashboard after login.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 flex gap-3 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-danger">
                            <span class="material-symbols-outlined text-[20px]">error</span>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form class="space-y-5" action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div>
                            <label class="mb-2 block text-sm font-bold text-primary" for="email">Email Address</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted">mail</span>
                                <input class="h-12 w-full rounded-lg border-line bg-white pl-10 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-accent focus:ring-accent/20" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="Enter your email address" required autofocus>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label class="block text-sm font-bold text-primary" for="password">Password</label>
                                <a class="text-sm font-semibold text-[#006397] transition-colors hover:text-primary" href="#">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted">lock</span>
                                <input class="h-12 w-full rounded-lg border-line bg-white pl-10 pr-12 text-sm text-slate-900 placeholder:text-slate-400 focus:border-accent focus:ring-accent/20" id="password" name="password" type="password" autocomplete="current-password" placeholder="Enter your password" required>
                                <button class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-md text-muted transition-colors hover:bg-slate-100 hover:text-primary" type="button" data-password-toggle aria-label="Show password">
                                    <span class="material-symbols-outlined text-[20px]" data-password-icon>visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <label class="flex items-center gap-2 text-sm font-medium text-muted" for="remember">
                                <input class="h-4 w-4 rounded border-line text-accent focus:ring-accent/20" id="remember" name="remember" type="checkbox" value="1">
                                Remember me
                            </label>
                            <span class="hidden text-xs font-bold uppercase tracking-wider text-slate-400 sm:inline">Protected Portal</span>
                        </div>

                        <button class="group flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition-all hover:bg-[#173b5e] active:scale-[0.99]" type="submit">
                            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-0.5">login</span>
                            Log In
                        </button>
                    </form>
                </div>

                <p class="mt-6 text-center text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">SpeakRyt ESL Management System</p>
            </div>
        </section>
    </main>

    <script>
        const toggleButton = document.querySelector('[data-password-toggle]');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.querySelector('[data-password-icon]');

        toggleButton?.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            passwordIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            toggleButton.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    </script>
</body>
</html>
