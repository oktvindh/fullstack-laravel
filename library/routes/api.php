<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\BukuController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AuthController;

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

Route::prefix('v1')->group(function() {
    Route::apiResource("kategori", KategoriController::class);
    Route::apiResource("buku", BukuController::class);
    Route::apiResource("role", RoleController::class);
    Route::prefix('auth')->group(function() {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });
    Route::get('/me', [AuthController::class, 'getUser'])->middleware('auth:api');
});