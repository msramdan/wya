<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ProfileController,
    RoleAndPermissionController
};

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', fn () => view('dashboard'));
    Route::get('/dashboard', fn () => view('dashboard'));

    Route::get('/profile', ProfileController::class)->name('profile');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);
});


Route::resource('positions', App\Http\Controllers\PositionController::class)->middleware('auth');
Route::resource('departments', App\Http\Controllers\DepartmentController::class)->middleware('auth');
Route::resource('positions', App\Http\Controllers\PositionController::class)->middleware('auth');

Route::resource('setting-apps', App\Http\Controllers\SettingAppController::class)->middleware('auth');
Route::resource('unit-items', App\Http\Controllers\UnitItemController::class)->middleware('auth');
Route::resource('equipment-locations', App\Http\Controllers\EquipmentLocationController::class)->middleware('auth');
Route::resource('equipment-categories', App\Http\Controllers\EquipmentCategoryController::class)->middleware('auth');
Route::resource('provinces', App\Http\Controllers\ProvinceController::class)->middleware('auth');
Route::resource('kabkots', App\Http\Controllers\KabkotController::class)->middleware('auth');
Route::resource('kecamatans', App\Http\Controllers\KecamatanController::class)->middleware('auth');
Route::resource('kelurahans', App\Http\Controllers\KelurahanController::class)->middleware('auth');
Route::resource('employee-types', App\Http\Controllers\EmployeeTypeController::class)->middleware('auth');