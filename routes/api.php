<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
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
    Route::post('/post', [AbsensiController::class, 'store']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('password/reset-password', [KaryawanController::class, 'resetPassword'])->name('passwords.reset');
});


//Route Login & Register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/', function () {
   return response()->json([
       'error' => '401',
       'message' => 'authentication required'
   ], 401);
})->name('login');

// Dashboard
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard']);
Route::get('/dashboard/jml-kehadiran', [\App\Http\Controllers\DashboardController::class, 'jmlKehadiran']);

// Kehadiran
Route::get('/kehadiran', [\App\Http\Controllers\KehadiranController::class, 'kehadiran']);
Route::get('/kehadiran/jml-kehadiran', [\App\Http\Controllers\KehadiranController::class, 'jmlKehadiran']);
Route::post('/kehadiran/list-absensi', [\App\Http\Controllers\KehadiranController::class, 'listAbsensi']);
Route::post('/kehadiran/search', [\App\Http\Controllers\KehadiranController::class, 'search']);
Route::get('/kehadiran/detail', [\App\Http\Controllers\KehadiranController::class, 'detail']);


// Karyawan
Route::get('karyawan', [KaryawanController::class, 'karyawan']);
Route::get('karyawan/all-karyawan', [KaryawanController::class, 'karyawan']);
Route::post('karyawan/add-karyawan', [KaryawanController::class, 'create']);
Route::post('karyawan/update-karyawan', [KaryawanController::class, 'update']);
Route::post('karyawan/delete-karyawan', [KaryawanController::class, 'destroy']);
Route::post('karyawan/detail-karyawan', [KaryawanController::class, 'show']);

// Role
Route::get('role/get-roles', [\App\Http\Controllers\RoleController::class, 'index']);
Route::post('role/add-role', [\App\Http\Controllers\RoleController::class, 'create']);
Route::get('role/delete-role', [\App\Http\Controllers\RoleController::class, 'destroy']);
