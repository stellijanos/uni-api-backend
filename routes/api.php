<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['api.token', CorsMiddleware::class])->group(function() {
    Route::get("/users", [UserController::class, 'getAll']);
    Route::post("/register", [AuthController::class, 'register']);
    Route::post("/login", [AuthController::class, 'login']);
    Route::get("/students", [UserController::class,'getStudents']);
});



// Route::middleware([ CorsMiddleware::class])->group(function() {
//     Route::get("/users", [UserController::class, 'getAll']);
//     Route::post("/register", [AuthController::class, 'register']);
// });


