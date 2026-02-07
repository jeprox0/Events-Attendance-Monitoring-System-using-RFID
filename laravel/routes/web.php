<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExcuseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseYearController;
use App\Http\Controllers\StudentfeesController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\ReportPaymentController;
use App\Http\Controllers\Student_StudentController;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('student', StudentController::class);
Route::get('/student-student', [StudentController::class, 'studentIndex'])->name('student-student.index');
Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.view');

Route::get('/students/{semester_id}', [StudentController::class, 'index'])->name('students.index');
Route::resource('event', EventController::class);
Route::resource('fine', FineController::class);
Route::delete('/fine/{id}/excuse', [FineController::class, 'excuse'])->name('fines.excuse');
Route::post('/fine/excuse', [FineController::class, 'excuseStudent'])->name('fines.excuse');
Route::resource('contributions', ContributionController::class);

Route::resource('payments', PaymentController::class);
Route::get('/payments/balance/{studentId}/{semesterId}', [PaymentController::class, 'getBalance'])->name('payments.balance');
Route::get('payments/receipt/{payment}', [PaymentController::class, 'receipt'])->name('payments.receipt');

Route::resource('excused_students', ExcuseController::class);
Route::resource('courses', CourseYearController::class);
Route::resource('clubs', ClubController::class);
Route::resource('users', UserController::class);
Route::resource('officers', OfficerController::class);
Route::resource('semesters', SemesterController::class);
    
Route::resource('attendance', AttendanceController::class);
Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance'])->name('attendance.record');
Route::get('/attendance/absent', [AttendanceController::class, 'showAbsent'])->name('attendance.absent');
Route::get('/check-student-officer', [AttendanceController::class, 'checkStudentOfficer']);
Route::get('/get-events', [AttendanceController::class, 'getEvents']);

// routes/web.php

Route::get('/contributionsAndPayments', [ReportPaymentController::class, 'showFinancialReport'])->name('contributionsAndPayments');



Route::post('/check-email', [StudentController::class, 'checkEmail'])->name('check.email');
Route::post('/check-rfid', [StudentController::class, 'checkRFID'])->name('check.rfid');
Route::resource('student_student', Student_StudentController::class);

// Admin Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:super-admin,admin']) // SuperAdmin and Admin can access
    ->name('dashboard');

// Student Dashboard Route
Route::get('/student-dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'user']) // Ensure only students can access
    ->name('student-dashboard');



Route::get('/attendance-chart', [ChartController::class, 'index'])->name('attendance_chart');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';



