<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\SupervisorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/supervisor/dispatch/status', [SupervisorController::class, 'UpdateDispatchStatus'])->name('supervisor.dispatch-status');
Route::post('/supervisor/dispatch/trolly', [SupervisorController::class, 'UpdatetrollyStatus'])->name('supervisor.trolly-status');


Route::get('/cron', [BacklogController::class, 'Cron']);
