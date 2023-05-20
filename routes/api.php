<?php

use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\WorkOrderProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getUnit/{hospitalId}', [App\Http\Controllers\UnitItemController::class, 'getUnit'])->name('api.getUnit');

Route::group([
    'as' => 'api.'
], function () {
    Route::group([
        'prefix' => 'equipments',
        'as' => 'equipment.',
    ], function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::get('/{id}', [EquipmentController::class, 'show'])->name('show');
        Route::get('/{barcode}/barcode', [EquipmentController::class, 'barcode'])->name('barcode');
    });

    Route::group([
        'prefix' => 'wo-process',
        'as' => 'wo-process.',
    ], function () {
        Route::get('/{id}/history', [WorkOrderProcessController::class, 'history'])->name('history');
    });
});
