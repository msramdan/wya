<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
    TelegramBotController,
    WilayahController,
};
use App\Http\Controllers\LandingWeb\LandingWebController;

Route::controller(TelegramBotController::class)->group(function () {
    Route::get('/updated-activity', 'updatedActivity');
    Route::get('/storeMessage', 'storeMessage');
});

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
    });
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    });

    Route::get('kota/{provinsiId}', [WilayahController::class, 'kota'])->name('api.kota');
    Route::get('kecamatan/{kotaId}', [WilayahController::class, 'kecamatan'])->name('api.kecamatan');
    Route::get('kelurahan/{kecamatanId}', [WilayahController::class, 'kelurahan'])->name('api.kelurahan');
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
    Route::resource('employees', App\Http\Controllers\EmployeeController::class)->middleware('auth');
    Route::get('download-format-employee', [App\Http\Controllers\EmployeeController::class, 'formatImport'])->name('download-format-employee')->middleware('auth');
    Route::get('export-data-employees', [App\Http\Controllers\EmployeeController::class, 'export'])->name('export-data-employees')->middleware('auth');
    Route::post('import-employees', [App\Http\Controllers\EmployeeController::class, 'import'])->name('action-import-employees')->middleware('auth');

    Route::resource('category-vendors', App\Http\Controllers\CategoryVendorController::class)->middleware('auth');
    Route::resource('vendors', App\Http\Controllers\VendorController::class)->middleware('auth');
    Route::get('download-format-vendor', [App\Http\Controllers\VendorController::class, 'formatImport'])->name('download-format-vendor')->middleware('auth');
    Route::get('export-data-vendors', [App\Http\Controllers\VendorController::class, 'export'])->name('export-data-vendors')->middleware('auth');
    Route::get('/GetFileVendor/{id}', [App\Http\Controllers\VendorController::class, 'GetFileVendor'])->middleware('auth');
    Route::post('import-vendor', [App\Http\Controllers\VendorController::class, 'import'])->name('action-import-vendor')->middleware('auth');
    Route::resource('spareparts', App\Http\Controllers\SparepartController::class)->middleware('auth');
    Route::get('export-data-spareparts', [App\Http\Controllers\SparepartController::class, 'export'])->name('export-data-spareparts')->middleware('auth');
    Route::get('download-format-sparepart', [App\Http\Controllers\SparepartController::class, 'formatImport'])->name('download-format-sparepart')->middleware('auth');
    Route::post('import-sparepart', [App\Http\Controllers\SparepartController::class, 'import'])->name('action-import-sparepart')->middleware('auth');

    Route::post('stok_in', [App\Http\Controllers\SparepartController::class, 'stok_in'])->name('stok_in')->middleware('auth');
    Route::post('stok_out', [App\Http\Controllers\SparepartController::class, 'stok_out'])->name('stok_out')->middleware('auth');
    Route::delete('delete_history/{id}', [App\Http\Controllers\SparepartController::class, 'delete_history'])->name('delete_history')->middleware('auth');
    Route::get('print_qr/{id}', [App\Http\Controllers\SparepartController::class, 'print_qr'])->name('print_qr')->middleware('auth');
    Route::get('print_histori/{id}', [App\Http\Controllers\SparepartController::class, 'print_histori'])->name('print_histori')->middleware('auth');
    Route::resource('nomenklaturs', App\Http\Controllers\NomenklaturController::class)->middleware('auth');
    Route::get('export-data-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'export'])->name('export-data-nomenklatur')->middleware('auth');
    Route::get('download-format-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'formatImport'])->name('download-format-nomenklatur')->middleware('auth');
    Route::post('import-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'import'])->name('action-import-nomenklatur')->middleware('auth');
    Route::resource('equipment', App\Http\Controllers\EquipmentController::class)->middleware('auth');
    Route::get('print_qr_equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'print_qr'])->name('print_qr_equipment')->middleware('auth');
    Route::get('export-data-equipment', [App\Http\Controllers\EquipmentController::class, 'export'])->name('export-data-equipment')->middleware('auth');
    Route::get('download-format-equipment', [App\Http\Controllers\EquipmentController::class, 'formatImport'])->name('download-format-equipment')->middleware('auth');
    Route::post('import-equipment', [App\Http\Controllers\EquipmentController::class, 'import'])->name('action-import-equipment')->middleware('auth');
    Route::resource('work-orders', App\Http\Controllers\WorkOrderController::class)->middleware('auth');
    Route::resource('work-order-approvals', App\Http\Controllers\WorkOrderApprovalController::class)->middleware('auth');
    Route::resource('work-order-processes', App\Http\Controllers\WorkOrderProcessController::class)->middleware('auth');
    Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessEdit'])->middleware('auth');
    Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}/info', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessInfo'])->middleware('auth');
    Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}/print', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessPrint'])->middleware('auth');
    Route::resource('hospitals', App\Http\Controllers\HospitalController::class)->middleware('auth');
});
