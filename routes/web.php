<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    AduanController,
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
Route::get('/list', [LandingWebController::class, 'list'])->name('web.list');
Route::get('/aduans/search', [LandingWebController::class, 'search'])->name('aduans.search');
Route::get('/detail/{id}', [LandingWebController::class, 'detail'])->name('web.detail');
Route::get('/form', [LandingWebController::class, 'form'])->name('web.form');
Route::post('/store', [LandingWebController::class, 'store'])->name('web.store');
Route::get('/aduan-private', [LandingWebController::class, 'private'])->name('web.private');
Route::post('/check-aduan', [LandingWebController::class, 'checkAduan'])->name('web.checkAduan');

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
        Route::resource('aduans',AduanController::class)->middleware('auth');
        Route::controller(AduanController::class)->group(function () {
            Route::get('/exportAduan', 'exportAduan')->name('exportAduan');
            Route::put('/aduans/{id}/updateStatus', 'updateStatus')->name('aduans.updateStatus');
        });
    });
});



