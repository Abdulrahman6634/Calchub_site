<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Calculators\CurrencyController;
use App\Http\Controllers\Calculators\CgpaController;
use App\Http\Controllers\Calculators\PercentageController;
use App\Http\Controllers\Calculators\ProfitLossController;
use App\Http\Controllers\Calculators\CalorieController;
use App\Http\Controllers\Calculators\DateTimeController;
use App\Http\Controllers\Calculators\BmiCalculatorController;
use App\Http\Controllers\Calculators\LoanCalculatorController;

use App\Http\Controllers\Others\YouTubeTagGeneratorController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin.form');
Route::post('/signin', [AuthController::class, 'login'])->name('signin');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::view('/tools', 'home')->name('home');

    Route::get('/currency', [CurrencyController::class, 'index'])->name('currency.converter');
    Route::post('/currency/convert', [CurrencyController::class, 'convert'])->name('currency.convert');
    Route::get('/currency/history', [CurrencyController::class, 'history'])->name('currency.history');
    Route::delete('/currency/{id}', [CurrencyController::class, 'destroy'])->name('currency.destroy');

    Route::get('/cgpa', [CgpaController::class, 'index'])->name('cgpa.calculator');
    Route::post('/cgpa/calculate', [CgpaController::class, 'calculate'])->name('cgpa.calculate');
    Route::get('/cgpa/history', [CgpaController::class, 'history'])->name('cgpa.history');
    Route::delete('/cgpa/{id}', [CgpaController::class, 'destroy'])->name('cgpa.destroy');

    Route::get('/percentage', [PercentageController::class, 'index'])->name('percentage.calculator');
    Route::post('/percentage/calculate', [PercentageController::class, 'calculate'])->name('percentage.calculate');
    Route::get('/percentage/history', [PercentageController::class, 'history'])->name('percentage.history');
    Route::delete('/percentage/{id}', [PercentageController::class, 'destroy'])->name('percentage.destroy');

    Route::get('/profit-loss', [ProfitLossController::class, 'index'])->name('profit-loss.calculator');
    Route::post('/profit-loss/calculate', [ProfitLossController::class, 'calculate'])->name('profit-loss.calculate');
    Route::get('/profit-loss/history', [ProfitLossController::class, 'history'])->name('profit-loss.history');
    Route::delete('/profit-loss/{id}', [ProfitLossController::class, 'destroy'])->name('profit-loss.destroy');

    Route::get('/calorie', [CalorieController::class, 'index'])->name('calorie.calculator');
    Route::post('/calorie/calculate', [CalorieController::class, 'calculate'])->name('calorie.calculate');
    Route::get('/calorie/history', [CalorieController::class, 'history'])->name('calorie.history');
    Route::delete('/calorie/{id}', [CalorieController::class, 'destroy'])->name('calorie.destroy');

    Route::get('/date-time', [DateTimeController::class, 'index'])->name('date-time.calculator');
    Route::post('/date-time/calculate', [DateTimeController::class, 'calculate'])->name('date-time.calculate');
    Route::get('/date-time/history', [DateTimeController::class, 'history'])->name('date-time.history');
    Route::delete('/date-time/{id}', [DateTimeController::class, 'destroy'])->name('date-time.destroy');

    Route::get('/bmi', [BmiCalculatorController::class, 'index'])->name('bmi.calculator');
    Route::post('/bmi/calculate', [BmiCalculatorController::class, 'calculate'])->name('bmi.calculate');
    Route::get('/bmi/history', [BmiCalculatorController::class, 'history'])->name('bmi.history');
    Route::get('/bmi/progress', [BmiCalculatorController::class, 'progress'])->name('bmi.progress');
    Route::delete('/bmi/{id}', [BmiCalculatorController::class, 'destroy'])->name('bmi.destroy');

    Route::get('/loan', [LoanCalculatorController::class, 'index'])->name('loan.calculator');
    Route::post('/calculate', [LoanCalculatorController::class, 'calculate'])->name('loan.calculate');
    Route::post('/calculate-extra-payment', [LoanCalculatorController::class, 'calculateExtraPayment'])->name('loan.calculate.extra');
    Route::get('/history', [LoanCalculatorController::class, 'history'])->name('loan.history');
    Route::delete('/history/{id}', [LoanCalculatorController::class, 'destroy'])->name('loan.destroy');

    Route::get('/youtube-tag-generator', [YouTubeTagGeneratorController::class, 'index'])->name('youtube.tag-generator');
    Route::post('/youtube-tag-generator/generate', [YouTubeTagGeneratorController::class, 'generate'])->name('youtube.tag-generator.generate');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
