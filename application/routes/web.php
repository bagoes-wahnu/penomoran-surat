<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('pages.grid');
// });
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'index']);

Route::group(['middleware' => ['\App\Http\Middleware\SessionLogin']], function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::get('/data-penomoran', function () {
    return view('pages.grid');
});

Route::get('/report', function () {
    return view('pages.report');
});

Route::get('/perview', function () {
    return view('pages.perview');
});
