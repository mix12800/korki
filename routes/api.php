<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('registration', [AuthController::class, 'registration']);
Route::post('auth', [AuthController::class, 'auth']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('course', [CourseController::class, 'index']);
    Route::get('user', [AuthController::class, 'getUser']);

    Route::middleware(['role:user'])
        ->group(function () {
            Route::resource('order', OrderController::class)->except('index', 'update');;
            Route::patch('commentAdd/{order}', [OrderController::class, 'commentAdd']);
            Route::get('myorder', [OrderController::class, 'myorder']);
        });

    Route::middleware(['role:admin'])
        ->group(function () {
            Route::resource('course', CourseController::class)->except('index');
            Route::patch('order/{order}', [OrderController::class, 'update']);
            Route::get('order', [OrderController::class, 'index']);
        });
});
