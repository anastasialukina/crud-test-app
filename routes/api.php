<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JsonDataController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
    Route::post('logout', 'logout')->name('logout');
    Route::post('refresh', 'refresh')->name('refresh');
    Route::get('user', 'user')->name('user');
});

Route::get('/data/create/', [JsonDataController::class, 'create'])->name('data.create');
Route::match(['get', 'post'], '/data/store', [JsonDataController::class, 'store'])->name('data.store');
Route::get('/data/edit/{id}/', [JsonDataController::class, 'edit'])->name('data.edit');
Route::match(['get', 'post'], '/data/update/{id}', [JsonDataController::class, 'update'])->name('data.update');
Route::delete('/data/delete/{id}', [JsonDataController::class, 'destroy'])->name('data.destroy');

Route::get('/data/index', [JsonDataController::class, 'index'])->name('data.index');
Route::get('/data/{id}/', [JsonDataController::class, 'show'])->name('data.show');

