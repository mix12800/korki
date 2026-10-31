<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('registration', [AuthController::class, 'registration']);
Route::post('auth', [AuthController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('course', CourseController::class);
});
