<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//    LoginController Route
Route::controller(LoginController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/logout', 'logOut');
});



//   TaskController Route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('index', [TaskController::class, 'index']);
    Route::post('/task', [TaskController::class, 'store']);
    Route::put('/task-all-update/{id}', [TaskController::class, 'UpdateTask']);
    Route::delete('/task-destroy/{id}', [TaskController::class, 'destroy']);
    Route::get('/task/{value}', [TaskController::class, 'shorting']); // Shorting
});
