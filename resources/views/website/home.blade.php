<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeakRyt | Master English, Without the Premium Price</title>
    <meta name="description" content="SpeakRyt offers one-on-one online English tutoring, premium classes, and practical English lessons for learners worldwide.">
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
    <style>
        html {
            scroll-behavior: smooth;
        }

        .sr-gradient {
            background:
                radial-gradient(circle at 12% 18%, rgba(243, 255, 79, 0.72), transparent 24rem),
                radial-gradient(circle at 82% 12%, rgba(83, 201, 245, 0.36), transparent 26rem),
                linear-gradient(135deg, #f8fff2 0%, #eefbff 58%, #ffffff 100%);
        }

        .section-wave {
            background:
                radial-gradient(circle at top left, rgba(155, 220, 101, 0.22), transparent 20rem),
                radial-gradient(circle at bottom right, rgba(83, 201, 245, 0.22), transparent 24rem),
                #ffffff;
        }
    </style>
</head>
<body class="bg-white font-sans text-ink antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 lg:px-8">
            <a class="flex items-center gap-3" href="{{ route('website.home') }}" aria-label="SpeakRyt homepage">
                <img class="h-11 w-auto" src="{{ asset('images/website/srlogo.png') }}" alt="SpeakRyt logo">
            </a>

            <nav class="hidden items-center gap-8 text-sm font-extrabold text-ink lg:flex" aria-label="Primary navigation">
                <a class="transition hover:text-skyblue" href="#home">Home</a>
                <a class="transition hover:text-skyblue" href="#pricing">Global Pricing</a>
                <a class="transition hover:text-skyblue" href="#programs">Programs</a>
                <a class="transition hover:text-skyblue" href="#teachers">Teachers</a>
                <a class="transition hover:text-skyblue" href="#faq">FAQs</a>
                <a class="transition hover:text-skyblue" href="#contact">Contact Us</a>
                <a class="transition hover:text-skyblue" href="{{ route('website.register') }}">Register</a>
            </nav>

            <div class="flex items-center gap-3">
                <a class="hidden rounded-full border border-slate-300 px-5 py-3 text-sm font-extrabold text-ink transition hover:-translate-y-0.5 hover:border-skyblue hover:text-skyblue sm:inline-flex" href="{{ route('login') }}">Student Login</a>
                <a class="rounded-full bg-ink px-5 py-3 text-sm font-extrabold text-white shadow-card transition hover:-translate-y-0.5 hover:bg-skyblue" href="{{ route('website.register') }}">REGISTER NOW!</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section id="home" class="sr-gradient overflow-hidden">
            <div class="mx-auto grid min-h-[720px] max-w-7xl items-center gap-10 px-5 py-14 lg:grid-cols-[0.95fr_1.05fr] lg:px-8 lg:py-20">
                <div>
                    <p class="inline-flex rounded-full bg-white px-5 py-2 text-sm font-black uppercase tracking-[0.18em] text-sky-700 shadow-card">#1 ESL Company</p>
                    <p class="mt-8 text-xl font-black uppercase tracking-[0.38em] text-slate-700">SpeakRyt</p>
                    <h1 class="mt-4 max-w-3xl text-5xl font-black leading-[0.98] tracking-tight text-ink sm:text-6xl lg:text-7xl">
                        Master English, Without the Premium Price
                    </h1>
                    <p class="mt-8 max-w-2xl text-xl font-medium leading-9 text-softink">
                        Personalized online English lessons for kids, teens, university students, and professionals around the world.
                    </p>
                    <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                        <a class="inline-flex items-center justify-center rounded-full bg-skyblue px-8 py-4 text-base font-black text-white shadow-glow transition hover:-translate-y-1 hover:bg-ink" href="{{ route('website.register') }}">REGISTER NOW!</a>
                        <a class="inline-flex items-center justify-center rounded-full bg-lemon px-8 py-4 text-base font-black text-ink shadow-card transition hover:-translate-y-1 hover:bg-leaf" href="{{ route('website.register') }}">Book Kids Assessment</a>
                        <a class="inline-flex items-center justify-center rounded-full border-2 border-skyblue bg-white px-8 py-4 text-base font-black text-skyblue transition hover:-translate-y-1 hover:border-ink hover:text-ink" href="{{ route('login') }}">Student Login</a>
                        <a class="inline-flex items-center justify-center rounded-full border-2 border-ink bg-white px-8 py-4 text-base font-black text-ink transition hover:-translate-y-1 hover:border-skyblue hover:text-skyblue" href="#programs">View Programs</a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -left-6 top-8 h-24 w-24 rounded-full bg-lemon/80 blur-2xl"></div>
                    <div class="absolute bottom-8 right-0 h-32 w-32 rounded-full bg-skyblue/30 blur-2xl"></div>
                    <img class="relative mx-auto w-full max-w-2xl drop-shadow-[0_28px_50px_rgba(21,34,53,0.14)]" src="{{ asset('images/website/hero2.svg') }}" alt="SpeakRyt online English lesson illustration">
                </div>
            </div>
        </section>

        <!-- Reasons -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="text-center">
                    <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">Reasons For Choosing SpeakRyt</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-softink">Practical, personal, and affordable English learning for students who want real confidence.</p>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @foreach ([
                        ['icon' => '1:1', 'title' => '1-on-1 Online Tutoring', 'text' => 'At SpeakRyt, we offer tailored one-on-one online English lessons, ensuring you get the attention and support you need to reach your goals at your own pace.'],
                        ['icon' => '$', 'title' => 'Premium Classes', 'text' => 'We provide high-quality English lessons at affordable rates. Enjoy premium tutoring without the high cost, making it accessible to everyone who wants to learn.'],
                        ['icon' => 'UP', 'title' => 'Boost Your Personality', 'text' => 'Learning English with SpeakRyt is not just about grammar. It is about expressing yourself with confidence and improving your communication skills for both personal and professional growth.'],
                        ['icon' => 'ESL', 'title' => 'Expert English Tutors', 'text' => 'Our friendly, professional tutors bring passion and experience to every class, focusing on your unique needs and goals.'],
                    ] as $reason)
                        <article class="group rounded-[2rem] border border-slate-200 bg-white p-8 shadow-card transition duration-300 hover:-translate-y-1 hover:border-skyblue/50 hover:shadow-glow">
                            <div class="flex items-start gap-5">
                                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-lemon via-leaf to-skyblue text-sm font-black text-ink shadow-card">{{ $reason['icon'] }}</span>
                                <div>
                                    <h3 class="text-2xl font-black text-ink">{{ $reason['title'] }}</h3>
                                    <p class="mt-3 text-base leading-8 text-softink">{{ $reason['text'] }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Kids English Preview -->
        <section class="bg-cream py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 lg:grid-cols-[0.95fr_1.05fr] lg:px-8">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Kids English</p>
                    <h2 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Fun, patient, and structured lessons for young learners</h2>
                    <p class="mt-5 text-lg leading-9 text-softink">SpeakRyt helps children build English confidence through friendly one-on-one classes, guided speaking practice, vocabulary support, and gentle correction.</p>
                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            'Child-friendly teachers',
                            'Speaking confidence',
                            'Vocabulary building',
                            'Parent progress updates',
                        ] as $benefit)
                            <div class="rounded-2xl bg-white px-5 py-4 text-sm font-black text-ink shadow-card ring-1 ring-slate-200">{{ $benefit }}</div>
                        @endforeach
                    </div>
                    <a class="mt-8 inline-flex rounded-full bg-ink px-8 py-4 text-base font-black text-white shadow-card transition hover:-translate-y-1 hover:bg-skyblue" href="{{ route('website.register') }}">Book a Free Kids Assessment</a>
                </div>

                <div class="rounded-[2rem] bg-white p-4 shadow-card ring-1 ring-slate-200">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-ink">
                        <video id="kids-preview-video" class="aspect-video h-auto w-full bg-ink object-contain" controls controlsList="nofullscreen nodownload noremoteplayback" disablePictureInPicture playsinline preload="metadata" poster="{{ asset('images/website/kids-video-poster.png') }}" aria-label="SpeakRyt Kids English preview video">
                            <source src="{{ asset('videos/website/kids-english-preview.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission / Vision -->
        <section class="section-wave py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 lg:grid-cols-[0.92fr_1.08fr] lg:px-8">
                <div>
                    <img class="mx-auto w-full max-w-xl drop-shadow-[0_20px_45px_rgba(21,34,53,0.12)]" src="{{ asset('images/website/inter-3.svg') }}" alt="International English learning illustration">
                </div>

                <div class="space-y-6">
                    <article class="rounded-[2rem] border border-slate-200 bg-white/90 p-8 shadow-card backdrop-blur">
                        <h2 class="text-4xl font-black tracking-tight text-ink">Our Mission</h2>
                        <p class="mt-5 text-lg leading-9 text-softink">At SpeakRyt, we empower kids, teens, university students, and professionals with practical English skills for school, confidence, career growth, and global communication.</p>
                    </article>
                    <article class="rounded-[2rem] border border-slate-200 bg-white/90 p-8 shadow-card backdrop-blur">
                        <h2 class="text-4xl font-black tracking-tight text-ink">Our Vision</h2>
                        <p class="mt-5 text-lg leading-9 text-softink">To be a leading online ESL platform for learners of all ages - helping children, teens, and adults use English as a bridge to confidence, opportunity, and global connection.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Programs -->
        <section id="programs" class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Personalized English Lessons</p>
                        <h2 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Choose the program that fits your goal</h2>
                    </div>
                    <a class="rounded-full bg-lemon px-6 py-3 text-sm font-black text-ink shadow-card transition hover:-translate-y-1 hover:bg-leaf" href="#pricing">View Pricing Flow</a>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['title' => 'Kids English', 'img' => 'images/website/course-conversation-ai.png'],
                        ['title' => 'Teen English', 'img' => 'images/website/course-grammar-ai.png'],
                        ['title' => 'Adult English', 'img' => 'images/website/course-cefr-ai.png'],
                        ['title' => 'Business English', 'img' => 'images/website/course-business-ai.png'],
                        ['title' => 'IELTS Preparation', 'img' => 'images/website/course-ielts-ai.png'],
                        ['title' => 'TOEFL Preparation', 'img' => 'images/website/course-toefl-ai.png'],
                        ['title' => 'Interview Preparation', 'img' => 'images/website/course-interview-ai.png'],
                        ['title' => 'Conversational English', 'img' => 'images/website/course-conversation-ai.png'],
                    ] as $program)
                        <article class="group overflow-hidden rounded-[1.75rem] bg-white shadow-card ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-glow">
                            <div class="aspect-[4/3] overflow-hidden">
                                <img class="h-full w-full object-cover transition duration-700 group-hover:scale-105" src="{{ asset($program['img']) }}" alt="{{ $program['title'] }}">
                            </div>
                            <div class="p-5">
                                <h3 class="text-xl font-black text-ink">{{ $program['title'] }}</h3>
                                <p class="mt-3 text-sm leading-6 text-softink">Personalized classes with clear correction, speaking practice, and flexible online scheduling.</p>
                                <a class="mt-5 inline-flex rounded-full bg-ink px-5 py-2.5 text-sm font-black text-white transition hover:bg-skyblue" href="#contact">Learn More</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Regional Pricing -->
        <section id="pricing" class="section-wave py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Regional Pricing</p>
                    <h2 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Pricing is shown after registration</h2>
                    <p class="mt-4 text-lg leading-8 text-softink">SpeakRyt shows package options based on the learner's registered country and program type. This keeps pricing private, relevant, and easier to understand.</p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['title' => 'Register First', 'text' => 'Students complete the registration form so we can identify the correct country and learner category.'],
                        ['title' => 'View Matching Packages', 'text' => 'After registration, the student sees only the pricing group that applies to their location.'],
                        ['title' => 'Final Review', 'text' => 'SpeakRyt confirms the final package after checking the assessment, schedule, and program needs.'],
                    ] as $step)
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-7 shadow-card">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-lemon via-leaf to-skyblue text-sm font-black text-ink">{{ $loop->iteration }}</span>
                            <h3 class="mt-5 text-2xl font-black text-ink">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-base leading-8 text-softink">{{ $step['text'] }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10 rounded-[2rem] bg-ink p-8 text-center text-white shadow-card">
                    <h3 class="text-3xl font-black">Ready to see your package options?</h3>
                    <p class="mx-auto mt-3 max-w-2xl text-base font-semibold leading-7 text-slate-300">Submit the registration form and we will show pricing that matches your registered country. Public visitors cannot compare all country pricing from the homepage.</p>
                    <a class="mt-6 inline-flex rounded-full bg-skyblue px-8 py-4 text-base font-black text-white transition hover:-translate-y-1 hover:bg-white hover:text-ink" href="{{ route('website.register') }}">Register to View Pricing</a>
                </div>
            </div>
        </section>

        <!-- Teachers -->
        <section id="teachers" class="bg-mist py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="text-center">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">The Heart of Our Company</p>
                    <h2 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Our Teachers</h2>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['name' => 'Teacher Jay', 'role' => 'Senior Teacher', 'img' => 'images/website/teacher-black-2.png'],
                        ['name' => 'Teacher Van', 'role' => 'CEO - Founder', 'img' => 'images/website/teacher-square.png'],
                        ['name' => 'Teacher Jeff', 'role' => 'Senior Teacher', 'img' => 'images/website/teacher-2.png'],
                        ['name' => 'Teacher Jane', 'role' => 'Senior Teacher', 'img' => 'images/website/teacher-3.png'],
                    ] as $teacher)
                        <article class="overflow-hidden rounded-[2rem] bg-white shadow-card ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-glow">
                            <div class="aspect-square bg-gradient-to-br from-lemon/50 via-white to-skyblue/20">
                                <img class="h-full w-full object-cover" src="{{ asset($teacher['img']) }}" alt="{{ $teacher['name'] }}">
                            </div>
                            <div class="p-6 text-center">
                                <h3 class="text-2xl font-black text-ink">{{ $teacher['name'] }}</h3>
                                <p class="mt-2 text-sm font-extrabold uppercase tracking-[0.16em] text-skyblue">{{ $teacher['role'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="text-center">
                    <h2 class="text-4xl font-black tracking-tight text-ink sm:text-5xl">What learners say</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-softink">Real-world English confidence for children, teens, and adult learners.</p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['quote' => 'My daughter used to be shy when speaking English. Her teacher is patient and cheerful, and now she looks forward to every class.', 'name' => 'Lina Zhang', 'role' => 'Parent of a Kids English student'],
                        ['quote' => 'My teacher is very professional and really understands how to guide students. The lessons are not too basic - they are designed to help me improve my English while learning something meaningful.', 'name' => 'Chen Wei', 'role' => 'Adult learner from Guangzhou'],
                        ['quote' => 'I am not just learning grammar or vocabulary. I am learning real topics that I care about. It feels like I am building my English skills and career knowledge at the same time.', 'name' => 'Wei Lin', 'role' => 'Marketing specialist from Taipei'],
                        ['quote' => 'The topic was mind-blowing. I learned how to build my confidence and improve my sales negotiation skills. Every lesson helped me grow as a communicator and as a professional.', 'name' => 'Riku Morinaga', 'role' => 'Sales executive from Tokyo'],
                        ['quote' => 'Thanks to Teacher Van’s clear guidance and practical lessons, I nailed the interview. I feel more confident now, not just in English, but in myself.', 'name' => 'Dong Wook', 'role' => 'Jobseeker from Incheon'],
                        ['quote' => 'Each class feels like a safe space where I can practice, make mistakes, and grow. I am now more confident speaking with foreign clients and making small talk.', 'name' => 'Bao Vy', 'role' => 'Customer support specialist from Hanoi'],
                    ] as $testimonial)
                        <figure class="rounded-[2rem] border border-slate-200 bg-cream p-7 shadow-card">
                            <blockquote class="text-base leading-8 text-ink">"{{ $testimonial['quote'] }}"</blockquote>
                            <figcaption class="mt-6 border-t border-slate-200 pt-5">
                                <p class="text-lg font-black text-ink">{{ $testimonial['name'] }}</p>
                                <p class="mt-1 text-sm font-bold text-softink">{{ $testimonial['role'] }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="section-wave py-20">
            <div class="mx-auto max-w-5xl px-5 lg:px-8">
                <div class="rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-slate-200">
                    <div class="text-center">
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">FAQs</p>
                        <h2 class="mt-3 text-4xl font-black tracking-tight text-ink">Frequently Asked Questions</h2>
                    </div>
                    <div class="mt-8 space-y-4">
                        @foreach ([
                            ['q' => 'What is SpeakRyt?', 'a' => 'SpeakRyt is an online English tutoring academy that helps students and professionals improve speaking, grammar, pronunciation, and real-life communication.'],
                            ['q' => 'How do I register?', 'a' => 'Click Register Now or scan one of our official contact QR codes. Our team will guide you through assessment, schedule, and lesson options.'],
                            ['q' => 'What types of English lessons do you offer?', 'a' => 'We offer CEFR, Business English, Sales English, IELTS, TOEFL, Grammar Workshop, Interview Preparation, and Conversational English.'],
                            ['q' => 'Are lessons one-on-one?', 'a' => 'Yes. SpeakRyt focuses on one-on-one tutoring so learners receive personal feedback and support.'],
                            ['q' => 'Can I choose my schedule?', 'a' => 'Yes. We help match students with available teachers based on goals, level, and preferred time.'],
                        ] as $faq)
                            <details class="group rounded-2xl border border-slate-200 bg-mist p-5">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-ink">
                                    {{ $faq['q'] }}
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-skyblue transition group-open:rotate-45">+</span>
                                </summary>
                                <p class="mt-4 leading-7 text-softink">{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-skyblue">Contact SpeakRyt</p>
                    <h2 class="mt-3 text-4xl font-black tracking-tight text-ink sm:text-5xl">Get in Touch with SpeakRyt</h2>
                    <p class="mt-4 text-lg leading-8 text-softink">Connect with us through your preferred platform to ask questions, book a free assessment, or learn more about our English programs.</p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['title' => 'WeChat', 'description' => 'Scan to connect with SpeakRyt on WeChat.', 'image' => 'images/contact/wechat.jpeg', 'icon' => 'W'],
                        ['title' => 'WhatsApp', 'description' => 'Scan to chat with SpeakRyt on WhatsApp.', 'image' => 'images/contact/whatsapp-qr.png', 'icon' => 'WA'],
                        ['title' => 'Facebook', 'description' => 'Scan to visit and follow the SpeakRyt Facebook Page.', 'image' => 'images/contact/facebook-qr.png', 'icon' => 'f'],
                    ] as $contact)
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-card transition duration-300 hover:-translate-y-1 hover:shadow-glow">
                            <div class="flex items-center gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-lemon via-leaf to-skyblue text-sm font-black text-ink">{{ $contact['icon'] }}</span>
                                <div>
                                    <h3 class="text-2xl font-black text-ink">{{ $contact['title'] }}</h3>
                                    <p class="mt-1 text-sm font-medium text-softink">{{ $contact['description'] }}</p>
                                </div>
                            </div>
                            <div class="mt-6 rounded-3xl bg-mist p-4">
                                <div class="mx-auto aspect-square max-w-[340px] rounded-2xl bg-white p-2 shadow-card">
                                    <img class="h-full w-full object-contain" src="{{ asset($contact['image']) }}" alt="Official SpeakRyt {{ $contact['title'] }} QR code" loading="lazy">
                                </div>
                            </div>
                            <p class="mt-5 text-center text-sm font-black text-skyblue">Scan with your mobile device</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-ink text-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 px-5 py-8 text-sm sm:flex-row lg:px-8">
            <p class="font-bold">© {{ now()->year }} SpeakRyt. Master English, Without the Premium Price.</p>
            <p class="text-slate-300">Home · Global Pricing · Contact Us</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kidsVideo = document.getElementById('kids-preview-video');

            if (!kidsVideo) {
                return;
            }

            kidsVideo.addEventListener('dblclick', (event) => {
                event.preventDefault();
            });

            kidsVideo.addEventListener('webkitbeginfullscreen', () => {
                if (typeof kidsVideo.webkitExitFullscreen === 'function') {
                    kidsVideo.webkitExitFullscreen();
                }
            });

            document.addEventListener('fullscreenchange', () => {
                if (document.fullscreenElement === kidsVideo || kidsVideo.contains(document.fullscreenElement)) {
                    document.exitFullscreen();
                }
            });
        });
    </script>
</body>
</html>
