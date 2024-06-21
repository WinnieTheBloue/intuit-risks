<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Registration\RegistrationCompanyController;
use App\Http\Controllers\Registration\RegistrationRisksController;
use App\Http\Controllers\CompanyRisksController;
use App\Http\Controllers\CompanyRiskController;
use App\Http\Controllers\EvaluationController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Logged/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/register/company', [RegistrationCompanyController::class, 'display'])->name('register.company');
    Route::post('/register/company', [RegistrationCompanyController::class, 'store'])->name('register.company.store');
    Route::get('/register/risks', [RegistrationRisksController::class, 'display'])->name('register.risks');
    Route::post('/register/risks', [RegistrationRisksController::class, 'store'])->name('register.risks.store');
});

Route::middleware(('auth'))->group(function () {
    Route::get('/risks', [CompanyRisksController::class, 'display'])->name('risks');
    Route::get('/risks/{id}', [CompanyRiskController::class, 'display'])->name('risks.show');
});






Route::get('api/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware('auth')->group(function () {
    Route::post('api/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
});






require __DIR__.'/auth.php';
