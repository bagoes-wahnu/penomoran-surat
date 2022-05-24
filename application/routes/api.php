<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LetterNumberController;
use App\Http\Controllers\Api\MasterKeyController;
use App\Http\Controllers\Api\NumberInUseController;
use App\Http\Controllers\Api\SectorController;
use App\Http\Controllers\Api\ReportController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password',[AuthController::class, 'changePassword']);

    Route::group(['prefix' => 'export-excel'], function () {
        Route::get('/', [ReportController::class, 'exportExcel']);
    });

    Route::group(['prefix' => 'letter-number'], function () {
        Route::get('/', [LetterNumberController::class, 'index']);
        Route::get('/get-last-number', [LetterNumberController::class, 'getLastNumber']);
        Route::post('/', [LetterNumberController::class, 'store']);
        Route::get('/detail-number-use', [LetterNumberController::class, 'showDetailNumber']);
        Route::get('/{letterNumber}', [LetterNumberController::class, 'show']);
        Route::put('/{letterNumber}', [LetterNumberController::class, 'update']);
        Route::patch('/{letterNumber}', [LetterNumberController::class, 'lock']);
        Route::delete('/{letterNumber}', [LetterNumberController::class, 'destroy']);
    });

    Route::group(['prefix' => 'number-in-use'], function () {
        Route::get('/', [NumberInUseController::class, 'index']);
        Route::post('/', [NumberInUseController::class, 'store']);
        Route::get('/{id}', [NumberInUseController::class, 'show']);
        Route::put('/{numberInUse}', [NumberInUseController::class, 'store']);
        Route::delete('/{numberInUse}', [NumberInUseController::class, 'destroy']);
        Route::post('/number-not-use', [NumberInUseController::class, 'useNumber']);
    });

    Route::group(['prefix' => 'master-key'], function () {
        Route::get('/', [MasterKeyController::class, 'index']);
        Route::post('/', [MasterKeyController::class, 'store']);
        Route::get('/{id}', [MasterKeyController::class, 'show']);
        Route::put('/{id}', [MasterKeyController::class, 'store']);
        Route::delete('/{masterKey}', [MasterKeyController::class, 'destroy']);
    });

    Route::group(['prefix' => 'sector-penomoran'], function () {
        Route::get('/', [SectorController::class, 'index']);
        Route::post('/', [SectorController::class, 'store']);
        Route::get('select-list', [SectorController::class, 'selectList']);
        Route::group(['prefix' => '/{sector}'], function () {
            Route::get('/', [SectorController::class, 'show']);
            Route::put('/', [SectorController::class, 'update']);
        });
    });
});


// ! EXTERNAL
Route::group(['prefix' => 'external', 'middleware' => 'masterKey.verify'], function () {
    // number-in-use
    Route::post('/number-in-use', [NumberInUseController::class, 'store']);
    Route::get('/number-in-use/number-existing', [NumberInUseController::class, 'numberExisting']);
    Route::get('/letter-number/date-existing', [LetterNumberController::class, 'getDateExisting']);
    Route::post('/number-in-use/number-existing-by-date', [NumberInUseController::class, 'numberExistingWithDate']);
});

Route::get('bridge/update_bidang_penomoran', [SectorController::class, 'updateSector']);

Route::group(['prefix' => 'sector', 'middleware' => 'masterKey.verify'], function () {
    Route::get('/', [SectorController::class, 'index']);
    Route::post('/', [SectorController::class, 'store']);
    Route::get('/select-list', [SectorController::class, 'selectList']);
    Route::group(['prefix' => '/{sector}'], function () {
        Route::get('/', [SectorController::class, 'show']);
        Route::put('/', [SectorController::class, 'update']);
    });
});
