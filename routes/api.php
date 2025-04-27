<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PairController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);  
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::get('/status', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/pairs', [PairController::class, 'index']);
Route::get('/convert', [PairController::class, 'convert']);
Route::get('/currencies', [PairController::class, 'currencies']); 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pairs', [PairController::class, 'store']);
    Route::put('/pairs/{pair}', [PairController::class, 'update']);
    Route::delete('/pairs/{pair}', [PairController::class, 'destroy']);
});