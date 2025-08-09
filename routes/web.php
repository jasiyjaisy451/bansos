<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
});

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/scan-register', [AdminController::class, 'scanRegister'])->name('scan-register');
    Route::post('/register-qr', [AdminController::class, 'registerQr'])->name('register-qr');
    
    // Import routes
    Route::get('/import', [ImportController::class, 'showImportForm'])->name('import');
    Route::post('/import', [ImportController::class, 'import'])->name('import.process');
    Route::get('/import/template', [ImportController::class, 'downloadTemplate'])->name('import.template');
    
    // Recipients management
    Route::resource('recipients', RecipientController::class);
    Route::get('/recipients/{recipient}/qr-code', [RecipientController::class, 'generateQrCode'])->name('recipients.qr-code');
    Route::get('/recipients/{recipient}/qr-print', [RecipientController::class, 'printQrCode'])->name('recipients.qr-print');
    Route::get('/scan', [RecipientController::class, 'scanQr'])->name('recipients.scan');
    Route::post('/verify-qr', [RecipientController::class, 'verifyQr'])->name('recipients.verify-qr');
    Route::post('/recipients/{recipient}/distribute', [RecipientController::class, 'distribute'])->name('recipients.distribute');
    Route::get('/recipients/{recipient}/receipt', [RecipientController::class, 'generateReceipt'])->name('recipients.receipt');
    Route::get('/recipients/{recipient}/signature', [RecipientController::class, 'generateSignatureForm'])->name('recipients.signature');
    Route::get('/report', [RecipientController::class, 'generateReport'])->name('recipients.report');
});

// Legacy routes for backward compatibility
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
    
    Route::get('/home', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
