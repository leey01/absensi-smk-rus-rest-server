<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiCrudController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;


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




Route::group(['middleware' => ['auth:sanctum']], function () {
//    Get me
    Route::get('/me', [KaryawanController::class, 'me']);

    // Route post
    Route::post('/post', [AbsensiCrudController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);

//    Route Request
    Route::get('/karyawan', [KaryawanController::class, 'index']);

    Route::post('password/reset-password', [KaryawanController::class, 'resetPassword'])->name('passwords.reset');

});
//    Route Absensi
    Route::get('/absensi', [AbsensiCrudController::class, 'listAbsensi']);


//Route Login & Register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/', function () {
   return response()->json([
       'error' => '401',
       'message' => 'authentication required'
   ], 401);
})->name('login');

