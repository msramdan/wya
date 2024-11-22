<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
    BackupController,
    SettingAppController
};
use App\Http\Controllers\LandingWeb\LandingWebController;

Route::get('/web', function () {
    return redirect()->route('web');
});
Route::get('/', [LandingWebController::class, 'index'])->name('web');
Route::prefix('panel')->group(function () {
    Route::middleware(['auth', 'web'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', ProfileController::class)->name('profile');
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleAndPermissionController::class);
        Route::get('/dashboard', function () {
            return redirect()->route('dashboard');
        });
        Route::resource('setting-apps', SettingAppController::class);
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/download', [BackupController::class, 'downloadBackup'])->name('backup.download');
    });
});
