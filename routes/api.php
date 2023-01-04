<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduledRepaymentController;

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser']);

Route::controller(LoanController::class)->group(function () {
    Route::get('/loan', 'index')->middleware('auth:sanctum');
    Route::post('/loan/create', 'create')->middleware('auth:sanctum');
    Route::post('/loan/approve', 'approve')->middleware('auth:sanctum');
});

Route::controller(ScheduledRepaymentController::class)->group(function () {
    Route::post('/repayment/create', 'create')->middleware('auth:sanctum');
});
