<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\PortalController;

Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/login', [PortalController::class, 'login'])->name('login');
Route::post('/login', [PortalController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

Route::middleware('role:student')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'studentDashboard'])->name('student.dashboard');
});

Route::middleware('role:faculty')->group(function () {
    Route::get('/faculty', [PortalController::class, 'facultyDashboard'])->name('faculty.dashboard');
    Route::view('/faculty/about', 'legacy-page', ['portal' => 'Faculty Portal', 'heading' => 'Faculty portal information', 'description' => 'A focused workspace for teaching responsibilities.'])->name('faculty.about');
    Route::view('/faculty/grades', 'legacy-page', ['portal' => 'Faculty Portal', 'heading' => 'Grade encoding', 'description' => 'Select your assigned subject to begin.'])->name('faculty.grades');
});

Route::middleware('role:administrator')->group(function () {
    Route::get('/administrator', [PortalController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::view('/administrator/statistics', 'legacy-page', ['portal' => 'Administrator Portal', 'heading' => 'Institute statistics', 'description' => 'Select a directory to review records and current status.'])->name('admin.statistics');
    Route::view('/administrator/management', 'legacy-page', ['portal' => 'Administrator Portal', 'heading' => 'Administrator management', 'description' => 'Create, review, and maintain academic records.'])->name('admin.management');
});

Route::middleware('role:student')->group(function () {
    Route::view('/student/records', 'legacy-page', ['portal' => 'Student Portal', 'heading' => 'My records', 'description' => 'Read-only academic information for the current term.'])->name('student.records');
});

Route::middleware('role:faculty,administrator')->group(function () {
    Route::get('/staff', function () {
        return redirect()->route(session()->get('user.role') === 'administrator' ? 'admin.dashboard' : 'faculty.dashboard');
    })->name('staff.portal');
});

Route::view('/about', 'about')->name('about');
Route::view('/features', 'features')->name('features');

// Keep the existing visual assets working while the static files are migrated.
Route::get('/legacy/style.css', function () {
    return Response::file(base_path('style.css'), ['Content-Type' => 'text/css']);
})->name('legacy.style');

Route::get('/legacy/mock-data.js', function () {
    return Response::file(base_path('mock-data.js'), ['Content-Type' => 'application/javascript']);
})->name('legacy.mock-data');

Route::get('/legacy/images/{path}', function (string $path) {
    $file = base_path('images/'.str_replace('..', '', $path));
    abort_unless(is_file($file), 404);
    return Response::file($file);
})->where('path', '.*')->name('legacy.image');
