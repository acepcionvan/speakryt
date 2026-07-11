<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/website', [HomeController::class, 'websiteHome'])->name('website.home');
Route::get('/homepage', [HomeController::class, 'websiteHome'])->name('website.homepage');
Route::get('/register-student', [HomeController::class, 'studentRegistration'])->name('website.register');
Route::post('/register-student', [HomeController::class, 'studentRegistrationSubmit'])->name('website.register.submit');
Route::get('/registration-pricing', [HomeController::class, 'registrationPricing'])->name('website.registration-pricing');
Route::post('/registration-purchase', [HomeController::class, 'registrationPurchase'])->name('website.registration-purchase');
Route::get('/student/dashboard', [HomeController::class, 'studentDashboard'])->name('student.dashboard');
Route::post('/student/packages/purchase', [HomeController::class, 'studentPackagePurchase'])->name('student.packages.purchase');
Route::get('/student/lessons/{lesson}/pdf', [HomeController::class, 'studentLessonPdf'])->name('student.lessons.pdf');
Route::get('/', [HomeController::class, 'websiteHome'])->name('website.home.root');

Route::middleware('dashboard.admin')->group(function (): void {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/students', [HomeController::class, 'studentsIndex'])->name('students.index');
    Route::get('/schedule-editor', [HomeController::class, 'scheduleEditor'])->name('schedule.index');
    Route::get('/payments-refunds', [HomeController::class, 'paymentsRefunds'])->name('payments.index');
    Route::get('/packages-pricing', [HomeController::class, 'packagesPricing'])->name('packages.index');
    Route::get('/lessons', [HomeController::class, 'lessonsIndex'])->name('lessons.index');
    Route::get('/lessons/cefr', [HomeController::class, 'cefrCurriculum'])->name('lessons.cefr');
    Route::get('/company-documents', [HomeController::class, 'companyDocuments'])->name('documents.index');
    Route::get('/communication', [HomeController::class, 'communication'])->name('communication.index');
    Route::get('/communication/feedback-entry', [HomeController::class, 'feedbackEntry'])->name('communication.feedback-entry');
    Route::get('/message-center', [HomeController::class, 'messageCenter'])->name('message-center.index');
    Route::get('/user-management', [HomeController::class, 'userManagement'])->name('users.index');
    Route::get('/my-profile', [HomeController::class, 'myProfile'])->name('profile.index');
    Route::get('/staff', [HomeController::class, 'staffIndex'])->name('staff.index');
    Route::get('/staff/{staff}/payroll/{payroll}', [HomeController::class, 'showStaffPayroll'])->name('staff.payroll.show');
    Route::get('/staff/{staff}', [HomeController::class, 'showStaff'])->name('staff.show');
    Route::get('/teachers', [HomeController::class, 'teachersIndex'])->name('teachers.index');
    Route::get('/teachers/{teacher}/payroll/{payroll}', [HomeController::class, 'showTeacherPayroll'])->name('teachers.payroll.show');
    Route::get('/teachers/{teacher}', [HomeController::class, 'showTeacher'])->name('teachers.show');
    Route::get('/students/{student}', [HomeController::class, 'showStudent'])->name('students.show');
    Route::post('/generate', [HomeController::class, 'generate'])->name('generate');
});
