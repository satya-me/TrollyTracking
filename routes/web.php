<?php

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\ProductivityReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Add this block to log the authenticated user for debugging
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == "Admin") {
            return redirect()->route('admin.home');
        }
        if ($user->role == "Supervisor") {
            return redirect()->route('supervisor.home');
        }
        if ($user->role == "User") {
            return redirect()->route('user.home');
        }
        // Log::debug('Authenticated user: ', [$user->role]);
    } else {
        // Log::debug('No authenticated user');
        return view('Home.index');
    }
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/

// This user can only create QR code.
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/user', [HomeController::class, 'index'])->name('user.home');
    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');

    Route::get('/qr/form', [QRController::class, 'QRGen'])->name('user.qr');
    Route::get('/qrcode/report', [QRController::class, 'QRCodeReport'])->name('user.qrcode-report');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/qr/form', [QRController::class, 'QRGen'])->name('admin.qr');
    Route::post('/admin/qr/temp', [QRController::class, 'QRTempData'])->name('admin.qr.temp');
    Route::get('/admin/download-qrcode', [QRController::class, 'downloadQRCode'])->name('admin.download-qrcode');
    Route::get('/admin/qrcode/report', [QRController::class, 'QRCodeReport'])->name('admin.qrcode-report');
    Route::get('/admin/qrcode/download', [ReportController::class, 'QRCodeReportDownload'])->name('download-qr-report');

    Route::get('/admin/supervisor', [AdminController::class, 'SupervisorView'])->name('admin.supervisor');
    Route::post('/admin/add/supervisor', [AdminController::class, 'AddSupervisor'])->name('admin.add-supervisor');
    //edit section
    Route::get('/admin/edit/supervisor/{id}', [AdminController::class, 'editSupervisor'])->name('admin.edit-supervisor');
    Route::post('/admin/update/supervisor', [AdminController::class, 'updateSupervisor'])->name('admin.update-supervisor');
    //delete
    Route::delete('/admin/delete/supervisor/{id}', [AdminController::class, 'deleteSupervisor'])->name('admin.delete-supervisor');

    Route::get('/admin/productivity', [AdminController::class, 'Productivity'])->name('admin.productivity');
    Route::get('/admin/productivity/download', [AdminController::class, 'productivityReportDownload'])->name('download-productivity-report');

});

Route::middleware(['auth', 'user-access:supervisor'])->group(function () {
    Route::get('/supervisor/scan', [SupervisorController::class, 'ScanQR'])->name('supervisor.scan');
    Route::get('/supervisor/trolly/scan', [ProductivityReportController::class, 'ScanTrollyQR'])->name('supervisor.trollyScan');
    Route::post('/scan-qr', [ProductivityReportController::class, 'store'])->name('scan-qr');
});



Route::middleware(['auth', 'user-access:supervisor'])->group(function () {
    Route::get('/supervisor', [HomeController::class, 'supervisorHome'])->name('supervisor.home');
    Route::get('/supervisor/home', [HomeController::class, 'supervisorHome'])->name('supervisor.home');
});