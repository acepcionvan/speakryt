<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function login(): RedirectResponse
    {
        return redirect()->route('student.login');
    }

    public function portalLogin(): View
    {
        return view('auth.login', [
            'loginType' => 'portal',
            'formAction' => route('portal.login.submit'),
            'pageTitle' => 'SpeakRyt Team Portal Login',
            'eyebrow' => 'Team Portal',
            'heading' => 'Internal team access',
            'description' => 'Admin, teachers, staff, and managers use this private portal to access their assigned workspace.',
            'sideBadge' => 'SpeakRyt Team Portal',
            'sideHeading' => 'Private workspace for SpeakRyt team accounts.',
            'systemLabel' => 'SpeakRyt ESL Management System',
            'emailLabel' => 'Work Email Address',
            'emailPlaceholder' => 'Enter your SpeakRyt work email',
            'portalNote' => 'Protected Team Portal',
            'alternateHref' => route('student.login'),
            'alternateText' => 'Student login',
        ]);
    }

    public function studentLogin(): View
    {
        return view('auth.login', [
            'loginType' => 'student',
            'formAction' => route('student.login.submit'),
            'pageTitle' => 'SpeakRyt Student Login',
            'eyebrow' => 'Student Access',
            'heading' => 'Welcome, SpeakRyt learner',
            'description' => 'Students can view lessons, teacher feedback, packages, remaining credits, and lesson materials.',
            'sideBadge' => 'SpeakRyt Student Portal',
            'sideHeading' => 'Your lessons, packages, and feedback in one simple place.',
            'systemLabel' => 'SpeakRyt Student Dashboard',
            'emailLabel' => 'Student Email Address',
            'emailPlaceholder' => 'Enter your student email',
            'portalNote' => 'Student Portal',
            'alternateHref' => route('portal.login'),
            'alternateText' => 'Team portal',
        ]);
    }

    public function loginSubmit(Request $request): RedirectResponse
    {
        return $this->portalLoginSubmit($request);
    }

    public function portalLoginSubmit(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $account = $this->teamAccountForCredentials($credentials['email'], $credentials['password']);

        if (! $account) {
            return back()
                ->withErrors(['email' => 'Invalid email address or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'user_email' => $account['email'],
            'user_role' => $account['role'],
        ]);

        if ($account['role'] !== 'admin') {
            return redirect()
                ->route($this->roleLandingRoute($account['role']))
                ->with('status', 'Welcome back to SpeakRyt. Your account does not have CEO dashboard access.');
        }

        return redirect()
            ->route('home')
            ->with('status', 'Welcome back to SpeakRyt.');
    }

    public function studentLoginSubmit(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $account = $this->studentAccountForCredentials($credentials['email'], $credentials['password']);

        if (! $account) {
            return back()
                ->withErrors(['email' => 'Invalid student email address or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'user_email' => $account['email'],
            'user_role' => 'student',
        ]);

        return redirect()
            ->route('student.dashboard')
            ->with('status', 'Welcome back to your SpeakRyt student dashboard.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $role = $request->session()->get('user_role');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route($role === 'student' ? 'student.login' : 'portal.login')
            ->with('status', 'You have been logged out.');
    }

    public function websiteHome(): View
    {
        return view('website.home');
    }

    public function studentRegistration(): View
    {
        return view('website.register', [
            'countries' => $this->countryOptions(),
        ]);
    }

    public function studentRegistrationSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_first_name' => ['required', 'string', 'max:80'],
            'student_last_name' => ['required', 'string', 'max:80'],
            'student_age' => ['required', 'integer', 'min:3', 'max:90'],
            'learner_type' => ['required', 'in:Kids,Teens,Adults,University Student,Professional'],
            'english_level' => ['required', 'in:Beginner,A1,A2,B1,B2,C1,C2,Not sure'],
            'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:40'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:80'],
            'city' => ['nullable', 'string', 'max:100'],
            'detected_country' => ['nullable', 'string', 'max:80'],
            'detected_country_code' => ['nullable', 'string', 'max:10'],
            'detected_timezone' => ['nullable', 'string', 'max:120'],
            'detected_locale' => ['nullable', 'string', 'max:80'],
            'parent_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:60'],
            'whatsapp' => ['nullable', 'string', 'max:80'],
            'wechat' => ['nullable', 'string', 'max:80'],
            'preferred_contact' => ['required', 'in:WhatsApp,WeChat,Email,Phone,Facebook'],
            'program_interest' => ['required', 'string', 'max:120'],
            'learning_goal' => ['required', 'string', 'max:1000'],
            'preferred_days' => ['required', 'array', 'min:1'],
            'preferred_days.*' => ['string', 'max:20'],
            'preferred_time' => ['required', 'string', 'max:120'],
            'lesson_duration' => ['required', 'in:25 minutes,50 minutes,Not sure'],
            'teacher_preference' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'privacy_consent' => ['accepted'],
        ]);

        if (! $this->isRegistrationBlockExempt($validated) && $this->isBlockedPhilippineRegistration($validated)) {
            return back()
                ->withErrors([
                    'country' => 'SpeakRyt registration is not available for Philippine-based student accounts.',
                ])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        if ($wechatError = $this->wechatRegistrationError($validated)) {
            return back()
                ->withErrors($wechatError)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $validated['password_hash'] = Hash::make($validated['password']);
        unset($validated['password']);

        $request->session()->put('latest_student_registration', $validated);

        return redirect()
            ->route('website.registration-pricing')
            ->with('status', 'Registration received. Your recommended pricing is shown below based on your registered country.');
    }

    public function registrationPricing(Request $request): View|RedirectResponse
    {
        $registration = $request->session()->get('latest_student_registration');

        if (! $registration) {
            return redirect()
                ->route('website.register')
                ->withErrors(['country' => 'Please complete registration first to view your recommended pricing.']);
        }

        $country = $this->registrationPricingCountry($registration);

        return view('website.registration-pricing', [
            'registration' => $registration,
            'country' => $country,
            'pricingGroup' => $this->regionalPricingGroupForCountry($country),
            'purchaseIntent' => $request->session()->get('latest_package_purchase'),
        ]);
    }

    public function registrationPurchase(Request $request): RedirectResponse
    {
        $registration = $request->session()->get('latest_student_registration');

        if (! $registration) {
            return redirect()
                ->route('website.register')
                ->withErrors(['country' => 'Please complete registration first before choosing a package.']);
        }

        $validated = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'tier' => ['required', 'string', 'max:40'],
            'payment_method' => ['required', 'in:PayPal,Debit/Credit Card via PayPal'],
        ]);

        $country = $this->registrationPricingCountry($registration);
        $package = $this->pricingPackageForSelection($country, $validated['category'], $validated['tier']);

        if (! $package) {
            return redirect()
                ->route('website.registration-pricing')
                ->withErrors(['package' => 'This package is not available for the registered country.']);
        }

        $request->session()->put('latest_package_purchase', [
            'student_name' => trim(($registration['student_first_name'] ?? '').' '.($registration['student_last_name'] ?? '')),
            'country' => $country,
            'category' => $validated['category'],
            'tier' => $package['tier'],
            'lessons' => $package['lessons'],
            'duration' => $this->pricingCatalogForCountry($country)[$validated['category']]['duration'],
            'price' => $package['price'],
            'validity' => $package['validity'],
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()
            ->route('website.registration-pricing')
            ->with('status', 'Package selected. Continue with '.$validated['payment_method'].' payment below.');
    }

    private function registrationPricingCountry(array $registration): string
    {
        $country = $registration['country'] ?? 'Others';
        $detectedCountry = $registration['detected_country'] ?? null;

        if (in_array($country, $this->regionalPricingCountries(), true)) {
            return $country;
        }

        if ($detectedCountry && in_array($detectedCountry, $this->regionalPricingCountries(), true)) {
            return $detectedCountry;
        }

        return 'Others';
    }

    private function pricingPackageForSelection(string $country, string $category, string $tier): ?array
    {
        $catalog = $this->pricingCatalogForCountry($country);

        if (! isset($catalog[$category])) {
            return null;
        }

        return collect($catalog[$category]['packages'])
            ->first(fn (array $package): bool => $package['tier'] === $tier);
    }

    private function isBlockedPhilippineRegistration(array $registration): bool
    {
        $country = strtolower(trim($registration['country'] ?? ''));
        $detectedCountry = strtolower(trim($registration['detected_country'] ?? ''));
        $detectedCountryCode = strtolower(trim($registration['detected_country_code'] ?? ''));

        return in_array($country, ['philippines', 'philippine', 'ph'], true)
            || in_array($detectedCountry, ['philippines', 'philippine'], true)
            || $detectedCountryCode === 'ph'
            || $this->hasPhilippineCountryCode($registration['phone'] ?? '')
            || $this->hasPhilippineCountryCode($registration['whatsapp'] ?? '');
    }

    private function isRegistrationBlockExempt(array $registration): bool
    {
        return strtolower(trim($registration['email'] ?? '')) === 'vanacepcion@gmail.com';
    }

    private function hasPhilippineCountryCode(string $value): bool
    {
        $compact = preg_replace('/[\s\-().]+/', '', trim($value));

        return str_starts_with($compact, '+63')
            || str_starts_with($compact, '0063');
    }

    private function wechatRegistrationError(array $registration): ?array
    {
        if (($registration['preferred_contact'] ?? '') !== 'WeChat') {
            return null;
        }

        if (blank($registration['wechat'] ?? null)) {
            return [
                'wechat' => 'Please enter the student WeChat ID when WeChat is selected as the preferred contact.',
            ];
        }

        if ($this->isChinaRegistration($registration) && ! $this->hasChinaCountryCode($registration['phone'] ?? '')) {
            return [
                'phone' => 'China-based WeChat registrations must use a China mobile number starting with +86 or 0086.',
            ];
        }

        return null;
    }

    private function isChinaRegistration(array $registration): bool
    {
        $country = strtolower(trim($registration['country'] ?? ''));
        $detectedCountry = strtolower(trim($registration['detected_country'] ?? ''));
        $detectedCountryCode = strtolower(trim($registration['detected_country_code'] ?? ''));

        return $country === 'china'
            || $detectedCountry === 'china'
            || $detectedCountryCode === 'cn';
    }

    private function hasChinaCountryCode(string $value): bool
    {
        $compact = preg_replace('/[\s\-().]+/', '', trim($value));

        return str_starts_with($compact, '+86')
            || str_starts_with($compact, '0086');
    }

    public function studentDashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('user_role')) {
            return redirect()
                ->route('student.login')
                ->withErrors(['email' => 'Please log in as a student to view your SpeakRyt dashboard.']);
        }

        if (! in_array($request->session()->get('user_role'), ['student', 'admin'], true)) {
            return redirect()
                ->route($this->roleLandingRoute($request->session()->get('user_role')))
                ->withErrors(['email' => 'This dashboard is only for student accounts.']);
        }

        $student = $this->studentForEmail($request->session()->get('user_email'));
        $pricingCountry = $this->studentPricingCountry($student);
        $pricingCategory = $this->studentPricingCategory($student);

        return view('student.dashboard', [
            'student' => $student,
            'package' => $this->studentPortalPackage($student),
            'upcomingLessons' => $this->studentPortalUpcomingLessons($student),
            'recentLessons' => $this->studentPortalRecentLessons($student),
            'learningGoals' => $this->studentPortalGoals($student),
            'pricingCountry' => $pricingCountry,
            'pricingCategory' => $pricingCategory,
            'availablePlans' => $this->studentAvailablePlans($pricingCountry, $pricingCategory),
            'purchaseHistory' => $this->studentPurchaseHistory($student, $pricingCountry, $pricingCategory),
            'purchaseIntent' => session('student_purchase_intent'),
        ]);
    }

    public function teamDashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('user_role')) {
            return redirect()
                ->route('portal.login')
                ->withErrors(['email' => 'Please log in through the SpeakRyt team portal.']);
        }

        $role = $request->session()->get('user_role');

        if ($role === 'student') {
            return redirect()
                ->route('student.dashboard')
                ->withErrors(['email' => 'Student accounts use the student dashboard.']);
        }

        if ($role === 'admin') {
            return redirect()->route('home');
        }

        return view('auth.team-dashboard', [
            'role' => $role,
            'email' => $request->session()->get('user_email'),
            'cards' => $this->teamDashboardCards($role),
        ]);
    }

    public function studentPackagePurchase(Request $request): RedirectResponse
    {
        if (! $request->session()->has('user_role')) {
            return redirect()
                ->route('student.login')
                ->withErrors(['email' => 'Please log in as a student to buy a package.']);
        }

        if (! in_array($request->session()->get('user_role'), ['student', 'admin'], true)) {
            return redirect()
                ->route($this->roleLandingRoute($request->session()->get('user_role')))
                ->withErrors(['email' => 'Package purchase is only available inside the student dashboard.']);
        }

        $validated = $request->validate([
            'tier' => ['required', 'in:Bronze,Silver,Gold,Platinum'],
            'payment_method' => ['required', 'in:PayPal,Debit/Credit Card via PayPal'],
        ]);

        $student = $this->studentForEmail($request->session()->get('user_email'));
        $country = $this->studentPricingCountry($student);
        $category = $this->studentPricingCategory($student);
        $package = $this->pricingPackageForSelection($country, $category, $validated['tier']);

        if (! $package) {
            return redirect()
                ->route('student.dashboard')
                ->withErrors(['package' => 'Please choose an available package for your student account.']);
        }

        return redirect()
            ->route('student.dashboard')
            ->with('student_purchase_intent', [
                'student_name' => $student['name'],
                'country' => $country,
                'category' => $category,
                'tier' => $package['tier'],
                'lessons' => $package['lessons'],
                'duration' => $this->pricingCatalogForCountry($country)[$category]['duration'],
                'validity' => $package['validity'],
                'price' => $package['price'],
                'payment_method' => $validated['payment_method'],
            ])
            ->with('status', 'Package selected. Your checkout summary is shown in your dashboard.');
    }

    public function studentLessonPdf(Request $request, string $lesson)
    {
        if (! $request->session()->has('user_role')) {
            return redirect()
                ->route('student.login')
                ->withErrors(['email' => 'Please log in as a student to view lesson PDFs.']);
        }

        if (! in_array($request->session()->get('user_role'), ['student', 'admin'], true)) {
            return redirect()
                ->route($this->roleLandingRoute($request->session()->get('user_role')))
                ->withErrors(['email' => 'Lesson PDFs are only available inside the student dashboard.']);
        }

        $topic = $this->lessonTitleFromSlug($lesson);
        $student = $this->studentForEmail($request->session()->get('user_email'));
        $pdf = $this->studentLessonPdfContent($topic, $student);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$lesson.'.pdf"',
        ]);
    }

    public function index(): View
    {
        return view('home', [
            'dashboardKpis' => $this->dashboardKpis(),
            'dailyBriefs' => $this->dailyBriefs(),
            'calendarLessons' => $this->calendarLessons(),
            'revenueSnapshot' => $this->revenueSnapshot(),
            'revenueSeries' => $this->revenueSeries(),
            'studentStats' => $this->studentStats(),
            'teacherStats' => $this->teacherStats(),
            'countryDistribution' => $this->countryDistribution(),
            'paymentAlerts' => $this->paymentAlerts(),
            'packageStatuses' => $this->packageStatuses(),
            'teacherPayrollDashboard' => $this->teacherPayrollDashboard(),
            'quickActions' => $this->quickActions(),
            'dashboardNotifications' => $this->dashboardNotifications(),
            'dashboardTodos' => $this->dashboardTodos(),
            'systemHealth' => $this->systemHealth(),
            'todayReminders' => $this->todayReminders(),
            'lessonReminderAlerts' => $this->lessonReminderAlerts(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function studentsIndex(): View
    {
        return view('students.index', [
            'students' => $this->studentDirectory(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function teachersIndex(): View
    {
        return view('teachers.index', [
            'teachers' => $this->teachers(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function scheduleEditor(): View
    {
        return view('schedule.index', [
            'scheduleDays' => $this->scheduleDays(),
            'scheduleSlots' => $this->scheduleSlots(),
            'scheduleEntries' => $this->scheduleEntries(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function paymentsRefunds(): View
    {
        return view('payments.index', [
            'paymentSummaries' => $this->paymentSummaries(),
            'paymentTransactions' => $this->paymentTransactions(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function packagesPricing(): View
    {
        return view('packages.index', [
            'packageStats' => $this->packageStats(),
            'pricingPackages' => $this->pricingPackages(),
            'regionalPricing' => $this->regionalPricing(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function lessonsIndex(): View
    {
        return view('lessons.index', [
            'lessonStats' => $this->lessonStats(),
            'lessonPrograms' => $this->lessonPrograms(),
        ]);
    }

    public function cefrCurriculum(): View
    {
        return view('lessons.cefr', [
            'cefrLevels' => ['A1', 'A2', 'B1', 'B2', 'C1'],
            'cefrModules' => $this->cefrModules(),
            'cefrLessons' => $this->cefrLessons(),
        ]);
    }

    public function companyDocuments(): View
    {
        return view('documents.index', [
            'documentStats' => $this->documentStats(),
            'documentCategories' => $this->documentCategories(),
            'companyDocuments' => $this->companyDocumentsList(),
        ]);
    }

    public function communication(Request $request): View
    {
        $activeTool = $request->query('tool', 'feedback');

        if (! in_array($activeTool, ['feedback', 'slack'], true)) {
            $activeTool = 'feedback';
        }

        return view('communication.index', [
            'activeTool' => $activeTool,
            'communicationTools' => $this->communicationTools(),
        ]);
    }

    public function messageCenter(Request $request): View
    {
        $activeChannel = $request->query('channel', 'wechat');
        $students = $this->students();
        $student = $students[$request->query('student', 'ST2-B089')] ?? $students['ST2-B089'];

        if (! in_array($activeChannel, ['whatsapp', 'email', 'wechat', 'facebook'], true)) {
            $activeChannel = 'wechat';
        }

        return view('message-center.index', [
            'activeChannel' => $activeChannel,
            'messageChannels' => $this->messageCenterChannels(),
            'students' => $this->studentDirectory(),
            'student' => $student,
            'communicationContext' => $this->studentCommunicationContext($student),
            'studentReminders' => $this->studentReminders($student),
        ]);
    }

    public function feedbackEntry(): View
    {
        $teachers = $this->teachers();
        $teacher = $teachers['T1-001'];

        return view('communication.feedback-entry', [
            'teacher' => $teacher,
            'feedbackSessions' => $this->feedbackEntrySessions($teacher),
        ]);
    }

    public function userManagement(): View
    {
        return view('users.index', [
            'roleSummaries' => $this->roleSummaries(),
            'permissionGroups' => $this->permissionGroups(),
            'managedUsers' => $this->managedUsers(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function myProfile(): View
    {
        return view('profile.index', [
            'profile' => $this->adminProfile(),
            'notificationSettings' => $this->adminNotificationSettings(),
            'accessScopes' => $this->adminAccessScopes(),
            'profileActivity' => $this->adminProfileActivity(),
            'profileChecklist' => $this->adminProfileChecklist(),
        ]);
    }

    public function staffIndex(): View
    {
        return view('staff.index', [
            'staffMembers' => $this->staffMembers(),
            'countryOptions' => $this->countryOptions(),
        ]);
    }

    public function showStaff(Request $request, string $staff): View
    {
        $staffProfiles = $this->staffProfiles();
        $profile = $staffProfiles[$staff] ?? $staffProfiles['SR-OM-4029'];
        $activeTab = $request->query('tab', 'overview');

        if (! in_array($activeTab, ['overview', 'payroll'], true)) {
            $activeTab = 'overview';
        }

        return view('staff.show', [
            'staff' => $profile,
            'managedTeachers' => $this->managedTeachers(),
            'staffPayrollHistory' => $this->staffPayrollHistory(),
            'activeTab' => $activeTab,
        ]);
    }

    public function showTeacher(Request $request, string $teacher): View
    {
        $teachers = $this->teachers();
        $profile = $teachers[$teacher] ?? $teachers['T1-001'];
        $activeTab = $request->query('tab', 'teaching');

        if (! in_array($activeTab, ['teaching', 'payroll'], true)) {
            $activeTab = 'teaching';
        }

        return view('teachers.show', [
            'teacher' => $profile,
            'teachingHistory' => $this->teachingHistory(),
            'payrollHistory' => $this->payrollHistory(),
            'activeTab' => $activeTab,
        ]);
    }

    public function showStaffPayroll(string $staff, string $payroll): View
    {
        $staffProfiles = $this->staffProfiles();
        $profile = $staffProfiles[$staff] ?? $staffProfiles['SR-OM-4029'];
        $payrollRecord = collect($this->staffPayrollHistory())
            ->firstWhere('slug', $payroll);

        if (! $payrollRecord) {
            $payrollRecord = $this->staffPayrollHistory()[0];
        }

        return view('staff.payroll-show', [
            'staff' => $profile,
            'payrollRecord' => $payrollRecord,
            'payrollBreakdown' => $this->staffPayrollBreakdown($payrollRecord['slug']),
        ]);
    }

    public function showTeacherPayroll(string $teacher, string $payroll): View
    {
        $teachers = $this->teachers();
        $profile = $teachers[$teacher] ?? $teachers['T1-001'];
        $payrollRecord = collect($this->payrollHistory())
            ->firstWhere('slug', $payroll);

        if (! $payrollRecord) {
            $payrollRecord = $this->payrollHistory()[0];
        }

        return view('teachers.payroll-show', [
            'teacher' => $profile,
            'payrollRecord' => $payrollRecord,
            'payrollBreakdown' => $this->payrollBreakdown($payrollRecord['slug']),
        ]);
    }

    public function showStudent(Request $request, string $student): View
    {
        $students = $this->students();
        $profile = $students[$student] ?? $students['ST1-A001'];
        $activeTab = $request->query('tab', 'payment');

        if (! in_array($activeTab, ['payment', 'lesson'], true)) {
            $activeTab = 'payment';
        }

        return view('students.show', [
            'student' => $profile,
            'payments' => $this->payments(),
            'lessons' => $this->lessons($profile['name'], $profile['teacher']),
            'activeTab' => $activeTab,
            'lessonFeedbackHistory' => $this->lessonFeedbackHistory($profile),
        ]);
    }

    public function generate(Request $request): string
    {
        $request->validate([
            'business_type' => ['required', 'string', 'max:255'],
        ]);

        return 'Generated successfully';
    }

    private function roleForEmail(string $email): string
    {
        $email = strtolower($email);

        return match (true) {
            in_array($email, ['admin@speakryt.com', 'van@speakryt.com', 'ceo@speakryt.com'], true) => 'admin',
            in_array($email, array_map(fn (array $student) => strtolower($student['email']), $this->students()), true) => 'student',
            str_contains($email, 'teacher') => 'teacher',
            str_contains($email, 'student') => 'student',
            str_contains($email, 'staff') => 'staff',
            str_contains($email, 'manager') => 'manager',
            default => 'staff',
        };
    }

    private function teamAccountForCredentials(string $email, string $password): ?array
    {
        $email = strtolower(trim($email));

        if (
            in_array($email, $this->configuredEmailList('SPEAKRYT_ADMIN_EMAILS', ['vanacepcion@gmail.com', 'admin@speakryt.com']), true)
            && $this->matchesConfiguredPassword($password, 'SPEAKRYT_ADMIN_PASSWORD_HASH', 'SPEAKRYT_ADMIN_PASSWORD')
        ) {
            return [
                'email' => $email,
                'role' => 'admin',
            ];
        }

        foreach (['teacher', 'manager', 'staff'] as $role) {
            if (
                in_array($email, $this->configuredEmailList('SPEAKRYT_'.strtoupper($role).'_EMAILS', []), true)
                && $this->matchesConfiguredPassword($password, 'SPEAKRYT_'.strtoupper($role).'_PASSWORD_HASH', 'SPEAKRYT_'.strtoupper($role).'_PASSWORD')
            ) {
                return [
                    'email' => $email,
                    'role' => $role,
                ];
            }
        }

        return null;
    }

    private function studentAccountForCredentials(string $email, string $password): ?array
    {
        $email = strtolower(trim($email));
        $studentEmails = array_map(fn (array $student): string => strtolower($student['email']), $this->students());

        if (
            in_array($email, $studentEmails, true)
            && $this->matchesConfiguredPassword($password, 'SPEAKRYT_STUDENT_PASSWORD_HASH', 'SPEAKRYT_STUDENT_PASSWORD')
        ) {
            return [
                'email' => $email,
                'role' => 'student',
            ];
        }

        return null;
    }

    private function configuredEmailList(string $key, array $fallback): array
    {
        $rawEmails = (string) env($key, implode(',', $fallback));

        return collect(explode(',', $rawEmails))
            ->map(fn (string $email): string => strtolower(trim($email)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function matchesConfiguredPassword(string $password, string $hashKey, string $plainKey): bool
    {
        $hash = env($hashKey);

        if (is_string($hash) && $hash !== '') {
            return Hash::check($password, $hash);
        }

        $plainPassword = env($plainKey);

        if (is_string($plainPassword) && $plainPassword !== '') {
            return hash_equals($plainPassword, $password);
        }

        return false;
    }

    private function roleLandingRoute(string $role): string
    {
        return match ($role) {
            'teacher' => 'portal.dashboard',
            'student' => 'student.dashboard',
            'manager' => 'portal.dashboard',
            'staff' => 'portal.dashboard',
            default => 'portal.login',
        };
    }

    private function teamDashboardCards(string $role): array
    {
        return match ($role) {
            'teacher' => [
                ['title' => 'Schedule', 'description' => 'View assigned lessons and availability blocks.'],
                ['title' => 'Assigned Students', 'description' => 'Review student names, lesson notes, and attendance.'],
                ['title' => 'Lesson Feedback', 'description' => 'Prepare and save lesson feedback for student records.'],
                ['title' => 'Payroll Record', 'description' => 'View your own payroll summary when enabled by admin.'],
            ],
            'manager' => [
                ['title' => 'Schedule Monitoring', 'description' => 'Review teacher availability and lesson assignments.'],
                ['title' => 'Student Support', 'description' => 'Handle approved student support tasks and reminders.'],
                ['title' => 'Team Updates', 'description' => 'Review staff coordination and internal notes.'],
                ['title' => 'Limited Reports', 'description' => 'Access approved non-sensitive operating summaries.'],
            ],
            default => [
                ['title' => 'Assigned Tasks', 'description' => 'View internal tasks assigned by admin or manager.'],
                ['title' => 'Documents', 'description' => 'Access approved company documents and memos.'],
                ['title' => 'Schedule Support', 'description' => 'Support class coordination without sensitive payroll access.'],
                ['title' => 'Operations Notes', 'description' => 'Track non-sensitive day-to-day operations notes.'],
            ],
        };
    }

    private function studentForEmail(?string $email): array
    {
        $email = strtolower((string) $email);

        foreach ($this->students() as $student) {
            if (strtolower($student['email']) === $email) {
                return $student;
            }
        }

        return $this->students()['ST1-A001'];
    }

    private function studentPortalPackage(array $student): array
    {
        $directory = collect($this->studentDirectory())->firstWhere('id', $student['id']);

        return [
            'name' => $directory['package'] ?? 'Personalized English Package',
            'remaining' => $directory['remaining'] ?? 8,
            'status' => $directory['status'] ?? $student['status'],
            'status_class' => $directory['status_class'] ?? 'bg-green-50 text-green-700',
            'renewal_note' => ($directory['remaining'] ?? 8) <= 5
                ? 'Your lesson balance is getting low. Please contact SpeakRyt to renew.'
                : 'Your package is active and ready for upcoming lessons.',
        ];
    }

    private function studentPricingCountry(array $student): string
    {
        $country = $student['country'] ?? 'Others';

        return in_array($country, $this->regionalPricingCountries(), true)
            ? $country
            : 'Others';
    }

    private function studentPricingCategory(array $student): string
    {
        return ($student['category'] ?? 'ADULTS') === 'KIDS'
            ? 'Kids English'
            : 'Adult English';
    }

    private function studentAvailablePlans(string $country, string $category): array
    {
        $catalog = $this->pricingCatalogForCountry($country);
        $categoryData = $catalog[$category] ?? $catalog['Adult English'];

        return collect($categoryData['packages'])
            ->map(fn (array $package): array => [
                ...$package,
                'category' => $category,
                'duration' => $categoryData['duration'],
            ])
            ->all();
    }

    private function studentPurchaseHistory(array $student, string $country, string $category): array
    {
        $plans = collect($this->studentAvailablePlans($country, $category))->keyBy('tier');
        $currentTier = ($student['category'] ?? 'ADULTS') === 'KIDS' ? 'Gold' : 'Silver';

        $history = [
            [
                'date' => now()->subDays(12)->format('M d, Y'),
                'plan' => $currentTier.' Package',
                'category' => $category,
                'lessons' => $plans[$currentTier]['lessons'] ?? 15,
                'duration' => $plans[$currentTier]['duration'] ?? '50 minutes',
                'amount' => $plans[$currentTier]['price'] ?? '$165',
                'validity' => $plans[$currentTier]['validity'] ?? 'Valid for 1 month',
                'method' => 'PayPal',
                'status' => 'Active',
                'status_class' => 'bg-green-50 text-green-700',
            ],
            [
                'date' => now()->subMonths(1)->format('M d, Y'),
                'plan' => 'Bronze Package',
                'category' => $category,
                'lessons' => $plans['Bronze']['lessons'] ?? 5,
                'duration' => $plans['Bronze']['duration'] ?? '50 minutes',
                'amount' => $plans['Bronze']['price'] ?? '$55',
                'validity' => $plans['Bronze']['validity'] ?? 'Trial package - one-time purchase only',
                'method' => 'Debit/Credit Card via PayPal',
                'status' => 'Completed',
                'status_class' => 'bg-slate-100 text-slate-700',
            ],
        ];

        if (($student['status'] ?? '') === 'Renewal Due' || ($student['status'] ?? '') === 'Low Balance') {
            array_unshift($history, [
                'date' => now()->format('M d, Y'),
                'plan' => 'Renewal Recommended',
                'category' => $category,
                'lessons' => '-',
                'duration' => $plans[$currentTier]['duration'] ?? '50 minutes',
                'amount' => '-',
                'validity' => 'Please renew before lessons run out',
                'method' => 'Pending',
                'status' => 'Action Needed',
                'status_class' => 'bg-amber-50 text-amber-700',
            ]);
        }

        return $history;
    }

    private function studentPortalUpcomingLessons(array $student): array
    {
        $lessons = [
            ['starts_at' => now()->addMinutes(2), 'topic' => 'Speaking Confidence Practice', 'platform' => 'Zoom'],
            ['starts_at' => now()->addDay()->setTime(19, 0), 'topic' => 'Vocabulary and Fluency', 'platform' => 'Zoom'],
            ['starts_at' => now()->addDays(3)->setTime(19, 0), 'topic' => 'Grammar in Conversation', 'platform' => 'Zoom'],
        ];

        return collect($lessons)
            ->map(function (array $lesson) use ($student): array {
                $minutesUntilStart = now()->diffInMinutes($lesson['starts_at'], false);

                return [
                    'date' => $lesson['starts_at']->isToday() ? 'Today' : $lesson['starts_at']->format('l, M d'),
                    'time' => $lesson['starts_at']->format('h:i A'),
                    'topic' => $lesson['topic'],
                    'topic_pdf_url' => route('student.lessons.pdf', ['lesson' => $this->lessonSlug($lesson['topic'])]),
                    'teacher' => $student['teacher'],
                    'platform' => $lesson['platform'],
                    'status' => 'Pending',
                    'starts_at_iso' => $lesson['starts_at']->toIso8601String(),
                    'can_reschedule' => $minutesUntilStart > 360,
                    'reschedule_note' => $minutesUntilStart > 360
                        ? 'Reschedule allowed'
                        : 'Reschedule closes 6 hours before class',
                    'meeting_url' => 'https://zoom.us/j/0000000000',
                ];
            })
            ->all();
    }

    private function studentPortalRecentLessons(array $student): array
    {
        $feedback = $this->lessonFeedbackHistory($student);

        return collect($this->lessons($student['name'], $student['teacher']))
            ->map(function (array $lesson, int $index) use ($feedback, $student): array {
                $lessonFeedback = $feedback[$index] ?? [
                    'id' => 'FB-'.$student['id'].'-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'student_id' => $student['id'],
                    'student_name' => $student['name'],
                    'teacher_id' => $student['teacher_id'],
                    'teacher_name' => $student['teacher'],
                    'date_time' => $lesson['date'].' '.$lesson['time'],
                    'lesson_topic' => $lesson['lesson'],
                    'vocabulary_corrections' => 'Review today\'s vocabulary and practice using each word in one complete sentence.',
                    'grammar_corrections' => 'Continue answering in complete sentences and check verb tense before speaking.',
                    'english_feedback' => $student['name'].' completed '.$lesson['lesson'].' with good effort. Please review the lesson notes before the next class.',
                    'chinese_feedback' => $student['name'].' 已完成《'.$lesson['lesson'].'》。请在下节课前复习课堂笔记。',
                    'status' => 'Saved',
                ];

                return [
                    ...$lesson,
                    'topic_pdf_url' => route('student.lessons.pdf', ['lesson' => $this->lessonSlug($lesson['lesson'])]),
                    'feedback' => $lessonFeedback,
                ];
            })
            ->all();
    }

    private function lessonSlug(string $topic): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $topic), '-'));

        return $slug !== '' ? $slug : 'lesson-topic';
    }

    private function lessonTitleFromSlug(string $slug): string
    {
        return ucwords(str_replace('-', ' ', $slug));
    }

    private function studentLessonPdfContent(string $topic, array $student): string
    {
        $lines = [
            'SpeakRyt Lesson Topic',
            '',
            'Student: '.$student['name'],
            'Teacher: '.$student['teacher'],
            'Topic: '.$topic,
            '',
            'Lesson Preview',
            'This PDF is a student-facing lesson topic preview. In production, this will be replaced by the official uploaded lesson PDF for this class.',
            '',
            'Focus Areas',
            '- Speaking practice',
            '- Vocabulary review',
            '- Grammar accuracy',
            '- Confidence building',
        ];

        $stream = "BT\n/F1 18 Tf\n72 760 Td\n";
        foreach ($lines as $index => $line) {
            $fontSize = $index === 0 ? 18 : 11;
            $stream .= "/F1 {$fontSize} Tf\n(".$this->pdfEscape($line).") Tj\n0 -24 Td\n";
        }
        $stream .= "ET";

        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Length ".strlen($stream)." >>\nstream\n{$stream}\nendstream\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    private function pdfEscape(string $value): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $value);
    }

    private function studentPortalGoals(array $student): array
    {
        return [
            ['label' => 'Speaking confidence', 'progress' => 72],
            ['label' => 'Vocabulary growth', 'progress' => 64],
            ['label' => 'Grammar accuracy', 'progress' => 58],
        ];
    }

    private function dashboardKpis(): array
    {
        return [
            ['label' => 'Active Students', 'value' => '318', 'trend' => '+8%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'groups', 'icon_class' => 'bg-blue-50 text-blue-700'],
            ['label' => 'Active Teachers', 'value' => '42', 'trend' => '+4%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'school', 'icon_class' => 'bg-cyan-50 text-cyan-700'],
            ['label' => 'Lessons Today', 'value' => '186', 'trend' => '+12%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'calendar_today', 'icon_class' => 'bg-indigo-50 text-indigo-700'],
            ['label' => 'Completed Lessons', 'value' => '142', 'trend' => '+9%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'task_alt', 'icon_class' => 'bg-emerald-50 text-emerald-700'],
            ['label' => 'Pending Lessons', 'value' => '31', 'trend' => '-3%', 'trend_class' => 'text-amber-700 bg-amber-50', 'icon' => 'pending_actions', 'icon_class' => 'bg-amber-50 text-amber-700'],
            ['label' => 'Cancelled Lessons', 'value' => '13', 'trend' => '-6%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'event_busy', 'icon_class' => 'bg-red-50 text-red-700'],
            ['label' => 'Revenue Today', 'value' => '$8,420', 'trend' => '+15%', 'trend_class' => 'text-green-700 bg-green-50', 'icon' => 'payments', 'icon_class' => 'bg-sky-50 text-sky-700'],
            ['label' => 'Payroll Today', 'value' => 'P42,800', 'trend' => '+5%', 'trend_class' => 'text-blue-700 bg-blue-50', 'icon' => 'account_balance_wallet', 'icon_class' => 'bg-slate-100 text-slate-700'],
        ];
    }

    private function dailyBriefs(): array
    {
        return [
            ['title' => 'Revenue today', 'detail' => '$8,420 collected across 26 successful payments.', 'status' => 'Healthy'],
            ['title' => 'Completed lessons', 'detail' => '142 lessons completed so far, with 31 still pending.', 'status' => 'On Track'],
            ['title' => 'Low lesson balances', 'detail' => '18 students have fewer than 5 lessons remaining.', 'status' => 'Review'],
            ['title' => 'Open teacher slots', 'detail' => '27 teacher time slots remain open for assignment.', 'status' => 'Opportunity'],
            ['title' => 'Refund queue', 'detail' => '4 refund requests are waiting for admin review.', 'status' => 'Action'],
            ['title' => 'New student growth', 'detail' => '11 new students registered this week.', 'status' => 'Growth'],
        ];
    }

    private function calendarLessons(): array
    {
        return $this->withStudentCategories([
            ['time' => '09:00', 'student' => 'Alex Thompson', 'teacher' => 'Sarah Anderson', 'status' => 'Completed', 'status_class' => 'bg-green-50 text-green-700', 'platform' => 'Zoom'],
            ['time' => '10:30', 'student' => 'Yuki Tanaka', 'teacher' => 'Marcus Chen', 'status' => 'Live', 'status_class' => 'bg-blue-50 text-blue-700', 'platform' => 'Google Meet'],
            ['time' => '13:00', 'student' => 'Li Wei', 'teacher' => 'Elena Rodriguez', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700', 'platform' => 'ClassIn'],
            ['time' => '15:30', 'student' => 'Hana Park', 'teacher' => 'Sarah Kim', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700', 'platform' => 'Zoom'],
            ['time' => '18:00', 'student' => 'Omar Khalid', 'teacher' => 'James Lee', 'status' => 'Cancelled', 'status_class' => 'bg-red-50 text-red-700', 'platform' => 'WeChat'],
        ]);
    }

    private function revenueSnapshot(): array
    {
        return [
            ['label' => 'Revenue', 'value' => '$8,420', 'class' => 'text-green-700'],
            ['label' => 'Expenses', 'value' => '$1,180', 'class' => 'text-slate-700'],
            ['label' => 'Payroll', 'value' => 'P42,800', 'class' => 'text-blue-700'],
            ['label' => 'Profit', 'value' => '$6,475', 'class' => 'text-primary'],
        ];
    }

    private function revenueSeries(): array
    {
        return [34, 38, 35, 42, 47, 44, 52, 49, 57, 61, 55, 63, 66, 70, 68, 74, 79, 76, 82, 85, 81, 88, 91, 86, 93, 98, 96, 101, 108, 112];
    }

    private function studentStats(): array
    {
        return [
            ['label' => 'Total Students', 'value' => '356'],
            ['label' => 'New This Week', 'value' => '11'],
            ['label' => 'Inactive', 'value' => '38'],
            ['label' => 'Assessment', 'value' => '24'],
            ['label' => 'Renewal Due', 'value' => '18'],
            ['label' => 'Expiring Packages', 'value' => '29'],
        ];
    }

    private function teacherStats(): array
    {
        return [
            ['label' => 'Active Teachers', 'value' => '42'],
            ['label' => 'Online', 'value' => '18'],
            ['label' => 'Absent Today', 'value' => '3'],
            ['label' => 'Pending Payroll', 'value' => '9'],
            ['label' => 'Average Rating', 'value' => '4.8'],
            ['label' => 'Lessons Today', 'value' => '142'],
            ['label' => 'Open Time Slots', 'value' => '27'],
        ];
    }

    private function countryDistribution(): array
    {
        return [
            ['country' => 'China', 'students' => 118, 'packages' => 96, 'revenue' => '$24,800'],
            ['country' => 'Saudi Arabia', 'students' => 39, 'packages' => 33, 'revenue' => '$9,860'],
            ['country' => 'UAE', 'students' => 34, 'packages' => 28, 'revenue' => '$8,720'],
            ['country' => 'Israel', 'students' => 46, 'packages' => 39, 'revenue' => '$11,420'],
            ['country' => 'Vietnam', 'students' => 31, 'packages' => 25, 'revenue' => '$6,940'],
            ['country' => 'Thailand', 'students' => 28, 'packages' => 23, 'revenue' => '$6,280'],
            ['country' => 'Indonesia', 'students' => 22, 'packages' => 18, 'revenue' => '$5,340'],
            ['country' => 'Japan', 'students' => 43, 'packages' => 36, 'revenue' => '$10,760'],
            ['country' => 'South Korea', 'students' => 38, 'packages' => 31, 'revenue' => '$9,420'],
            ['country' => 'Spain', 'students' => 16, 'packages' => 13, 'revenue' => '$3,880'],
            ['country' => 'Italy', 'students' => 14, 'packages' => 11, 'revenue' => '$3,260'],
            ['country' => 'France', 'students' => 19, 'packages' => 15, 'revenue' => '$4,510'],
            ['country' => 'Germany', 'students' => 21, 'packages' => 17, 'revenue' => '$5,180'],
            ['country' => 'Poland', 'students' => 12, 'packages' => 9, 'revenue' => '$2,470'],
            ['country' => 'Others', 'students' => 92, 'packages' => 75, 'revenue' => '$18,600'],
        ];
    }

    private function countryOptions(): array
    {
        return [
            'China',
            'Saudi Arabia',
            'UAE',
            'Israel',
            'Vietnam',
            'Thailand',
            'Indonesia',
            'Japan',
            'South Korea',
            'Spain',
            'Italy',
            'France',
            'Germany',
            'Poland',
            'Others',
        ];
    }

    private function paymentAlerts(): array
    {
        return [
            ['label' => 'Payments Due Today', 'value' => '14', 'class' => 'border-blue-200 bg-blue-50 text-blue-700'],
            ['label' => 'Pending Manual Payments', 'value' => '7', 'class' => 'border-amber-200 bg-amber-50 text-amber-700'],
            ['label' => 'Refund Requests', 'value' => '4', 'class' => 'border-red-200 bg-red-50 text-red-700'],
            ['label' => 'Failed Payments', 'value' => '3', 'class' => 'border-red-200 bg-red-50 text-red-700'],
            ['label' => 'Chargebacks', 'value' => '1', 'class' => 'border-slate-200 bg-slate-50 text-slate-700'],
        ];
    }

    private function packageStatuses(): array
    {
        return $this->withStudentCategories([
            ['student' => 'Maria Garcia', 'issue' => '2 lessons remaining', 'teacher' => 'Michael Chen', 'action' => 'Renewal Due'],
            ['student' => 'Chloe Dubois', 'issue' => '1 lesson remaining', 'teacher' => 'Sarah Anderson', 'action' => 'Follow Up'],
            ['student' => 'Omar Khalid', 'issue' => 'Access expires in 3 days', 'teacher' => 'James Lee', 'action' => 'Review'],
            ['student' => 'Chen Mei', 'issue' => 'Unused package for 21 days', 'teacher' => 'Elena Rodriguez', 'action' => 'Message'],
        ]);
    }

    private function teacherPayrollDashboard(): array
    {
        return [
            ['teacher' => 'Sarah Anderson', 'lessons' => 32, 'amount' => 'P6,900.00', 'due' => 'Jul 15', 'status' => 'Pending Approval'],
            ['teacher' => 'Marcus Chen', 'lessons' => 24, 'amount' => 'P4,320.00', 'due' => 'Jul 15', 'status' => 'Ready'],
            ['teacher' => 'Elena Rodriguez', 'lessons' => 29, 'amount' => 'P6,090.00', 'due' => 'Jul 15', 'status' => 'Review'],
            ['teacher' => 'James Lee', 'lessons' => 18, 'amount' => 'P3,690.00', 'due' => 'Jul 15', 'status' => 'Pending Approval'],
        ];
    }

    private function quickActions(): array
    {
        return [
            ['label' => 'Add Student', 'icon' => 'person_add', 'href' => route('students.index')],
            ['label' => 'Add Teacher', 'icon' => 'co_present', 'href' => route('teachers.index')],
            ['label' => 'Create Lesson', 'icon' => 'add_task', 'href' => route('lessons.index')],
            ['label' => 'Record Payment', 'icon' => 'payments', 'href' => route('payments.index')],
            ['label' => 'Add Package', 'icon' => 'inventory_2', 'href' => route('packages.index')],
            ['label' => 'Schedule Class', 'icon' => 'event_available', 'href' => route('schedule.index')],
            ['label' => 'Upload PDF', 'icon' => 'upload_file', 'href' => route('documents.index')],
            ['label' => 'Create Announcement', 'icon' => 'campaign', 'href' => route('documents.index')],
        ];
    }

    private function dashboardNotifications(): array
    {
        return [
            ['title' => 'Teacher submitted leave', 'time' => '12 minutes ago'],
            ['title' => 'New student registered', 'time' => '24 minutes ago'],
            ['title' => 'Payment received', 'time' => '41 minutes ago'],
            ['title' => 'Student cancelled lesson', 'time' => '1 hour ago'],
            ['title' => 'Teacher uploaded lesson feedback', 'time' => '2 hours ago'],
            ['title' => 'Refund request submitted', 'time' => '3 hours ago'],
        ];
    }

    private function dashboardTodos(): array
    {
        return [
            'Approve payroll',
            'Reply to parent',
            'Review refund request',
            'Upload new lesson',
            'Check student renewal',
            'Review teacher attendance',
        ];
    }

    private function systemHealth(): array
    {
        return [
            ['label' => 'Server status', 'value' => 'Operational', 'class' => 'text-green-700'],
            ['label' => 'Backup status', 'value' => 'Completed', 'class' => 'text-green-700'],
            ['label' => 'Storage used', 'value' => '42%', 'class' => 'text-blue-700'],
            ['label' => 'Email status', 'value' => 'Connected', 'class' => 'text-green-700'],
            ['label' => 'Google Calendar', 'value' => 'Connected', 'class' => 'text-green-700'],
            ['label' => 'WhatsApp', 'value' => 'Connected', 'class' => 'text-green-700'],
            ['label' => 'WeChat', 'value' => 'Review', 'class' => 'text-amber-700'],
            ['label' => 'Slack', 'value' => 'Connected', 'class' => 'text-green-700'],
        ];
    }

    private function communicationTools(): array
    {
        return [
            'feedback' => [
                'label' => 'Lesson Feedback Entry',
                'subtitle' => 'Teachers manually type lesson feedback and save it to the student record.',
                'icon' => 'edit_note',
                'admin_only' => false,
                'status' => 'Available to teachers and admin',
                'href' => route('communication.feedback-entry'),
            ],
            'slack' => [
                'label' => 'Slack',
                'subtitle' => 'Prepare internal team updates, reminders, and operations notes.',
                'icon' => 'forum',
                'admin_only' => false,
                'status' => 'Internal communication',
                'href' => route('communication.index', ['tool' => 'slack']),
            ],
        ];
    }

    private function messageCenterChannels(): array
    {
        return [
            'whatsapp' => [
                'label' => 'WhatsApp',
                'subtitle' => 'Admin-only WhatsApp drafts for parent and student communication.',
                'icon' => 'chat',
                'admin_only' => true,
                'status' => 'Admin only',
                'href' => route('message-center.index', ['channel' => 'whatsapp']),
                'copy_label' => 'Message copied. Paste in WhatsApp.',
            ],
            'email' => [
                'label' => 'Email',
                'subtitle' => 'Admin-only email drafts for formal communication.',
                'icon' => 'mail',
                'admin_only' => true,
                'status' => 'Admin only',
                'href' => route('message-center.index', ['channel' => 'email']),
                'copy_label' => 'Message copied. Paste in Email.',
            ],
            'wechat' => [
                'label' => 'WeChat Message Generator',
                'subtitle' => 'Admin-only bilingual WeChat drafts for manual copy and paste.',
                'icon' => 'quick_phrases',
                'admin_only' => true,
                'status' => 'Admin only',
                'href' => route('message-center.index', ['channel' => 'wechat']),
                'copy_label' => 'Message copied. Paste in WeChat.',
            ],
            'facebook' => [
                'label' => 'Facebook Message',
                'subtitle' => 'Admin-only Facebook message drafts for parent and student inquiries.',
                'icon' => 'thumb_up',
                'admin_only' => true,
                'status' => 'Admin only',
                'href' => route('message-center.index', ['channel' => 'facebook']),
                'copy_label' => 'Message copied. Paste in Facebook Messenger.',
            ],
        ];
    }

    private function todayReminders(): array
    {
        return [
            ['student' => 'Li Wei', 'student_id' => 'ST2-B089', 'type' => 'Renewal Reminder', 'time' => '10:00 AM', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700'],
            ['student' => 'Alex Thompson', 'student_id' => 'ST1-A001', 'type' => 'Class Reminder', 'time' => '08:30 AM', 'status' => 'Completed', 'status_class' => 'bg-green-50 text-green-700'],
            ['student' => 'Sofia Garcia', 'student_id' => 'ST2-D044', 'type' => 'Payment Reminder', 'time' => '04:30 PM', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700'],
            ['student' => 'Yuki Tanaka', 'student_id' => 'ST1-A005', 'type' => 'Follow-up Message', 'time' => '06:00 PM', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700'],
        ];
    }

    private function lessonReminderAlerts(): array
    {
        return [
            ['message' => 'Reminder: Mira has a lesson at 7:00 PM', 'class' => 'border-blue-200 bg-blue-50 text-blue-800'],
            ['message' => 'Reminder: Yuki Tanaka has a lesson at 10:30 AM', 'class' => 'border-cyan-200 bg-cyan-50 text-cyan-800'],
        ];
    }

    private function studentCommunicationContext(array $student): array
    {
        $directoryRecord = collect($this->studentDirectory())->firstWhere('id', $student['id']) ?? [];

        return [
            'student_name' => $student['name'],
            'lesson_time' => $this->nextLessonTimeForStudent($student['name']),
            'teacher_name' => $student['teacher'],
            'remaining_lessons' => $directoryRecord['remaining'] ?? 0,
            'company_name' => 'SpeakRyt',
        ];
    }

    private function studentReminders(array $student): array
    {
        $remainingLessons = $this->studentCommunicationContext($student)['remaining_lessons'];

        return [
            ['title' => 'Send class reminder before today\'s lesson', 'type' => 'Class Reminder', 'date' => now()->format('M d, Y'), 'time' => $this->nextLessonTimeForStudent($student['name']), 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700'],
            ['title' => 'Review package balance', 'type' => 'Payment', 'date' => now()->format('M d, Y'), 'time' => '04:00 PM', 'status' => $remainingLessons <= 5 ? 'Pending' : 'Completed', 'status_class' => $remainingLessons <= 5 ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700'],
            ['title' => 'Check learning progress with parent/student', 'type' => 'Follow-up', 'date' => now()->addDay()->format('M d, Y'), 'time' => '11:00 AM', 'status' => 'Pending', 'status_class' => 'bg-amber-50 text-amber-700'],
        ];
    }

    private function lessonFeedbackHistory(array $student): array
    {
        return [
            [
                'id' => 'FB-'.$student['id'].'-001',
                'student_id' => $student['id'],
                'student_name' => $student['name'],
                'teacher_id' => $student['teacher_id'],
                'teacher_name' => $student['teacher'],
                'date_time' => now()->subDays(2)->format('M d, Y h:i A'),
                'lesson_topic' => 'Speaking Fluency and Sentence Expansion',
                'vocabulary_corrections' => 'Practice: commute, deadline, explain, prefer. Replace "go work" with "go to work".',
                'grammar_corrections' => 'Use complete past tense answers: "I went" instead of "I go" when talking about yesterday.',
                'english_feedback' => $student['name'].' participated well and answered with more confidence today. Please continue practicing longer answers using complete sentences.',
                'chinese_feedback' => $student['name'].' 今天课堂参与度很好，回答问题更加自信。请继续练习用完整句子表达更长的答案。',
                'status' => 'Saved',
            ],
        ];
    }

    private function feedbackEntrySessions(array $teacher): array
    {
        return [
            [
                'student_id' => 'ST2-B089',
                'student_name' => 'Li Wei',
                'teacher_id' => $teacher['id'],
                'teacher_name' => $teacher['name'],
                'date_time' => now()->format('M d, Y h:i A'),
                'lesson_topic' => 'Conversational English: Daily Routine',
                'vocabulary_corrections' => 'Use "usually", "sometimes", and "after work" in complete sentences.',
                'grammar_corrections' => 'Remember third-person singular: "She works" and "He studies".',
            ],
            [
                'student_id' => 'ST1-A001',
                'student_name' => 'Alex Thompson',
                'teacher_id' => $teacher['id'],
                'teacher_name' => $teacher['name'],
                'date_time' => now()->format('M d, Y h:i A'),
                'lesson_topic' => 'IELTS Speaking Part 2',
                'vocabulary_corrections' => 'Use stronger transitions: firstly, in addition, as a result.',
                'grammar_corrections' => 'Avoid sentence fragments. Give one complete reason after each main idea.',
            ],
            [
                'student_id' => 'ST1-A005',
                'student_name' => 'Yuki Tanaka',
                'teacher_id' => $teacher['id'],
                'teacher_name' => $teacher['name'],
                'date_time' => now()->format('M d, Y h:i A'),
                'lesson_topic' => 'Business Presentation Practice',
                'vocabulary_corrections' => 'Practice: revenue, proposal, strategy, quarterly result.',
                'grammar_corrections' => 'Use future forms clearly: "We will present" instead of "We present tomorrow".',
            ],
        ];
    }

    private function nextLessonTimeForStudent(string $studentName): string
    {
        $lesson = collect($this->calendarLessons())->firstWhere('student', $studentName);

        return $lesson['time'] ?? '7:00 PM';
    }

    private function students(): array
    {
        return [
            'ST1-A001' => [
                'id' => 'ST1-A001',
                'name' => 'Alex Thompson',
                'status' => 'Active',
                'city' => 'Toronto',
                'country' => 'Canada',
                'level' => 'B2',
                'email' => 'alex.thompson@email.com',
                'phone' => '+1 (416) 555-0198',
                'wechat' => 'alex_t_88',
                'teacher' => 'Sarah Anderson',
                'teacher_id' => 'T1-001',
                'teacher_initials' => 'SA',
                'category' => 'ADULTS',
                'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ],
            'ST1-A005' => [
                'id' => 'ST1-A005',
                'name' => 'Yuki Tanaka',
                'status' => 'Active',
                'city' => 'Tokyo',
                'country' => 'Japan',
                'level' => 'C1',
                'email' => 'yuki.tanaka@email.com',
                'phone' => '+81 90 5555 0105',
                'wechat' => 'yuki_tanaka',
                'teacher' => 'Marcus Chen',
                'teacher_id' => 'T1-002',
                'teacher_initials' => 'MC',
                'category' => 'ADULTS',
                'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ],
            'ST2-B089' => [
                'id' => 'ST2-B089',
                'name' => 'Li Wei',
                'status' => 'Renewal Due',
                'city' => 'Shanghai',
                'country' => 'China',
                'level' => 'B1',
                'email' => 'li.wei@email.com',
                'phone' => '+86 138 5555 0089',
                'wechat' => 'liwei_english',
                'teacher' => 'Elena Rodriguez',
                'teacher_id' => 'T1-003',
                'teacher_initials' => 'ER',
                'category' => 'ADULTS',
                'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ],
            'ST1-C112' => [
                'id' => 'ST1-C112',
                'name' => 'Nguyen Tuan',
                'status' => 'Active',
                'city' => 'Ho Chi Minh City',
                'country' => 'Vietnam',
                'level' => 'A2',
                'email' => 'nguyen.tuan@email.com',
                'phone' => '+84 90 555 0112',
                'wechat' => 'tuan_nguyen',
                'teacher' => 'James Lee',
                'teacher_id' => 'T1-004',
                'teacher_initials' => 'JL',
                'category' => 'KIDS',
                'category_class' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            ],
            'ST2-D044' => [
                'id' => 'ST2-D044',
                'name' => 'Sofia Garcia',
                'status' => 'Low Balance',
                'city' => 'Bangkok',
                'country' => 'Thailand',
                'level' => 'B2',
                'email' => 'sofia.garcia@email.com',
                'phone' => '+66 81 555 0044',
                'wechat' => 'sofia_garcia',
                'teacher' => 'Sarah Kim',
                'teacher_id' => 'T1-005',
                'teacher_initials' => 'SK',
                'category' => 'KIDS',
                'category_class' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            ],
            'ST1-K221' => [
                'id' => 'ST1-K221',
                'name' => 'Hana Park',
                'status' => 'Active',
                'city' => 'Seoul',
                'country' => 'South Korea',
                'level' => 'C1',
                'email' => 'hana.park@email.com',
                'phone' => '+82 10 5555 0221',
                'wechat' => 'hana_park',
                'teacher' => 'Sarah Anderson',
                'teacher_id' => 'T1-001',
                'teacher_initials' => 'SA',
                'category' => 'ADULTS',
                'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ],
        ];
    }

    private function studentDirectory(): array
    {
        return [
            ['id' => 'ST1-A001', 'name' => 'Alex Thompson', 'category' => 'ADULTS', 'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'country' => 'Canada', 'level' => 'B2', 'teacher' => 'Sarah Anderson', 'package' => 'IELTS Master 20', 'remaining' => 8, 'status' => 'Active', 'status_class' => 'bg-green-50 text-green-700'],
            ['id' => 'ST1-A005', 'name' => 'Yuki Tanaka', 'category' => 'ADULTS', 'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'country' => 'Japan', 'level' => 'C1', 'teacher' => 'Marcus Chen', 'package' => 'Business Pro', 'remaining' => 14, 'status' => 'Active', 'status_class' => 'bg-green-50 text-green-700'],
            ['id' => 'ST2-B089', 'name' => 'Li Wei', 'category' => 'ADULTS', 'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'country' => 'China', 'level' => 'B1', 'teacher' => 'Elena Rodriguez', 'package' => 'Conversational 20', 'remaining' => 4, 'status' => 'Renewal Due', 'status_class' => 'bg-amber-50 text-amber-700'],
            ['id' => 'ST1-C112', 'name' => 'Nguyen Tuan', 'category' => 'KIDS', 'category_class' => 'bg-cyan-50 text-cyan-700 border-cyan-200', 'country' => 'Vietnam', 'level' => 'A2', 'teacher' => 'James Lee', 'package' => 'Youth Explorer', 'remaining' => 11, 'status' => 'Active', 'status_class' => 'bg-green-50 text-green-700'],
            ['id' => 'ST2-D044', 'name' => 'Sofia Garcia', 'category' => 'KIDS', 'category_class' => 'bg-cyan-50 text-cyan-700 border-cyan-200', 'country' => 'Thailand', 'level' => 'B2', 'teacher' => 'Sarah Kim', 'package' => 'Kids English 30', 'remaining' => 3, 'status' => 'Low Balance', 'status_class' => 'bg-red-50 text-red-700'],
            ['id' => 'ST1-K221', 'name' => 'Hana Park', 'category' => 'ADULTS', 'category_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'country' => 'South Korea', 'level' => 'C1', 'teacher' => 'Sarah Anderson', 'package' => 'IELTS Writing Boost', 'remaining' => 18, 'status' => 'Active', 'status_class' => 'bg-green-50 text-green-700'],
        ];
    }

    private function payments(): array
    {
        return [
            ['date' => 'Oct 12, 2023', 'time' => '14:22 PM', 'package' => 'IELTS MASTER 20', 'base' => '$1,200.00', 'discount' => '10%', 'paid' => '$1,080.00', 'refund' => false, 'method' => 'PayPal', 'icon' => 'account_balance_wallet'],
            ['date' => 'Aug 05, 2023', 'time' => '09:15 AM', 'package' => 'CONVERSATION 10', 'base' => '$450.00', 'discount' => '0%', 'paid' => '$450.00', 'refund' => false, 'method' => 'E-wallet', 'icon' => 'wallet'],
            ['date' => 'Jun 20, 2023', 'time' => '16:45 PM', 'package' => 'STARTER PACK 5', 'base' => '$200.00', 'discount' => '5%', 'paid' => '$190.00', 'refund' => true, 'method' => 'Credit Card', 'icon' => 'credit_card'],
            ['date' => 'May 12, 2023', 'time' => '11:15 AM', 'package' => 'CONVERSATION 20', 'base' => '$800.00', 'discount' => '10%', 'paid' => '$720.00', 'refund' => false, 'method' => 'Debit Card', 'icon' => 'credit_card'],
            ['date' => 'Mar 05, 2023', 'time' => '09:30 AM', 'package' => 'STARTER PACK 10', 'base' => '$350.00', 'discount' => '0%', 'paid' => '$350.00', 'refund' => false, 'method' => 'Credit Card', 'icon' => 'credit_card'],
        ];
    }

    private function paymentSummaries(): array
    {
        return [
            ['label' => 'Total Revenue (Monthly)', 'amount' => '$142,580.00', 'accent' => 'bg-primary', 'icon' => 'account_balance_wallet', 'icon_class' => 'bg-primary/5 text-primary', 'meta' => '+12.5%', 'meta_icon' => 'trending_up', 'meta_class' => 'bg-success/10 text-success'],
            ['label' => 'Total Payments Today', 'amount' => '$4,820.50', 'accent' => 'bg-active-accent', 'icon' => 'payments', 'icon_class' => 'bg-active-accent/5 text-active-accent', 'meta' => '42 Trans.', 'meta_icon' => null, 'meta_class' => 'bg-success/10 text-success'],
            ['label' => 'Total Refunds (Monthly)', 'amount' => '$1,240.00', 'accent' => 'bg-error', 'icon' => 'undo', 'icon_class' => 'bg-error/5 text-error', 'meta' => '2 Pending', 'meta_icon' => 'warning', 'meta_class' => 'bg-error/10 text-error'],
        ];
    }

    private function paymentTransactions(): array
    {
        return $this->withStudentCategories([
            ['student' => 'Min-ho Kim', 'student_id' => 'ST1-A001', 'date' => 'Oct 24, 2023', 'time' => '14:22 PM', 'package' => 'Intensive IELTS 50', 'country' => 'South Korea', 'discount' => 'Discount: 10%', 'discount_class' => 'text-success', 'amount' => '$1,350.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Credit Card', 'icon' => 'credit_card'],
            ['student' => 'Yuki Tanaka', 'student_id' => 'ST1-A005', 'date' => 'Oct 24, 2023', 'time' => '11:15 AM', 'package' => 'Business Pro', 'country' => 'Japan', 'discount' => 'No Discount', 'discount_class' => 'text-on-surface-variant', 'amount' => '$2,100.00', 'refunded' => 'Yes', 'refund_class' => 'bg-error/10 text-error border-error/20', 'method' => 'PayPal', 'icon' => 'account_balance'],
            ['student' => 'Li Wei', 'student_id' => 'ST2-B089', 'date' => 'Oct 23, 2023', 'time' => '17:45 PM', 'package' => 'Conversational 20', 'country' => 'China', 'discount' => 'Discount: 15%', 'discount_class' => 'text-success', 'amount' => '$850.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'E-wallet', 'icon' => 'wallet'],
            ['student' => 'Nguyen Tuan', 'student_id' => 'ST1-C112', 'date' => 'Oct 23, 2023', 'time' => '09:10 AM', 'package' => 'Youth Explorer', 'country' => 'Vietnam', 'discount' => 'No Discount', 'discount_class' => 'text-on-surface-variant', 'amount' => '$1,200.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Debit Card', 'icon' => 'payments'],
            ['student' => 'Sofia Garcia', 'student_id' => 'ST2-D044', 'date' => 'Oct 22, 2023', 'time' => '16:30 PM', 'package' => 'Kids English 30', 'country' => 'Thailand', 'discount' => 'Discount: 5%', 'discount_class' => 'text-success', 'amount' => '$980.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Credit Card', 'icon' => 'credit_card'],
            ['student' => 'Hana Park', 'student_id' => 'ST1-K221', 'date' => 'Oct 22, 2023', 'time' => '13:05 PM', 'package' => 'IELTS Writing Boost', 'country' => 'South Korea', 'discount' => 'No Discount', 'discount_class' => 'text-on-surface-variant', 'amount' => '$1,480.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Bank Transfer', 'icon' => 'account_balance'],
            ['student' => 'Akira Sato', 'student_id' => 'ST3-J017', 'date' => 'Oct 21, 2023', 'time' => '18:20 PM', 'package' => 'Business English Pro', 'country' => 'Japan', 'discount' => 'Discount: 10%', 'discount_class' => 'text-success', 'amount' => '$1,890.00', 'refunded' => 'Yes', 'refund_class' => 'bg-error/10 text-error border-error/20', 'method' => 'PayPal', 'icon' => 'account_balance'],
            ['student' => 'Chen Mei', 'student_id' => 'ST2-C330', 'date' => 'Oct 21, 2023', 'time' => '10:40 AM', 'package' => 'Casual Conversation 20', 'country' => 'China', 'discount' => 'No Discount', 'discount_class' => 'text-on-surface-variant', 'amount' => '$760.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'E-wallet', 'icon' => 'wallet'],
            ['student' => 'Mai Tran', 'student_id' => 'ST1-V078', 'date' => 'Oct 20, 2023', 'time' => '15:55 PM', 'package' => 'Starter Pack 10', 'country' => 'Vietnam', 'discount' => 'Discount: 20%', 'discount_class' => 'text-success', 'amount' => '$640.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Debit Card', 'icon' => 'payments'],
            ['student' => 'Pim Chan', 'student_id' => 'ST4-T019', 'date' => 'Oct 20, 2023', 'time' => '08:35 AM', 'package' => 'TOEFL Prep 25', 'country' => 'Thailand', 'discount' => 'No Discount', 'discount_class' => 'text-on-surface-variant', 'amount' => '$1,150.00', 'refunded' => 'No', 'refund_class' => 'bg-success/10 text-success border-success/20', 'method' => 'Credit Card', 'icon' => 'credit_card'],
        ]);
    }

    private function packageStats(): array
    {
        return [
            ['label' => 'Active Packages', 'value' => (string) count($this->pricingPackages()), 'icon' => 'inventory_2', 'class' => 'bg-primary/5 text-primary'],
            ['label' => 'Regions Covered', 'value' => (string) count($this->regionalPricingCountries()), 'icon' => 'public', 'class' => 'bg-active-accent/10 text-secondary'],
            ['label' => 'Categories', 'value' => '2', 'icon' => 'category', 'class' => 'bg-slate-100 text-on-surface-variant'],
        ];
    }

    private function pricingPackages(): array
    {
        $rows = [];

        foreach ($this->regionalPricingCountries() as $country) {
            foreach ($this->pricingCatalogForCountry($country) as $category => $categoryData) {
                foreach ($categoryData['packages'] as $package) {
                    $rows[] = [
                        'name' => $package['tier'].' Package',
                        'description' => $category.' - '.$categoryData['duration'].' per lesson',
                        'country' => $country,
                        'category' => $category,
                        'duration' => $categoryData['duration'],
                        'lessons' => $package['lessons'],
                        'price' => $package['price'],
                        'validity' => $package['validity'],
                        'discount' => $package['discount'],
                        'region_group' => $this->regionalPricingGroupForCountry($country)['label'],
                        'status' => 'Active',
                        'status_class' => 'bg-success/10 text-success border-success/20',
                        'icon' => $package['icon'],
                        'icon_class' => $package['icon_class'],
                    ];
                }
            }
        }

        return $rows;
    }

    private function regionalPricing(): array
    {
        return [
            'countries' => $this->regionalPricingCountries(),
            'groups' => $this->regionalPricingGroups(),
        ];
    }

    private function regionalPricingCountries(): array
    {
        return collect($this->regionalPricingGroups())
            ->flatMap(fn (array $group): array => $group['countries'])
            ->values()
            ->all();
    }

    private function regionalPricingGroups(): array
    {
        return [
            [
                'label' => 'Middle East & Europe',
                'description' => 'Saudi Arabia, UAE, Israel, Spain, Italy, France, Germany, and Poland',
                'countries' => ['Saudi Arabia', 'UAE', 'Israel', 'Spain', 'Italy', 'France', 'Germany', 'Poland'],
                'categories' => $this->pricingCatalog('middle_east_europe'),
            ],
            [
                'label' => 'Asia & Others',
                'description' => 'China, Vietnam, Thailand, Indonesia, Japan, South Korea, and Others',
                'countries' => ['China', 'Vietnam', 'Thailand', 'Indonesia', 'Japan', 'South Korea', 'Others'],
                'categories' => $this->pricingCatalog('asia_others'),
            ],
        ];
    }

    private function regionalPricingGroupForCountry(string $country): array
    {
        return collect($this->regionalPricingGroups())
            ->first(fn (array $group): bool => in_array($country, $group['countries'], true))
            ?? $this->regionalPricingGroups()[0];
    }

    private function pricingCatalogForCountry(string $country): array
    {
        return $this->regionalPricingGroupForCountry($country)['categories'];
    }

    private function pricingCatalog(string $group): array
    {
        $adultPrices = $group === 'asia_others'
            ? ['bronze' => '$55', 'silver' => '$165', 'gold' => '$330', 'platinum' => '$495']
            : ['bronze' => '$65', 'silver' => '$195', 'gold' => '$370.50', 'platinum' => '$538.20'];
        $kidsPrices = $group === 'asia_others'
            ? ['bronze' => '$30', 'silver' => '$90', 'gold' => '$180', 'platinum' => '$270']
            : ['bronze' => '$35', 'silver' => '$105', 'gold' => '$199.50', 'platinum' => '$289.80'];

        return [
            'Adult English' => [
                'duration' => '50 minutes',
                'packages' => [
                    ['tier' => 'Bronze', 'lessons' => 5, 'price' => $adultPrices['bronze'], 'validity' => 'Trial package - one-time purchase only', 'discount' => '-', 'icon' => 'school', 'icon_class' => 'bg-orange-50 text-orange-600'],
                    ['tier' => 'Silver', 'lessons' => 15, 'price' => $adultPrices['silver'], 'validity' => 'Valid for 1 month', 'discount' => '-', 'icon' => 'star_rate', 'icon_class' => 'bg-slate-100 text-slate-500'],
                    ['tier' => 'Gold', 'lessons' => 30, 'price' => $adultPrices['gold'], 'validity' => 'Valid for 2 months', 'discount' => '5% Off', 'icon' => 'star', 'icon_class' => 'bg-yellow-50 text-yellow-600'],
                    ['tier' => 'Platinum', 'lessons' => 45, 'price' => $adultPrices['platinum'], 'validity' => 'Valid for 3 months', 'discount' => '8% Off', 'icon' => 'workspace_premium', 'icon_class' => 'bg-indigo-50 text-indigo-500'],
                ],
            ],
            'Kids English' => [
                'duration' => '25 minutes',
                'packages' => [
                    ['tier' => 'Bronze', 'lessons' => 5, 'price' => $kidsPrices['bronze'], 'validity' => 'Trial package - one-time purchase only', 'discount' => '-', 'icon' => 'school', 'icon_class' => 'bg-orange-50 text-orange-600'],
                    ['tier' => 'Silver', 'lessons' => 15, 'price' => $kidsPrices['silver'], 'validity' => 'Valid for 1 month', 'discount' => '-', 'icon' => 'star_rate', 'icon_class' => 'bg-slate-100 text-slate-500'],
                    ['tier' => 'Gold', 'lessons' => 30, 'price' => $kidsPrices['gold'], 'validity' => 'Valid for 2 months', 'discount' => '5% Off', 'icon' => 'star', 'icon_class' => 'bg-yellow-50 text-yellow-600'],
                    ['tier' => 'Platinum', 'lessons' => 45, 'price' => $kidsPrices['platinum'], 'validity' => 'Valid for 3 months', 'discount' => '8% Off', 'icon' => 'workspace_premium', 'icon_class' => 'bg-indigo-50 text-indigo-500'],
                ],
            ],
        ];
    }

    private function lessonStats(): array
    {
        return [
            ['label' => 'Total Programs', 'value' => '7', 'icon' => 'book_4', 'class' => 'bg-primary-fixed text-primary'],
            ['label' => 'Modules Active', 'value' => '110', 'icon' => 'view_module', 'class' => 'bg-secondary-fixed text-secondary'],
            ['label' => 'Total Lessons', 'value' => '3,300', 'icon' => 'school', 'class' => 'bg-tertiary-fixed text-tertiary'],
            ['label' => 'PDF Resources', 'value' => '3,300', 'icon' => 'picture_as_pdf', 'class' => 'bg-orange-100 text-orange-600'],
        ];
    }

    private function lessonPrograms(): array
    {
        return [
            ['name' => 'CEFR (Adults)', 'audience' => 'Adults', 'levels' => '5 (A1-C1)', 'modules' => 50, 'lessons' => '1,500', 'pdfs' => '1,500', 'icon' => 'auto_stories', 'icon_class' => 'bg-blue-50 text-blue-600', 'href' => route('lessons.cefr')],
            ['name' => 'Business English', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'business_center', 'icon_class' => 'bg-green-50 text-green-600'],
            ['name' => 'Sales English', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'monitoring', 'icon_class' => 'bg-orange-50 text-orange-600'],
            ['name' => 'IELTS Preparation', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'headphones', 'icon_class' => 'bg-purple-50 text-purple-600'],
            ['name' => 'TOEFL Preparation', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'language', 'icon_class' => 'bg-indigo-50 text-indigo-600'],
            ['name' => 'Job Interview Preparation', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'record_voice_over', 'icon_class' => 'bg-amber-50 text-amber-600'],
            ['name' => 'Student Interview Preparation', 'audience' => 'Adults', 'levels' => '10', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'forum', 'icon_class' => 'bg-teal-50 text-teal-600'],
            ['name' => 'CEFR (Kids)', 'audience' => 'Kids', 'levels' => '5 (Pre-A1-B1)', 'modules' => 50, 'lessons' => '1,500', 'pdfs' => '1,500', 'icon' => 'auto_stories', 'icon_class' => 'bg-blue-50 text-blue-600', 'href' => route('lessons.cefr')],
            ['name' => 'Kids Starter English', 'audience' => 'Kids', 'levels' => '6', 'modules' => 12, 'lessons' => '360', 'pdfs' => '360', 'icon' => 'child_care', 'icon_class' => 'bg-pink-50 text-pink-600'],
            ['name' => 'Young Learners Phonics', 'audience' => 'Kids', 'levels' => '4', 'modules' => 8, 'lessons' => '240', 'pdfs' => '240', 'icon' => 'abc', 'icon_class' => 'bg-yellow-50 text-yellow-600'],
            ['name' => 'Kids Conversation Club', 'audience' => 'Kids', 'levels' => '5', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'groups', 'icon_class' => 'bg-cyan-50 text-cyan-600'],
            ['name' => 'Junior Reading Builder', 'audience' => 'Kids', 'levels' => '5', 'modules' => 10, 'lessons' => '300', 'pdfs' => '300', 'icon' => 'menu_book', 'icon_class' => 'bg-lime-50 text-lime-600'],
        ];
    }

    private function cefrModules(): array
    {
        return collect(range(1, 10))
            ->map(fn (int $number) => [
                'name' => "Module {$number}",
                'lessons' => 30,
                'active' => $number === 1,
            ])
            ->all();
    }

    private function cefrLessons(): array
    {
        return [
            ['number' => 1, 'title' => 'Lesson 1: Greetings and Introductions', 'file' => 'Lesson 1.pdf', 'status' => 'Published', 'active' => true],
            ['number' => 2, 'title' => 'Lesson 2: The Alphabet', 'file' => 'Lesson 2.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 3, 'title' => 'Lesson 3: Numbers 1-10', 'file' => 'Lesson 3.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 4, 'title' => 'Lesson 4: My Family', 'file' => 'Lesson 4.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 5, 'title' => 'Lesson 5: Colors', 'file' => 'Lesson 5.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 6, 'title' => 'Lesson 6: Daily Routines (Part 1)', 'file' => 'Lesson 6.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 7, 'title' => 'Lesson 7: Daily Routines (Part 2)', 'file' => 'Lesson 7.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 8, 'title' => 'Lesson 8: Food and Drinks', 'file' => 'Lesson 8.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 9, 'title' => 'Lesson 9: At School', 'file' => 'Lesson 9.pdf', 'status' => 'Published', 'active' => false],
            ['number' => 10, 'title' => 'Lesson 10: This is / These are', 'file' => 'Lesson 10.pdf', 'status' => 'Published', 'active' => false],
        ];
    }

    private function documentStats(): array
    {
        return [
            ['label' => 'Total Files', 'value' => '128', 'icon' => 'draft', 'class' => 'bg-primary-fixed text-primary'],
            ['label' => 'Folders', 'value' => '14', 'icon' => 'folder_open', 'class' => 'bg-secondary-fixed text-secondary'],
            ['label' => 'Admin Only', 'value' => '37', 'icon' => 'lock', 'class' => 'bg-red-50 text-red-600'],
            ['label' => 'Pending Review', 'value' => '8', 'icon' => 'rate_review', 'class' => 'bg-amber-50 text-amber-600'],
        ];
    }

    private function documentCategories(): array
    {
        return [
            ['name' => 'Legal & Registration', 'icon' => 'balance', 'active' => true],
            ['name' => 'HR & Internal', 'icon' => 'badge', 'active' => false],
            ['name' => 'Policies', 'icon' => 'gavel', 'active' => false],
            ['name' => 'Operations & SOPs', 'icon' => 'settings_account_box', 'active' => false],
            ['name' => 'Others', 'icon' => 'folder_open', 'active' => false],
        ];
    }

    private function companyDocumentsList(): array
    {
        return [
            ['name' => 'Certificate of Incorporation - 2024.pdf', 'meta' => '4.8 MB', 'type' => 'PDF Document', 'updated' => 'Oct 12, 2023', 'access' => 'Admin Only', 'access_class' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'picture_as_pdf', 'icon_class' => 'text-red-500'],
            ['name' => 'Operating Lease Agreement - Building A.docx', 'meta' => '1.2 MB', 'type' => 'Word Doc', 'updated' => 'Jan 05, 2024', 'access' => 'All Staff', 'access_class' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'description', 'icon_class' => 'text-blue-500'],
            ['name' => 'Annual Tax Registry - FY2023.xlsx', 'meta' => '856 KB', 'type' => 'Excel Sheet', 'updated' => 'Feb 28, 2024', 'access' => 'Admin Only', 'access_class' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'table_chart', 'icon_class' => 'text-green-600'],
            ['name' => '2022 Archive Registry', 'meta' => '12 items', 'type' => 'Folder', 'updated' => 'Dec 15, 2022', 'access' => 'All Staff', 'access_class' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'folder', 'icon_class' => 'text-amber-500'],
            ['name' => 'Business Registration - Shanghai District.pdf', 'meta' => '1.1 MB', 'type' => 'PDF Document', 'updated' => 'Mar 02, 2024', 'access' => 'Admin Only', 'access_class' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'picture_as_pdf', 'icon_class' => 'text-red-500'],
            ['name' => 'Teacher Handbook - Version 3.1.pdf', 'meta' => '2.4 MB', 'type' => 'PDF Document', 'updated' => 'Apr 18, 2024', 'access' => 'Managers', 'access_class' => 'bg-purple-50 text-purple-700 border-purple-200', 'icon' => 'picture_as_pdf', 'icon_class' => 'text-red-500'],
            ['name' => 'Refund Approval SOP.pdf', 'meta' => '780 KB', 'type' => 'PDF Document', 'updated' => 'May 02, 2024', 'access' => 'All Staff', 'access_class' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'rule', 'icon_class' => 'text-slate-500'],
        ];
    }

    private function roleSummaries(): array
    {
        return [
            ['key' => 'admin', 'label' => 'Admin', 'users' => 3, 'description' => 'Full system control, billing, payroll, pricing, and user permissions.', 'class' => 'bg-primary text-white', 'active' => true],
            ['key' => 'manager', 'label' => 'Manager', 'users' => 6, 'description' => 'Operations access for schedules, staff coordination, and selected reports.', 'class' => 'bg-blue-50 text-blue-700', 'active' => false],
            ['key' => 'teacher', 'label' => 'Teacher', 'users' => 42, 'description' => 'Teaching tools, assigned students, lesson records, and own schedule only.', 'class' => 'bg-green-50 text-green-700', 'active' => false],
            ['key' => 'student', 'label' => 'Student', 'users' => 318, 'description' => 'Student-facing profile, own lesson history, and permitted learning materials.', 'class' => 'bg-cyan-50 text-cyan-700', 'active' => false],
            ['key' => 'staff', 'label' => 'Staff', 'users' => 14, 'description' => 'Internal operations access without payroll, earnings, or sensitive pricing.', 'class' => 'bg-slate-100 text-slate-700', 'active' => false],
        ];
    }

    private function permissionGroups(): array
    {
        return [
            [
                'title' => 'Sidebar Access',
                'description' => 'Choose which main navigation items each role can open.',
                'items' => [
                    ['label' => 'Dashboard', 'detail' => 'CEO/Admin command center with company revenue, payroll, alerts, and business status', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Students', 'detail' => 'Student directory and profile access', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher', 'staff']],
                    ['label' => 'Teachers', 'detail' => 'Teacher directory and profile access', 'sensitive' => false, 'roles' => ['admin', 'manager', 'staff']],
                    ['label' => 'Staff', 'detail' => 'Staff directory and internal records', 'sensitive' => false, 'roles' => ['admin', 'manager']],
                    ['label' => 'Schedule Editor', 'detail' => 'Open/close blocks and assign students', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher']],
                    ['label' => 'Payments & Refunds', 'detail' => 'Student payment records and refund status', 'sensitive' => true, 'roles' => ['admin', 'manager']],
                    ['label' => 'Packages & Pricing', 'detail' => 'Package prices, discount rules, and country pricing', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Lessons', 'detail' => 'Curriculum, modules, and lesson PDFs', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher', 'student']],
                    ['label' => 'Company Documents', 'detail' => 'Internal policies, documents, and SOPs', 'sensitive' => true, 'roles' => ['admin', 'manager', 'staff']],
                    ['label' => 'Communication', 'detail' => 'Manual lesson feedback entry and internal Slack-style update drafts', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher', 'staff']],
                    ['label' => 'Message Center', 'detail' => 'Admin-only WhatsApp, Email, WeChat, and Facebook message drafts', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'User Management', 'detail' => 'Roles and access capability controls', 'sensitive' => true, 'roles' => ['admin']],
                ],
            ],
            [
                'title' => 'Student Profile Tabs',
                'description' => 'Control profile-level access inside a student record, especially contact and communication details.',
                'items' => [
                    ['label' => 'Payment History', 'detail' => 'Packages purchased, amount paid, discounts, and refunds', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Lesson History', 'detail' => 'Lesson records, teacher, time, and completion status', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher', 'student']],
                    ['label' => 'Student Communication Contacts', 'detail' => 'Mobile number, email, WhatsApp, WeChat, and other direct communication channels', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Manager Contact Exception', 'detail' => 'Occasional manager access to student contact details when approved by Admin', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Student Location Details', 'detail' => 'City, country, timezone, and non-direct location context', 'sensitive' => true, 'roles' => ['admin', 'manager', 'teacher']],
                ],
            ],
            [
                'title' => 'Communication & Message Center Tools',
                'description' => 'Control access to Advance feedback tools and sensitive external message drafts.',
                'items' => [
                    ['label' => 'Lesson Feedback Entry', 'detail' => 'Manually save teacher feedback to the student lesson record', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher']],
                    ['label' => 'Slack', 'detail' => 'Internal operations and team message drafts', 'sensitive' => false, 'roles' => ['admin', 'manager', 'staff']],
                    ['label' => 'WhatsApp', 'detail' => 'Direct WhatsApp communication drafts and contact-sensitive messages', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Email', 'detail' => 'Formal email drafts for sensitive student, parent, or billing communication', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'WeChat Message Generator', 'detail' => 'Bilingual WeChat-ready message drafts for manual copy and paste', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Facebook Message', 'detail' => 'Facebook Messenger drafts for parent and student inquiries', 'sensitive' => true, 'roles' => ['admin']],
                ],
            ],
            [
                'title' => 'Teacher Profile Tabs',
                'description' => 'Protect income and payroll visibility for teacher records.',
                'items' => [
                    ['label' => 'Teaching History', 'detail' => 'Completed lessons and student teaching records', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher']],
                    ['label' => 'Payroll', 'detail' => 'Teacher payroll, rates, bonuses, deductions, and net salary', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Itemized Lesson Statement', 'detail' => 'Daily lessons, duration, hourly rate, and income totals', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Teacher Schedule', 'detail' => 'Availability, assigned blocks, and student assignment status', 'sensitive' => false, 'roles' => ['admin', 'manager', 'teacher']],
                ],
            ],
            [
                'title' => 'Finance & Pricing Protections',
                'description' => 'Sensitive controls that should stay restricted unless explicitly approved.',
                'items' => [
                    ['label' => 'View Company Earnings', 'detail' => 'Revenue totals, payments dashboard, and refund summaries', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'View Other People Earnings', 'detail' => 'Teacher/staff payroll or income not belonging to the logged-in user', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Edit Package Prices', 'detail' => 'Country pricing, package amount, and discount configuration', 'sensitive' => true, 'roles' => ['admin']],
                    ['label' => 'Approve Refunds', 'detail' => 'Refund decisions, reversals, and payment adjustments', 'sensitive' => true, 'roles' => ['admin', 'manager']],
                ],
            ],
        ];
    }

    private function managedUsers(): array
    {
        return [
            ['name' => 'Van Santos', 'email' => 'admin@speakryt.com', 'role' => 'admin', 'type' => 'Admin', 'position' => 'CEO', 'country' => 'Philippines', 'profile_url' => route('profile.index'), 'status' => 'Active', 'last_login' => 'Today, 2:14 PM', 'access' => 'Full admin access', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Alex Thompson', 'email' => 'alex.thompson@email.com', 'role' => 'student', 'type' => 'Student', 'position' => 'Student', 'country' => 'Canada', 'profile_url' => route('students.show', ['student' => 'ST1-A001']), 'status' => 'Active', 'last_login' => 'Today, 11:08 AM', 'access' => 'Own lessons and package only', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Yuki Tanaka', 'email' => 'yuki.tanaka@email.com', 'role' => 'student', 'type' => 'Student', 'position' => 'Student', 'country' => 'Japan', 'profile_url' => route('students.show', ['student' => 'ST1-A005']), 'status' => 'Active', 'last_login' => 'Yesterday, 6:20 PM', 'access' => 'Own lessons and package only', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Li Wei', 'email' => 'li.wei@email.com', 'role' => 'student', 'type' => 'Student', 'position' => 'Student', 'country' => 'China', 'profile_url' => route('students.show', ['student' => 'ST2-B089']), 'status' => 'Renewal Due', 'last_login' => 'Jul 5, 2026', 'access' => 'Own lessons and package only', 'status_class' => 'bg-amber-50 text-amber-700'],
            ['name' => 'Sarah Anderson', 'email' => 'sarah.anderson@speakryt.com', 'role' => 'teacher', 'type' => 'Teacher', 'position' => 'Teacher', 'country' => 'United Kingdom', 'profile_url' => route('teachers.show', ['teacher' => 'T1-001']), 'status' => 'Active', 'last_login' => 'Today, 1:52 PM', 'access' => 'Schedule, assigned students, notes, payroll record', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Marcus Chen', 'email' => 'marcus.chen@speakryt.com', 'role' => 'teacher', 'type' => 'Teacher', 'position' => 'Trainer', 'country' => 'Japan', 'profile_url' => route('teachers.show', ['teacher' => 'T1-002']), 'status' => 'Active', 'last_login' => 'Today, 9:30 AM', 'access' => 'Schedule, assigned students, notes, payroll record', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Elena Rodriguez', 'email' => 'elena.rodriguez@speakryt.com', 'role' => 'teacher', 'type' => 'Teacher', 'position' => 'Teacher', 'country' => 'South Korea', 'profile_url' => route('teachers.show', ['teacher' => 'T1-003']), 'status' => 'On Leave', 'last_login' => 'Jul 6, 2026', 'access' => 'Schedule, assigned students, notes, payroll record', 'status_class' => 'bg-blue-50 text-blue-700'],
            ['name' => 'Michael Chen', 'email' => 'michael.chen@speakryt.com', 'role' => 'staff', 'type' => 'Staff', 'position' => 'Operations Manager', 'country' => 'Philippines', 'profile_url' => route('staff.show', ['staff' => 'SR-OM-4029']), 'status' => 'Active', 'last_login' => 'Today, 12:40 PM', 'access' => 'Operations tools, no earnings or pricing', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Maria Aquino', 'email' => 'maria.aquino@speakryt.com', 'role' => 'staff', 'type' => 'Staff', 'position' => 'Trainer', 'country' => 'Philippines', 'profile_url' => route('staff.show', ['staff' => 'STF-004']), 'status' => 'Active', 'last_login' => 'Yesterday, 4:15 PM', 'access' => 'Documents and assigned operations only', 'status_class' => 'bg-green-50 text-green-700'],
            ['name' => 'Takumi Kondo', 'email' => 'takumi.kondo@speakryt.com', 'role' => 'staff', 'type' => 'Staff', 'position' => 'Team Leader', 'country' => 'Japan', 'profile_url' => route('staff.show', ['staff' => 'STF-002']), 'status' => 'Suspended', 'last_login' => 'Jun 28, 2026', 'access' => 'Access paused by admin', 'status_class' => 'bg-red-50 text-red-700'],
            ['name' => 'Rico Dela Cruz', 'email' => 'rico.delacruz@speakryt.com', 'role' => 'staff', 'type' => 'Staff', 'position' => 'Assistant', 'country' => 'Philippines', 'profile_url' => route('staff.show', ['staff' => 'STF-008']), 'status' => 'Active', 'last_login' => 'Jul 6, 2026', 'access' => 'Assigned operations support only', 'status_class' => 'bg-green-50 text-green-700'],
        ];
    }

    private function adminProfile(): array
    {
        return [
            'name' => 'Van',
            'role' => 'Super Administrator',
            'email' => 'van@speakryt.edu',
            'phone' => '+1 (555) 012-3456',
            'language' => 'English (US)',
            'timezone' => '(GMT+08:00) Manila, Singapore',
            'employee_id' => 'ADM-001',
            'department' => 'Executive Operations',
            'office' => 'Global HQ / Remote',
            'status' => 'Active',
            'last_login' => 'Jul 07, 2026 · 09:42 AM',
            'photo_initials' => 'V',
            'bio' => 'Primary administrator overseeing sensitive payroll, pricing, user permissions, and cross-department approvals.',
            'two_factor_enabled' => true,
        ];
    }

    private function adminNotificationSettings(): array
    {
        return [
            ['label' => 'Email Notifications', 'description' => 'Policy changes, user requests, and approval queues', 'enabled' => true, 'icon' => 'mail'],
            ['label' => 'Browser Alerts', 'description' => 'Real-time warnings for refunds, payroll, and user access changes', 'enabled' => true, 'icon' => 'laptop_mac'],
            ['label' => 'SMS Notifications', 'description' => 'Critical security alerts only', 'enabled' => false, 'icon' => 'sms'],
            ['label' => 'Permission Change Alerts', 'description' => 'Notify when roles gain access to payroll, pricing, or student contacts', 'enabled' => true, 'icon' => 'shield_lock'],
        ];
    }

    private function adminAccessScopes(): array
    {
        return [
            ['title' => 'Sensitive Finance Access', 'items' => ['Payroll overview', 'Itemized lesson statements', 'Payments & refunds', 'Packages & pricing'], 'icon' => 'payments'],
            ['title' => 'People & Privacy Access', 'items' => ['Student communication contacts', 'Manager contact exceptions', 'User role permissions'], 'icon' => 'privacy_tip'],
            ['title' => 'Admin Controls', 'items' => ['Company documents', 'Schedule editor', 'User management changes'], 'icon' => 'admin_panel_settings'],
        ];
    }

    private function adminProfileActivity(): array
    {
        return [
            ['title' => 'Student contact permissions reviewed', 'time' => 'Today, 09:18 AM', 'status' => 'Privacy'],
            ['title' => 'Packages & pricing access kept Admin-only', 'time' => 'Today, 08:42 AM', 'status' => 'Sensitive'],
            ['title' => 'Manager contact exception remains disabled', 'time' => 'Yesterday, 06:30 PM', 'status' => 'Access'],
            ['title' => 'Trusted device list checked', 'time' => 'Jul 06, 2026, 10:14 PM', 'status' => 'Security'],
        ];
    }

    private function adminProfileChecklist(): array
    {
        return [
            ['label' => 'Two-factor authentication enabled', 'done' => true],
            ['label' => 'Student direct contacts restricted to Admin', 'done' => true],
            ['label' => 'Payroll and itemized statements restricted', 'done' => true],
            ['label' => 'Singapore session needs review', 'done' => false],
        ];
    }

    private function lessons(string $studentName, string $teacherName): array
    {
        return [
            ['date' => 'Oct 24, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'IELTS Speaking Part 2', 'teacher' => $teacherName, 'status' => 'Completed'],
            ['date' => 'Oct 20, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'Advanced Grammar: Modals', 'teacher' => $teacherName, 'status' => 'Completed'],
            ['date' => 'Oct 17, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'Vocabulary: Business Env', 'teacher' => $teacherName, 'status' => 'Not Completed'],
            ['date' => 'Oct 13, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'IELTS Writing Task 1', 'teacher' => $teacherName, 'status' => 'Completed'],
            ['date' => 'Oct 10, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'Free Talk: Travel', 'teacher' => $teacherName, 'status' => 'Completed'],
            ['date' => 'Oct 06, 2023', 'time' => '15:00 - 16:00', 'student' => $studentName, 'lesson' => 'Placement Interview', 'teacher' => $teacherName, 'status' => 'Completed'],
        ];
    }

    private function teachers(): array
    {
        return [
            'T1-001' => ['id' => 'T1-001', 'name' => 'Sarah Anderson', 'specialty' => 'Kids, IELTS', 'country' => 'United Kingdom', 'students_assigned' => 12, 'supervisor' => 'Michael Chen', 'employment_status' => 'Full-Time', 'employment_class' => 'bg-success/10 text-success', 'headline' => 'Senior ESL Instructor & Business English Lead', 'date_of_birth' => '12 July 1988', 'mobile' => '+1 (555) 010-9988', 'emergency_contact' => '+1 (555) 010-7766', 'hourly_rate' => 'P200.00/hr', 'hire_date' => 'Jan 15, 2022', 'resignation_date' => '-', 'employment_full' => 'Active Full-Time', 'email' => 'sarah.anderson@speakryt.com', 'specializations' => ['IELTS', 'BUSINESS ENGLISH', 'ADULTS', 'CEFR']],
            'T1-002' => ['id' => 'T1-002', 'name' => 'Marcus Chen', 'specialty' => 'Business English', 'country' => 'Japan', 'students_assigned' => 8, 'supervisor' => 'Emma Wilson', 'employment_status' => 'Part-Time', 'employment_class' => 'bg-blue-50 text-header-blue', 'headline' => 'Business English Instructor', 'date_of_birth' => '21 March 1990', 'mobile' => '+1 (555) 010-4421', 'emergency_contact' => '+1 (555) 010-3321', 'hourly_rate' => 'P180.00/hr', 'hire_date' => 'Apr 08, 2021', 'resignation_date' => '-', 'employment_full' => 'Active Part-Time', 'email' => 'marcus.chen@speakryt.com', 'specializations' => ['BUSINESS ENGLISH', 'PRESENTATIONS']],
            'T1-003' => ['id' => 'T1-003', 'name' => 'Elena Rodriguez', 'specialty' => 'Adults, Kids', 'country' => 'South Korea', 'students_assigned' => 15, 'supervisor' => 'David Miller', 'employment_status' => 'Full-Time', 'employment_class' => 'bg-success/10 text-success', 'headline' => 'Adults and Young Learners Coach', 'date_of_birth' => '04 Nov 1986', 'mobile' => '+1 (555) 010-8820', 'emergency_contact' => '+1 (555) 010-6612', 'hourly_rate' => 'P210.00/hr', 'hire_date' => 'Jun 19, 2020', 'resignation_date' => '-', 'employment_full' => 'Active Full-Time', 'email' => 'elena.rodriguez@speakryt.com', 'specializations' => ['ADULTS', 'KIDS']],
            'T1-004' => ['id' => 'T1-004', 'name' => 'David Miller', 'specialty' => 'Grammar, Conversation', 'country' => 'Vietnam', 'students_assigned' => 20, 'supervisor' => 'Sarah Anderson', 'employment_status' => 'Contract', 'employment_class' => 'bg-warning/10 text-warning', 'headline' => 'Conversation and Grammar Specialist', 'date_of_birth' => '15 Feb 1989', 'mobile' => '+1 (555) 010-5510', 'emergency_contact' => '+1 (555) 010-1112', 'hourly_rate' => 'P170.00/hr', 'hire_date' => 'Sep 01, 2022', 'resignation_date' => '-', 'employment_full' => 'Active Contract', 'email' => 'david.miller@speakryt.com', 'specializations' => ['GRAMMAR', 'CONVERSATION']],
            'T1-005' => ['id' => 'T1-005', 'name' => 'Linda Thompson', 'specialty' => 'IELTS, Business English', 'country' => 'Thailand', 'students_assigned' => 5, 'supervisor' => 'James Lee', 'employment_status' => 'Part-Time', 'employment_class' => 'bg-blue-50 text-header-blue', 'headline' => 'IELTS and Corporate English Coach', 'date_of_birth' => '30 Aug 1992', 'mobile' => '+1 (555) 010-6210', 'emergency_contact' => '+1 (555) 010-4408', 'hourly_rate' => 'P185.00/hr', 'hire_date' => 'Nov 10, 2023', 'resignation_date' => '-', 'employment_full' => 'Active Part-Time', 'email' => 'linda.thompson@speakryt.com', 'specializations' => ['IELTS', 'BUSINESS ENGLISH']],
            'T1-006' => ['id' => 'T1-006', 'name' => 'Robert Wilson', 'specialty' => 'Kids, Conversation', 'country' => 'Taiwan', 'students_assigned' => 18, 'supervisor' => 'Linda Thompson', 'employment_status' => 'Full-Time', 'employment_class' => 'bg-success/10 text-success', 'headline' => 'Kids Communication Mentor', 'date_of_birth' => '07 Jan 1991', 'mobile' => '+1 (555) 010-9042', 'emergency_contact' => '+1 (555) 010-2255', 'hourly_rate' => 'P195.00/hr', 'hire_date' => 'Jul 12, 2019', 'resignation_date' => '-', 'employment_full' => 'Active Full-Time', 'email' => 'robert.wilson@speakryt.com', 'specializations' => ['KIDS', 'CONVERSATION']],
            'T1-007' => ['id' => 'T1-007', 'name' => 'Sophia Garcia', 'specialty' => 'Grammar, IELTS', 'country' => 'Indonesia', 'students_assigned' => 10, 'supervisor' => 'Robert Wilson', 'employment_status' => 'Contract', 'employment_class' => 'bg-warning/10 text-warning', 'headline' => 'Grammar and Test Prep Instructor', 'date_of_birth' => '11 Dec 1993', 'mobile' => '+1 (555) 010-7811', 'emergency_contact' => '+1 (555) 010-7710', 'hourly_rate' => 'P175.00/hr', 'hire_date' => 'Mar 06, 2022', 'resignation_date' => '-', 'employment_full' => 'Active Contract', 'email' => 'sophia.garcia@speakryt.com', 'specializations' => ['GRAMMAR', 'IELTS']],
            'T1-008' => ['id' => 'T1-008', 'name' => 'James Lee', 'specialty' => 'Business English, Grammar', 'country' => 'Malaysia', 'students_assigned' => 14, 'supervisor' => 'Sophia Garcia', 'employment_status' => 'Full-Time', 'employment_class' => 'bg-success/10 text-success', 'headline' => 'Business Communication Trainer', 'date_of_birth' => '05 May 1987', 'mobile' => '+1 (555) 010-1102', 'emergency_contact' => '+1 (555) 010-0084', 'hourly_rate' => 'P205.00/hr', 'hire_date' => 'May 18, 2018', 'resignation_date' => '-', 'employment_full' => 'Active Full-Time', 'email' => 'james.lee@speakryt.com', 'specializations' => ['BUSINESS ENGLISH', 'GRAMMAR']],
            'T1-009' => ['id' => 'T1-009', 'name' => 'Sarah Kim', 'specialty' => 'IELTS, TOEFL', 'country' => 'Philippines', 'students_assigned' => 12, 'supervisor' => 'Marcus Chen', 'employment_status' => 'Part-Time', 'employment_class' => 'bg-blue-50 text-header-blue', 'headline' => 'Exam Preparation Specialist', 'date_of_birth' => '26 Sep 1994', 'mobile' => '+1 (555) 010-6672', 'emergency_contact' => '+1 (555) 010-5519', 'hourly_rate' => 'P190.00/hr', 'hire_date' => 'Jan 22, 2023', 'resignation_date' => '-', 'employment_full' => 'Active Part-Time', 'email' => 'sarah.kim@speakryt.com', 'specializations' => ['IELTS', 'TOEFL']],
            'T1-010' => ['id' => 'T1-010', 'name' => 'David Chen', 'specialty' => 'Conversational English', 'country' => 'Singapore', 'students_assigned' => 9, 'supervisor' => 'Elena Rodriguez', 'employment_status' => 'Full-Time', 'employment_class' => 'bg-success/10 text-success', 'headline' => 'Conversational English Coach', 'date_of_birth' => '17 Apr 1985', 'mobile' => '+1 (555) 010-3347', 'emergency_contact' => '+1 (555) 010-2214', 'hourly_rate' => 'P200.00/hr', 'hire_date' => 'Feb 14, 2020', 'resignation_date' => '-', 'employment_full' => 'Active Full-Time', 'email' => 'david.chen@speakryt.com', 'specializations' => ['CONVERSATIONAL ENGLISH']],
        ];
    }

    private function teachingHistory(): array
    {
        return $this->withStudentCategories([
            ['date' => 'Oct 24, 2023', 'student_name' => 'Lucas Martinez', 'student_id' => 'ST-4592', 'lesson_type' => 'IELTS Speaking Prep', 'duration' => '60 Mins', 'status' => 'COMPLETED', 'status_class' => 'bg-success/10 text-success', 'earnings' => 'P200.00', 'initials' => 'LM', 'initials_class' => 'bg-primary/10 text-primary'],
            ['date' => 'Oct 23, 2023', 'student_name' => 'Sophie Wong', 'student_id' => 'ST-8821', 'lesson_type' => 'Business Writing', 'duration' => '45 Mins', 'status' => 'COMPLETED', 'status_class' => 'bg-success/10 text-success', 'earnings' => 'P150.00', 'initials' => 'SW', 'initials_class' => 'bg-secondary-container/20 text-secondary'],
            ['date' => 'Oct 22, 2023', 'student_name' => 'Ahmed El-Sayed', 'student_id' => 'ST-3301', 'lesson_type' => 'General English', 'duration' => '60 Mins', 'status' => 'NO SHOW', 'status_class' => 'bg-error/10 text-error', 'earnings' => 'P100.00', 'initials' => 'AE', 'initials_class' => 'bg-tertiary-fixed-dim text-tertiary'],
            ['date' => 'Oct 20, 2023', 'student_name' => 'Ji-Woo Lee', 'student_id' => 'ST-5562', 'lesson_type' => 'Executive Coaching', 'duration' => '90 Mins', 'status' => 'COMPLETED', 'status_class' => 'bg-success/10 text-success', 'earnings' => 'P300.00', 'initials' => 'JL', 'initials_class' => 'bg-primary/10 text-primary'],
            ['date' => 'Oct 19, 2023', 'student_name' => 'Elena Belova', 'student_id' => 'ST-9004', 'lesson_type' => 'TOEFL Academic Reading', 'duration' => '60 Mins', 'status' => 'COMPLETED', 'status_class' => 'bg-success/10 text-success', 'earnings' => 'P200.00', 'initials' => 'EB', 'initials_class' => 'bg-secondary-container/20 text-secondary'],
            ['date' => 'Oct 18, 2023', 'student_name' => 'Hiroshi Kobayashi', 'student_id' => 'ST-2210', 'lesson_type' => 'Intermediate Grammar', 'duration' => '60 Mins', 'status' => 'COMPLETED', 'status_class' => 'bg-success/10 text-success', 'earnings' => 'P200.00', 'initials' => 'HK', 'initials_class' => 'bg-tertiary-fixed-dim text-tertiary'],
        ], 'student_name');
    }

    private function payrollHistory(): array
    {
        return [
            ['id' => '#PR-2024-05-15', 'slug' => 'PR-2024-05-15', 'period' => 'May 01 - 15, 2024', 'cutoff' => 'Cutoff: May 16', 'hourly_rate' => 'P200.00', 'lessons' => '32 Lessons', 'hours' => '48.5 Total Hours', 'gross_salary' => 'P6,400.00', 'bonus_deduction' => '+P500.00', 'bonus_class' => 'text-success', 'net_salary' => 'P6,900.00', 'status' => 'Pending Approval', 'status_class' => 'bg-warning/10 text-warning border-warning/30'],
            ['id' => '#PR-2024-04-30', 'slug' => 'PR-2024-04-30', 'period' => 'Apr 16 - 30, 2024', 'cutoff' => 'Cutoff: May 01', 'hourly_rate' => 'P200.00', 'lessons' => '30 Lessons', 'hours' => '45.0 Total Hours', 'gross_salary' => 'P6,000.00', 'bonus_deduction' => '-P100.00', 'bonus_class' => 'text-error', 'net_salary' => 'P5,900.00', 'status' => 'Processed & Paid', 'status_class' => 'bg-success/10 text-success border-success/30'],
            ['id' => '#PR-2024-04-15', 'slug' => 'PR-2024-04-15', 'period' => 'Apr 01 - 15, 2024', 'cutoff' => 'Cutoff: Apr 16', 'hourly_rate' => 'P200.00', 'lessons' => '35 Lessons', 'hours' => '52.5 Total Hours', 'gross_salary' => 'P7,000.00', 'bonus_deduction' => 'None', 'bonus_class' => 'text-on-surface-variant', 'net_salary' => 'P7,000.00', 'status' => 'Processed & Paid', 'status_class' => 'bg-success/10 text-success border-success/30'],
        ];
    }

    private function payrollBreakdown(string $payrollSlug): array
    {
        $records = [
            'PR-2024-05-15' => [
                'summary' => [
                    'period' => 'May 01 - 15, 2024',
                    'subtitle' => 'Showing 10 lesson records for this period.',
                    'total_earnings' => 'P6,900.00',
                    'total_records' => 10,
                    'teacher_role' => 'Senior ESL Instructor',
                    'employment_badge' => 'Full-Time Staff',
                ],
                'rows' => [
                    ['date' => 'May 01, 2024', 'day' => 'Wednesday', 'time' => '09:00 - 09:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Alex Thompson', 'country' => 'China', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'May 01, 2024', 'day' => 'Wednesday', 'time' => '10:00 - 10:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Sarah Jenkins', 'country' => 'South Korea', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'May 02, 2024', 'day' => 'Thursday', 'time' => '14:00 - 14:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Hiroshi Tanaka', 'country' => 'Japan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'May 02, 2024', 'day' => 'Thursday', 'time' => '15:00 - 15:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Li Wei', 'country' => 'China', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'May 03, 2024', 'day' => 'Friday', 'time' => '09:00 - 09:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Elena Petrov', 'country' => 'Russia', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'May 03, 2024', 'day' => 'Friday', 'time' => '10:00 - 10:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Marcus Aurelius', 'country' => 'Italy', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'May 06, 2024', 'day' => 'Monday', 'time' => '09:00 - 09:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Yuki Sato', 'country' => 'Japan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'May 06, 2024', 'day' => 'Monday', 'time' => '11:00 - 11:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Hans Schmidt', 'country' => 'Germany', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'May 07, 2024', 'day' => 'Tuesday', 'time' => '14:00 - 14:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Sofia Rossi', 'country' => 'Italy', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'May 07, 2024', 'day' => 'Tuesday', 'time' => '15:00 - 15:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Jean Dupont', 'country' => 'France', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                ],
            ],
            'PR-2024-04-30' => [
                'summary' => [
                    'period' => 'Apr 16 - 30, 2024',
                    'subtitle' => 'Showing 8 lesson records for this period.',
                    'total_earnings' => 'P5,900.00',
                    'total_records' => 8,
                    'teacher_role' => 'Senior ESL Instructor',
                    'employment_badge' => 'Full-Time Staff',
                ],
                'rows' => [
                    ['date' => 'Apr 16, 2024', 'day' => 'Tuesday', 'time' => '09:00 - 09:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Mina Park', 'country' => 'South Korea', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 16, 2024', 'day' => 'Tuesday', 'time' => '10:00 - 10:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Takashi Endo', 'country' => 'Japan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 17, 2024', 'day' => 'Wednesday', 'time' => '14:00 - 14:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Amelia Wong', 'country' => 'Singapore', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 18, 2024', 'day' => 'Thursday', 'time' => '15:00 - 15:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'David Kim', 'country' => 'Philippines', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 19, 2024', 'day' => 'Friday', 'time' => '08:00 - 08:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Olivia Chen', 'country' => 'Taiwan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 22, 2024', 'day' => 'Monday', 'time' => '13:00 - 13:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Lucas Meyer', 'country' => 'Germany', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 23, 2024', 'day' => 'Tuesday', 'time' => '16:00 - 16:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Siti Rahma', 'country' => 'Indonesia', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 24, 2024', 'day' => 'Wednesday', 'time' => '18:00 - 18:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Nadia Petrova', 'country' => 'Russia', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                ],
            ],
            'PR-2024-04-15' => [
                'summary' => [
                    'period' => 'Apr 01 - 15, 2024',
                    'subtitle' => 'Showing 9 lesson records for this period.',
                    'total_earnings' => 'P7,000.00',
                    'total_records' => 9,
                    'teacher_role' => 'Senior ESL Instructor',
                    'employment_badge' => 'Full-Time Staff',
                ],
                'rows' => [
                    ['date' => 'Apr 01, 2024', 'day' => 'Monday', 'time' => '08:00 - 08:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Anna Lee', 'country' => 'South Korea', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 01, 2024', 'day' => 'Monday', 'time' => '09:00 - 09:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Kai Huang', 'country' => 'China', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 02, 2024', 'day' => 'Tuesday', 'time' => '10:00 - 10:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Ren Ito', 'country' => 'Japan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 03, 2024', 'day' => 'Wednesday', 'time' => '14:00 - 14:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Marco Silva', 'country' => 'Brazil', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 04, 2024', 'day' => 'Thursday', 'time' => '15:00 - 15:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Claire Dubois', 'country' => 'France', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 05, 2024', 'day' => 'Friday', 'time' => '17:00 - 17:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Daniel Cruz', 'country' => 'Philippines', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 08, 2024', 'day' => 'Monday', 'time' => '12:00 - 12:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Hana Mori', 'country' => 'Japan', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                    ['date' => 'Apr 10, 2024', 'day' => 'Wednesday', 'time' => '18:00 - 18:25', 'duration' => '25 mins', 'duration_class' => 'bg-blue-50 text-blue-600', 'student' => 'Miguel Santos', 'country' => 'Spain', 'hourly_rate' => 'P200.00', 'daily_income' => 'P100.00'],
                    ['date' => 'Apr 12, 2024', 'day' => 'Friday', 'time' => '19:00 - 19:50', 'duration' => '50 mins', 'duration_class' => 'bg-indigo-50 text-indigo-600', 'student' => 'Grace Lim', 'country' => 'Malaysia', 'hourly_rate' => 'P200.00', 'daily_income' => 'P200.00'],
                ],
            ],
        ];

        $record = $records[$payrollSlug] ?? $records['PR-2024-05-15'];
        $record['rows'] = $this->withStudentCategories($record['rows']);

        return $record;
    }

    private function staffMembers(): array
    {
        return [
            ['id' => 'SR-OM-4029', 'name' => 'Michael Chen', 'role' => 'Operations Manager', 'country' => 'Philippines', 'assigned_teachers' => 6, 'direct_manager' => 'CEO Van', 'manager_position' => 'Founder & CEO', 'hire_date' => 'Jan 15, 2021', 'status' => 'Active', 'status_class' => 'bg-green-100 text-green-700', 'dot_class' => 'bg-green-600', 'avatar_class' => 'bg-blue-100 text-primary', 'initials' => 'MC'],
            ['id' => 'STF-002', 'name' => 'Takumi Kondo', 'role' => 'Regional Coordinator', 'country' => 'Japan', 'assigned_teachers' => 8, 'direct_manager' => 'Operations Manager - Japan', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'Mar 12, 2022', 'status' => 'Active', 'status_class' => 'bg-green-100 text-green-700', 'dot_class' => 'bg-green-600', 'avatar_class' => 'bg-blue-50 text-secondary', 'initials' => 'TK'],
            ['id' => 'STF-003', 'name' => 'Ji-hu Seo', 'role' => 'Support Manager', 'country' => 'South Korea', 'assigned_teachers' => 15, 'direct_manager' => 'Operations Manager - South Korea', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'Aug 03, 2021', 'status' => 'Suspended', 'status_class' => 'bg-yellow-100 text-yellow-700', 'dot_class' => 'bg-yellow-500', 'avatar_class' => 'bg-yellow-50 text-warning', 'initials' => 'JS'],
            ['id' => 'STF-004', 'name' => 'Maria Aquino', 'role' => 'Training Supervisor', 'country' => 'Philippines', 'assigned_teachers' => 5, 'direct_manager' => 'CEO Van', 'manager_position' => 'Founder & CEO', 'hire_date' => 'Nov 20, 2020', 'status' => 'Resigned', 'status_class' => 'bg-gray-100 text-gray-600', 'dot_class' => 'bg-gray-400', 'avatar_class' => 'bg-gray-100 text-gray-600', 'initials' => 'MA'],
            ['id' => 'STF-005', 'name' => 'Chen Li', 'role' => 'Senior Consultant', 'country' => 'Vietnam', 'assigned_teachers' => 20, 'direct_manager' => 'Operations Manager - Vietnam', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'May 08, 2023', 'status' => 'Active', 'status_class' => 'bg-green-100 text-green-700', 'dot_class' => 'bg-green-600', 'avatar_class' => 'bg-blue-100 text-primary', 'initials' => 'CL'],
            ['id' => 'STF-006', 'name' => 'Hiroshi Sato', 'role' => 'Logistics Manager', 'country' => 'Japan', 'assigned_teachers' => 10, 'direct_manager' => 'Operations Manager - Japan', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'Feb 14, 2022', 'status' => 'Active', 'status_class' => 'bg-green-100 text-green-700', 'dot_class' => 'bg-green-600', 'avatar_class' => 'bg-blue-50 text-secondary', 'initials' => 'HS'],
            ['id' => 'STF-007', 'name' => 'Park Kim', 'role' => 'HR Specialist', 'country' => 'South Korea', 'assigned_teachers' => 14, 'direct_manager' => 'Operations Manager - South Korea', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'Sep 01, 2022', 'status' => 'Active', 'status_class' => 'bg-green-100 text-green-700', 'dot_class' => 'bg-green-600', 'avatar_class' => 'bg-blue-100 text-primary', 'initials' => 'PK'],
            ['id' => 'STF-008', 'name' => 'Rico Dela Cruz', 'role' => 'Field Supervisor', 'country' => 'Philippines', 'assigned_teachers' => 7, 'direct_manager' => 'Operations Manager - China', 'manager_position' => 'Regional Operations Lead', 'hire_date' => 'Jun 18, 2023', 'status' => 'Suspended', 'status_class' => 'bg-yellow-100 text-yellow-700', 'dot_class' => 'bg-yellow-500', 'avatar_class' => 'bg-yellow-50 text-warning', 'initials' => 'RD'],
        ];
    }

    private function staffProfiles(): array
    {
        return [
            'SR-OM-4029' => [
                'id' => 'SR-OM-4029',
                'name' => 'Michael Chen',
                'role' => 'Operations Manager',
                'date_of_birth' => '22 May 1985',
                'mobile' => '+1 (555) 012-3456',
                'emergency_contact' => '+1 (555) 987-6543',
                'hourly_rate' => 'P200.00/hr',
                'country' => 'Philippines',
                'hire_date' => 'Jan 15, 2021',
                'employment_full' => 'Active Full-Time',
                'status_label' => 'ACTIVE STAFF',
                'status_badge_class' => 'bg-success/10 text-success',
            ],
            'STF-002' => [
                'id' => 'STF-002',
                'name' => 'Takumi Kondo',
                'role' => 'Regional Coordinator',
                'date_of_birth' => '09 Feb 1988',
                'mobile' => '+81 90 4567 2210',
                'emergency_contact' => '+81 90 9981 7744',
                'hourly_rate' => 'P185.00/hr',
                'country' => 'Japan',
                'hire_date' => 'Mar 12, 2022',
                'employment_full' => 'Active Full-Time',
                'status_label' => 'ACTIVE STAFF',
                'status_badge_class' => 'bg-success/10 text-success',
            ],
            'STF-003' => [
                'id' => 'STF-003',
                'name' => 'Ji-hu Seo',
                'role' => 'Support Manager',
                'date_of_birth' => '18 Sep 1990',
                'mobile' => '+82 10 4221 1133',
                'emergency_contact' => '+82 10 9004 1155',
                'hourly_rate' => 'P170.00/hr',
                'country' => 'South Korea',
                'hire_date' => 'Aug 03, 2021',
                'employment_full' => 'Suspended',
                'status_label' => 'SUSPENDED',
                'status_badge_class' => 'bg-warning/10 text-warning',
            ],
            'STF-004' => [
                'id' => 'STF-004',
                'name' => 'Maria Aquino',
                'role' => 'Training Supervisor',
                'date_of_birth' => '11 Jun 1987',
                'mobile' => '+63 917 555 4421',
                'emergency_contact' => '+63 917 111 2200',
                'hourly_rate' => 'P190.00/hr',
                'country' => 'Philippines',
                'hire_date' => 'Oct 21, 2020',
                'employment_full' => 'Resigned',
                'status_label' => 'RESIGNED',
                'status_badge_class' => 'bg-slate-100 text-slate-600',
            ],
            'STF-005' => [
                'id' => 'STF-005',
                'name' => 'Chen Li',
                'role' => 'Senior Consultant',
                'date_of_birth' => '27 Apr 1984',
                'mobile' => '+84 91 777 3322',
                'emergency_contact' => '+84 91 333 8821',
                'hourly_rate' => 'P220.00/hr',
                'country' => 'Vietnam',
                'hire_date' => 'Jan 09, 2019',
                'employment_full' => 'Active Full-Time',
                'status_label' => 'ACTIVE STAFF',
                'status_badge_class' => 'bg-success/10 text-success',
            ],
            'STF-006' => [
                'id' => 'STF-006',
                'name' => 'Hiroshi Sato',
                'role' => 'Logistics Manager',
                'date_of_birth' => '30 Dec 1986',
                'mobile' => '+81 80 3434 2255',
                'emergency_contact' => '+81 80 1111 6622',
                'hourly_rate' => 'P180.00/hr',
                'country' => 'Japan',
                'hire_date' => 'May 16, 2020',
                'employment_full' => 'Active Full-Time',
                'status_label' => 'ACTIVE STAFF',
                'status_badge_class' => 'bg-success/10 text-success',
            ],
            'STF-007' => [
                'id' => 'STF-007',
                'name' => 'Park Kim',
                'role' => 'HR Specialist',
                'date_of_birth' => '07 Jan 1992',
                'mobile' => '+82 10 6641 0088',
                'emergency_contact' => '+82 10 2020 7741',
                'hourly_rate' => 'P175.00/hr',
                'country' => 'South Korea',
                'hire_date' => 'Nov 28, 2022',
                'employment_full' => 'Active Full-Time',
                'status_label' => 'ACTIVE STAFF',
                'status_badge_class' => 'bg-success/10 text-success',
            ],
            'STF-008' => [
                'id' => 'STF-008',
                'name' => 'Rico Dela Cruz',
                'role' => 'Field Supervisor',
                'date_of_birth' => '03 Mar 1989',
                'mobile' => '+63 917 200 1188',
                'emergency_contact' => '+63 917 700 5511',
                'hourly_rate' => 'P165.00/hr',
                'country' => 'Philippines',
                'hire_date' => 'Jul 04, 2023',
                'employment_full' => 'Suspended',
                'status_label' => 'SUSPENDED',
                'status_badge_class' => 'bg-warning/10 text-warning',
            ],
        ];
    }

    private function managedTeachers(): array
    {
        return [
            ['id' => 'T1-001', 'name' => 'Sarah Anderson', 'employment_status' => 'Active Full-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
            ['id' => 'T1-002', 'name' => 'James Wilson', 'employment_status' => 'Active Full-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
            ['id' => 'T1-003', 'name' => 'Maria Garcia', 'employment_status' => 'Active Part-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
            ['id' => 'T1-004', 'name' => 'David Lee', 'employment_status' => 'Active Full-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
            ['id' => 'T1-005', 'name' => 'Elena Rossi', 'employment_status' => 'Active Part-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
            ['id' => 'T1-006', 'name' => 'Robert Brown', 'employment_status' => 'Active Full-Time', 'status_class' => 'bg-success/10 text-success', 'hourly_rate' => 'P200.00 PHP', 'country' => 'Philippines'],
        ];
    }

    private function staffPayrollHistory(): array
    {
        return [
            ['id' => '#PY-2023-10', 'slug' => 'PY-2023-10', 'period' => 'Oct 01 - Oct 31, 2023', 'hourly_rate' => 'P200.00', 'monthly_fixed' => 'P40,000.00', 'gross_salary' => 'P40,000.00', 'bonus_deduction' => '+P2,500.00', 'bonus_class' => 'text-success', 'net_salary' => 'P42,500.00', 'status' => 'Paid', 'status_class' => 'bg-success/10 text-success border-success/30'],
            ['id' => '#PY-2023-09', 'slug' => 'PY-2023-09', 'period' => 'Sep 01 - Sep 30, 2023', 'hourly_rate' => 'P200.00', 'monthly_fixed' => 'P40,000.00', 'gross_salary' => 'P40,000.00', 'bonus_deduction' => '-P500.00', 'bonus_class' => 'text-error', 'net_salary' => 'P39,500.00', 'status' => 'Paid', 'status_class' => 'bg-success/10 text-success border-success/30'],
            ['id' => '#PY-2023-08', 'slug' => 'PY-2023-08', 'period' => 'Aug 01 - Aug 31, 2023', 'hourly_rate' => 'P200.00', 'monthly_fixed' => 'P40,000.00', 'gross_salary' => 'P40,000.00', 'bonus_deduction' => 'P0.00', 'bonus_class' => 'text-on-surface-variant', 'net_salary' => 'P40,000.00', 'status' => 'Paid', 'status_class' => 'bg-success/10 text-success border-success/30'],
            ['id' => '#PY-2023-07', 'slug' => 'PY-2023-07', 'period' => 'Jul 01 - Jul 31, 2023', 'hourly_rate' => 'P200.00', 'monthly_fixed' => 'P40,000.00', 'gross_salary' => 'P40,000.00', 'bonus_deduction' => '+P5,000.00', 'bonus_class' => 'text-success', 'net_salary' => 'P45,000.00', 'status' => 'Approved', 'status_class' => 'bg-secondary/10 text-secondary border-secondary/30'],
        ];
    }

    private function staffPayrollBreakdown(string $payrollSlug): array
    {
        $records = [
            'PY-2023-10' => [
                'summary' => [
                    'period' => 'Oct 01 - Oct 31, 2023',
                    'subtitle' => 'Showing 10 staff payroll line items for this period.',
                    'total_earnings' => 'P24,600.00',
                    'total_records' => 138,
                    'role' => 'Operations Manager',
                    'employment_badge' => 'Full-Time Staff',
                    'headline_total' => 'P24,600.00',
                    'headline_label' => 'Monthly Earnings (Oct 2023)',
                ],
                'rows' => [
                    ['date' => 'Oct 01, 2023', 'day' => 'Monday', 'item' => 'Operations shift', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 02, 2023', 'day' => 'Tuesday', 'item' => 'Teacher scheduling review', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 03, 2023', 'day' => 'Wednesday', 'item' => 'Payroll validation', 'category' => 'Payroll Support', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 04, 2023', 'day' => 'Thursday', 'item' => 'Staff coordination', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 05, 2023', 'day' => 'Friday', 'item' => 'Schedule exception handling', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 09, 2023', 'day' => 'Monday', 'item' => 'Monthly report preparation', 'category' => 'Reporting', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 12, 2023', 'day' => 'Thursday', 'item' => 'Teacher attendance audit', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 18, 2023', 'day' => 'Wednesday', 'item' => 'Manager approval workflow', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 25, 2023', 'day' => 'Wednesday', 'item' => 'Performance review support', 'category' => 'HR Support', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Oct 31, 2023', 'day' => 'Tuesday', 'item' => 'Attendance bonus', 'category' => 'Bonus', 'hours' => '-', 'rate' => '-', 'amount' => 'P2,500.00'],
                ],
            ],
            'PY-2023-09' => [
                'summary' => [
                    'period' => 'Sep 01 - Sep 30, 2023',
                    'subtitle' => 'Showing 8 staff payroll line items for this period.',
                    'total_earnings' => 'P39,500.00',
                    'total_records' => 120,
                    'role' => 'Operations Manager',
                    'employment_badge' => 'Full-Time Staff',
                    'headline_total' => 'P39,500.00',
                    'headline_label' => 'Monthly Earnings (Sep 2023)',
                ],
                'rows' => [
                    ['date' => 'Sep 01, 2023', 'day' => 'Friday', 'item' => 'Operations shift', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 04, 2023', 'day' => 'Monday', 'item' => 'Scheduling support', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 08, 2023', 'day' => 'Friday', 'item' => 'Payroll validation', 'category' => 'Payroll Support', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 12, 2023', 'day' => 'Tuesday', 'item' => 'Team attendance audit', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 15, 2023', 'day' => 'Friday', 'item' => 'Report preparation', 'category' => 'Reporting', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 20, 2023', 'day' => 'Wednesday', 'item' => 'Manager support', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 25, 2023', 'day' => 'Monday', 'item' => 'Staff coordination', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Sep 30, 2023', 'day' => 'Saturday', 'item' => 'Attendance deduction', 'category' => 'Deduction', 'hours' => '-', 'rate' => '-', 'amount' => '-P500.00'],
                ],
            ],
            'PY-2023-08' => [
                'summary' => [
                    'period' => 'Aug 01 - Aug 31, 2023',
                    'subtitle' => 'Showing 6 staff payroll line items for this period.',
                    'total_earnings' => 'P40,000.00',
                    'total_records' => 96,
                    'role' => 'Operations Manager',
                    'employment_badge' => 'Full-Time Staff',
                    'headline_total' => 'P40,000.00',
                    'headline_label' => 'Monthly Earnings (Aug 2023)',
                ],
                'rows' => [
                    ['date' => 'Aug 01, 2023', 'day' => 'Tuesday', 'item' => 'Operations shift', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Aug 07, 2023', 'day' => 'Monday', 'item' => 'Schedule review', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Aug 11, 2023', 'day' => 'Friday', 'item' => 'Payroll preparation', 'category' => 'Payroll Support', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Aug 16, 2023', 'day' => 'Wednesday', 'item' => 'Teacher records audit', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Aug 23, 2023', 'day' => 'Wednesday', 'item' => 'Staff coordination', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Aug 31, 2023', 'day' => 'Thursday', 'item' => 'Monthly closing', 'category' => 'Reporting', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                ],
            ],
            'PY-2023-07' => [
                'summary' => [
                    'period' => 'Jul 01 - Jul 31, 2023',
                    'subtitle' => 'Showing 6 staff payroll line items for this period.',
                    'total_earnings' => 'P45,000.00',
                    'total_records' => 104,
                    'role' => 'Operations Manager',
                    'employment_badge' => 'Full-Time Staff',
                    'headline_total' => 'P45,000.00',
                    'headline_label' => 'Monthly Earnings (Jul 2023)',
                ],
                'rows' => [
                    ['date' => 'Jul 03, 2023', 'day' => 'Monday', 'item' => 'Operations shift', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Jul 07, 2023', 'day' => 'Friday', 'item' => 'Attendance audit', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Jul 12, 2023', 'day' => 'Wednesday', 'item' => 'Admin support', 'category' => 'Admin Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Jul 18, 2023', 'day' => 'Tuesday', 'item' => 'Manager workflow review', 'category' => 'Operations', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Jul 24, 2023', 'day' => 'Monday', 'item' => 'Staff coordination', 'category' => 'Regular Work', 'hours' => '8.0 hrs', 'rate' => 'P200.00', 'amount' => 'P1,600.00'],
                    ['date' => 'Jul 31, 2023', 'day' => 'Monday', 'item' => 'Performance bonus', 'category' => 'Bonus', 'hours' => '-', 'rate' => '-', 'amount' => 'P5,000.00'],
                ],
            ],
        ];

        return $records[$payrollSlug] ?? $records['PY-2023-10'];
    }

    private function scheduleDays(): array
    {
        return [
            ['key' => 'mon', 'label' => 'Mon', 'date' => 'Oct 23', 'highlighted' => false],
            ['key' => 'tue', 'label' => 'Tue', 'date' => 'Oct 24', 'highlighted' => true],
            ['key' => 'wed', 'label' => 'Wed', 'date' => 'Oct 25', 'highlighted' => false],
            ['key' => 'thu', 'label' => 'Thu', 'date' => 'Oct 26', 'highlighted' => false],
            ['key' => 'fri', 'label' => 'Fri', 'date' => 'Oct 27', 'highlighted' => false],
            ['key' => 'sat', 'label' => 'Sat', 'date' => 'Oct 28', 'highlighted' => false],
            ['key' => 'sun', 'label' => 'Sun', 'date' => 'Oct 29', 'highlighted' => false],
        ];
    }

    private function scheduleSlots(): array
    {
        $slots = [];

        for ($hour = 0; $hour < 24; $hour++) {
            foreach ([0, 30] as $minute) {
                $startHour = str_pad((string) $hour, 2, '0', STR_PAD_LEFT);
                $startMinute = str_pad((string) $minute, 2, '0', STR_PAD_LEFT);

                $endMinutes = ($hour * 60) + $minute + 30;
                $endHour = str_pad((string) floor(($endMinutes % 1440) / 60), 2, '0', STR_PAD_LEFT);
                $endMinute = str_pad((string) ($endMinutes % 60), 2, '0', STR_PAD_LEFT);

                $slots[] = [
                    'key' => "{$startHour}{$startMinute}",
                    'label' => "{$startHour}:{$startMinute} - {$endHour}:{$endMinute}",
                ];
            }
        }

        return $slots;
    }

    private function scheduleEntries(): array
    {
        return [
            '0000-mon' => ['type' => 'closed'],
            '0000-tue' => ['type' => 'open'],
            '0030-mon' => ['type' => 'closed'],
            '0030-tue' => ['type' => 'booked', 'student' => 'Alex Thompson', 'category' => 'ADULTS'],
            '0100-tue' => ['type' => 'booked', 'student' => 'Maria Garcia', 'category' => 'KIDS'],
            '0100-wed' => ['type' => 'open'],
            '0130-tue' => ['type' => 'open'],
            '0130-wed' => ['type' => 'open'],
            '0800-fri' => ['type' => 'booked', 'student' => 'Liam O\'Connor', 'category' => 'KIDS'],
            '0830-fri' => ['type' => 'booked', 'student' => 'Liam O\'Connor', 'category' => 'KIDS'],
            '0900-thu' => ['type' => 'open'],
            '0930-thu' => ['type' => 'open'],
            '1000-sat' => ['type' => 'closed'],
            '1030-sat' => ['type' => 'closed'],
            '1400-wed' => ['type' => 'booked', 'student' => 'Sofia Rossi', 'category' => 'KIDS'],
            '1430-wed' => ['type' => 'booked', 'student' => 'Sofia Rossi', 'category' => 'KIDS'],
            '1800-mon' => ['type' => 'open'],
            '1830-mon' => ['type' => 'open'],
        ];
    }

    private function withStudentCategories(array $rows, string $studentKey = 'student'): array
    {
        return array_map(function (array $row) use ($studentKey): array {
            $meta = $this->studentCategoryMeta($row[$studentKey] ?? '');

            return [
                ...$row,
                'category' => $row['category'] ?? $meta['category'],
                'category_class' => $row['category_class'] ?? $meta['class'],
            ];
        }, $rows);
    }

    private function studentCategoryMeta(string $studentName): array
    {
        $kids = [
            'Nguyen Tuan',
            'Sofia Garcia',
            'Maria Garcia',
            'Chloe Dubois',
            'Liam O\'Connor',
            'Sofia Rossi',
            'Mina Park',
            'David Kim',
            'Siti Rahma',
            'Kai Huang',
            'Claire Dubois',
            'Miguel Santos',
            'Pim Chan',
        ];

        $isKids = in_array($studentName, $kids, true);

        return [
            'category' => $isKids ? 'KIDS' : 'ADULTS',
            'class' => $isKids ? 'bg-cyan-50 text-cyan-700 border-cyan-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200',
        ];
    }
}
