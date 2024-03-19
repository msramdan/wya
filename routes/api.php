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
Route::get('getCategory/{hospitalId}', [App\Http\Controllers\CategoryVendorController::class, 'getCategory'])->name('api.getCategory');
Route::get('getDepartment/{hospitalId}', [App\Http\Controllers\DepartmentController::class, 'getDepartment'])->name('api.getDepartment');
Route::get('getEmployeeType/{hospitalId}', [App\Http\Controllers\EmployeeTypeController::class, 'getEmployeeType'])->name('api.getEmployeeType');
Route::get('getPosition/{hospitalId}', [App\Http\Controllers\PositionController::class, 'getPosition'])->name('api.getPosition');
Route::get('getVendor/{hospitalId}', [App\Http\Controllers\VendorController::class, 'getVendor'])->name('api.getVendor');
Route::get('getEquipmentCategory/{hospitalId}', [App\Http\Controllers\EquipmentCategoryController::class, 'getEquipmentCategory'])->name('api.getEquipmentCategory');
Route::get('getEquipmentLocation/{hospitalId}', [App\Http\Controllers\EquipmentLocationController::class, 'getEquipmentLocation'])->name('api.getEquipmentLocation');
Route::get('getEquipment/{hospitalId}', [App\Http\Controllers\EquipmentController::class, 'getEquipment'])->name('api.getEquipment');
Route::get('getPic/{hospitalId}', [App\Http\Controllers\EmployeeController::class, 'getPic'])->name('api.getPic');

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
