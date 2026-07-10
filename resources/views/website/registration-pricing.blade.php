<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recommended Packages | SpeakRyt</title>
    <meta name="description" content="SpeakRyt recommended packages after student registration.">
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
</head>
<body class="bg-white font-sans text-ink antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 lg:px-8">
            <a class="flex items-center gap-3" href="{{ route('website.home') }}" aria-label="SpeakRyt homepage">
                <img class="h-11 w-auto" src="{{ asset('images/website/srlogo.png') }}" alt="SpeakRyt logo">
            </a>
            <a class="rounded-full border border-slate-300 px-5 py-3 text-sm font-extrabold text-ink transition hover:-translate-y-0.5 hover:border-skyblue hover:text-skyblue" href="{{ route('website.home') }}">Back to Website</a>
        </div>
    </header>

    <main class="bg-gradient-to-br from-cream via-mist to-white py-16">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            @if (session('status'))
                <div class="mb-8 rounded-[1.5rem] border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold leading-6 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-8 rounded-[1.5rem] border border-red-200 bg-red-50 px-6 py-4 text-sm font-bold leading-6 text-red-800">
                    Please choose a valid package and payment method.
                </div>
            @endif

            <section class="rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-slate-200">
                <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Private Pricing Preview</p>
                        <h1 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Recommended packages for {{ $country }}</h1>
                        <p class="mt-4 max-w-3xl text-lg leading-8 text-softink">
                            These package options are shown after registration and are based on the student's registered country. Final package assignment is still reviewed by SpeakRyt after assessment and scheduling.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-mist px-5 py-4">
                        <p class="text-xs font-black uppercase tracking-wider text-softink">Student</p>
                        <p class="mt-1 text-lg font-black text-ink">{{ $registration['student_first_name'] ?? 'Student' }} {{ $registration['student_last_name'] ?? '' }}</p>
                        <p class="mt-1 text-sm font-bold text-softink">{{ $registration['program_interest'] ?? 'Program pending review' }}</p>
                    </div>
                </div>
            </section>

            <section class="mt-8 rounded-[2rem] bg-white p-6 shadow-card ring-1 ring-slate-200">
                <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end">
                    <div>
                        <h2 class="text-3xl font-black text-ink">{{ $pricingGroup['label'] }}</h2>
                        <p class="mt-2 text-base font-semibold leading-7 text-softink">{{ $pricingGroup['description'] }}</p>
                    </div>
                    <span class="w-fit rounded-full bg-ink px-5 py-2 text-sm font-black text-white">Shown after registration</span>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-2">
                    @foreach ($pricingGroup['categories'] as $category => $categoryData)
                        @php($isKidsCategory = $category === 'Kids English')
                        <article class="overflow-hidden rounded-[1.5rem] border {{ $isKidsCategory ? 'border-yellow-200 bg-yellow-50/80 shadow-[0_18px_44px_rgba(250,204,21,0.14)]' : 'border-slate-200 bg-white' }}">
                            <div class="{{ $isKidsCategory ? 'bg-gradient-to-r from-yellow-200 via-cream to-lemon/80 text-ink' : 'bg-ink text-white' }} px-6 py-5">
                                @if ($isKidsCategory)
                                    <span class="mb-2 inline-flex rounded-full bg-white/80 px-3 py-1 text-xs font-black uppercase tracking-wider text-yellow-700">Kids Package</span>
                                @endif
                                <h3 class="text-2xl font-black">{{ $category }}</h3>
                                <p class="mt-1 text-sm font-bold {{ $isKidsCategory ? 'text-yellow-800' : 'text-slate-300' }}">{{ $categoryData['duration'] }} per lesson</p>
                            </div>
                            <div class="divide-y divide-slate-200">
                                @foreach ($categoryData['packages'] as $package)
                                    <div class="grid gap-4 p-5 xl:grid-cols-[1fr_auto] xl:items-center">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h4 class="text-xl font-black text-ink">{{ $package['tier'] }}</h4>
                                                @if ($package['discount'] !== '-')
                                                    <span class="rounded-full bg-leaf/20 px-3 py-1 text-xs font-black text-green-700">{{ $package['discount'] }}</span>
                                                @endif
                                            </div>
                                            <p class="mt-2 text-sm font-bold text-softink">{{ $package['lessons'] }} lessons · {{ $package['validity'] }}</p>
                                        </div>
                                        <div class="space-y-3 xl:min-w-[230px] xl:text-right">
                                            <p class="text-left text-3xl font-black text-skyblue xl:text-right">{{ $package['price'] }}</p>
                                            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-1">
                                                @foreach (['PayPal', 'Debit/Credit Card via PayPal'] as $paymentMethod)
                                                    <form action="{{ route('website.registration-purchase') }}" method="POST">
                                                        @csrf
                                                        <input name="category" type="hidden" value="{{ $category }}">
                                                        <input name="tier" type="hidden" value="{{ $package['tier'] }}">
                                                        <input name="payment_method" type="hidden" value="{{ $paymentMethod }}">
                                                        <button class="w-full rounded-full border px-4 py-2.5 text-xs font-black uppercase tracking-wider transition hover:-translate-y-0.5 {{ $paymentMethod === 'PayPal' ? 'border-skyblue/40 bg-skyblue/15 text-sky-800 hover:bg-skyblue/25' : 'border-leaf/50 bg-leaf/20 text-green-800 hover:bg-leaf/30' }}" type="submit">
                                                            {{ $paymentMethod === 'PayPal' ? 'Pay with PayPal' : 'Debit/Credit Card via PayPal' }}
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            @if ($purchaseIntent)
                <section class="mt-8 rounded-[2rem] border border-skyblue/30 bg-white p-8 shadow-card">
                    <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Checkout Summary</p>
                            <h2 class="mt-2 text-3xl font-black text-ink">{{ $purchaseIntent['tier'] }} · {{ $purchaseIntent['category'] }}</h2>
                            <p class="mt-2 text-base font-semibold leading-7 text-softink">
                                {{ $purchaseIntent['lessons'] }} lessons · {{ $purchaseIntent['duration'] }} per lesson · {{ $purchaseIntent['validity'] }}
                            </p>
                        </div>
                        <div class="rounded-[1.5rem] bg-mist p-5 text-left lg:min-w-[300px]">
                            <p class="text-xs font-black uppercase tracking-wider text-softink">Selected Payment</p>
                            <p class="mt-1 text-xl font-black text-ink">{{ $purchaseIntent['payment_method'] }}</p>
                            <p class="mt-3 text-xs font-black uppercase tracking-wider text-softink">Amount</p>
                            <p class="mt-1 text-4xl font-black text-skyblue">{{ $purchaseIntent['price'] }}</p>
                        </div>
                    </div>
                    <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-bold leading-6 text-amber-800">
                        Payment gateway connection is ready for setup. PayPal and debit/credit card payments will both be processed through your PayPal account once credentials are added.
                    </div>
                </section>
            @endif

            <section class="mt-8 rounded-[2rem] bg-ink p-8 text-center text-white shadow-card">
                <h2 class="text-3xl font-black">Next step: SpeakRyt review</h2>
                <p class="mx-auto mt-3 max-w-2xl text-base font-semibold leading-7 text-slate-300">Our team will review your registration, confirm the correct package, and contact you through your preferred platform.</p>
                <a class="mt-6 inline-flex rounded-full bg-skyblue px-8 py-4 text-base font-black text-white transition hover:-translate-y-1 hover:bg-white hover:text-ink" href="{{ route('website.home') }}#contact">Contact SpeakRyt</a>
            </section>
        </div>
    </main>
</body>
</html>
