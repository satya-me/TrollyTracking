<?php

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BacklogController;

use App\Http\Controllers\OpeningController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SummeryController;
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

    Route::get('/user/qr/form', [QRController::class, 'QRGen'])->name('user.qr');
    Route::post('/user/qr/temp', [QRController::class, 'QRTempData'])->name('user.qr.temp');
    Route::get('/user/download-qrcode', [QRController::class, 'downloadQRCode'])->name('user.download-qrcode');
    Route::get('/user/qrcode/report', [QRController::class, 'QRCodeReport'])->name('user.qrcode-report');
    Route::get('/download-qr-code', [QRController::class, 'downloadQRCodeView'])->name('download.qr.code');
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

    Route::get('/admin/qrcode/search', [QRController::class, 'search'])->name('admin.qrcode-search');


    Route::get('/admin/qrcode/download', [ReportController::class, 'QRCodeReportDownload'])->name('download-qr-report');
    Route::get('/admin/qrcode/download/grade', [QRController::class, 'downloadExcel'])->name('download-qr-report-grade');


    Route::get('/download-excel', [QRController::class, 'downloadExcel'])->name('qr.downloadExcel');


    Route::get('/admin/supervisor', [AdminController::class, 'SupervisorView'])->name('admin.supervisor');
    Route::post('/admin/add/supervisor', [AdminController::class, 'AddSupervisor'])->name('admin.add-supervisor');
    //edit section
    Route::get('/admin/edit/supervisor/{id}', [AdminController::class, 'editSupervisor'])->name('admin.edit-supervisor');
    Route::post('/admin/update/supervisor', [AdminController::class, 'updateSupervisor'])->name('admin.update-supervisor');
    //delete
    Route::delete('/admin/delete/supervisor/{id}', [AdminController::class, 'deleteSupervisor'])->name('admin.delete-supervisor');

    Route::get('/admin/productivity', [AdminController::class, 'Productivity'])->name('admin.productivity');
    Route::get('/admin/productivity/download', [AdminController::class, 'productivityReportDownload'])->name('download-productivity-report');
    Route::get('/productivity/report', [AdminController::class, 'productivityReport'])->name('productivity-report');

    Route::get('/search-trolly', [AdminController::class, 'searchTrolly'])->name('search-trolly');


    Route::get('/admin/get-qr-image/{id?}', [QRController::class, 'downloadQRCodeView'])->name('get-qr-image');


    //SettingController
    Route::get('/admin/setting', [SettingController::class, 'view'])->name('admin.setting');
    //grade name
    Route::post('/admin/add_grade', [SettingController::class, 'create_grade'])->name('admin.add_grade');
    Route::get('/admin/edit_grade/{id}', [SettingController::class, 'editGrade'])->name('admin.edit_grade');
    //Route::put('/admin/update_grade/{id}', [SettingController::class, 'updateGrade'])->name('admin.update_grade');
    Route::post('/admin/update_grade', [SettingController::class, 'updateGrade'])->name('admin.update_grade');
    Route::delete('/admin/delete_grade/{id}', [SettingController::class, 'deleteGrade'])->name('admin.delete_grade');
    //origin
    Route::post('/admin/add_origin', [SettingController::class, 'create_origin'])->name('admin.add_origin');
    Route::get('/admin/edit_origin/{id?}', [SettingController::class, 'editorigin'])->name('admin.edit_origin');
    Route::post('/admin/update_origin', [SettingController::class, 'updateorigin'])->name('admin.update_origin');
    Route::delete('/admin/delete_origin/{id}', [SettingController::class, 'deleteorigin'])->name('admin.delete_origin');

    Route::get('/openings', [OpeningController::class, 'index'])->name('openings.index');
    Route::post('/openings', [OpeningController::class, 'store'])->name('openings.store');
    Route::post('/openings/update', [OpeningController::class, 'update'])->name('openings.update');
    Route::delete('/openings/{id}', [OpeningController::class, 'destroy'])->name('openings.destroy');

    Route::get('product_summery', [SummeryController::class, 'summery'])->name('product_summery');
    Route::get('/update-backlog', [BacklogController::class, 'updateBacklog'])->name('update-backlog');
    //Route::get('/calculate-backlogs', [SummeryController::class, 'calculateAndStoreBacklogs'])->name('calculate-backlogs');

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



