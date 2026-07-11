<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeakRyt Team Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#022448',
                        accent: '#00aeef',
                        surface: '#f4f8fc',
                        muted: '#64748b',
                        line: '#d8e1ea',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-surface font-sans text-slate-900">
    <header class="border-b border-line bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-4">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-accent">SpeakRyt Team Portal</p>
                <h1 class="mt-1 text-2xl font-black text-primary">{{ ucfirst($role) }} Workspace</h1>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="rounded-full bg-primary px-5 py-2.5 text-sm font-bold text-white transition hover:bg-accent" type="submit">Log Out</button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-5 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-line">
            <p class="text-sm font-bold text-muted">Logged in as</p>
            <p class="mt-1 text-lg font-black text-primary">{{ $email }}</p>
            <p class="mt-3 max-w-3xl text-sm leading-6 text-muted">
                This workspace is separated from the admin dashboard. Sensitive revenue, pricing, company earnings, and other people's payroll information are hidden from non-admin accounts.
            </p>
        </section>

        <section class="mt-6 grid gap-4 md:grid-cols-2">
            @foreach ($cards as $card)
                <article class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-black text-primary">{{ $card['title'] }}</h2>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $card['description'] }}</p>
                </article>
            @endforeach
        </section>
    </main>
</body>
</html>
