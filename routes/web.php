<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
    TelegramBotController,
    WilayahController,
    BackupController,
    EquipmentController,
    HospitalController,
    KalenderWoController
};
use App\Http\Controllers\LandingWeb\LandingWebController;
use App\Http\Controllers\LocalizationController;

Route::controller(TelegramBotController::class)->group(function () {
    Route::get('/updated-activity', 'updatedActivity');
    Route::get('/storeMessage', 'storeMessage');
});

Route::get('/web', function () {
    return redirect()->route('web');
});
Route::get('/', [LandingWebController::class, 'index'])->name('web');

//route switch bahasa
Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');

Route::controller(HospitalController::class)->group(function () {
    Route::post('/hospitalSelectSession', 'hospitalSelectSession')->name('hospitalSelectSession');
});


Route::prefix('panel')->group(function () {
    Route::middleware(['auth', 'web'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/generalReport', [DashboardController::class, 'generalReport'])->name('generalReport');
        Route::get('/getTotalWorkOrder', [DashboardController::class, 'getTotalWorkOrder'])->name('dashboard.work_order');
        Route::get('/getTotalEquipment', [DashboardController::class, 'getTotalEquipment'])->name('dashboard.equipment');
        Route::get('/getTotalEmployee', [DashboardController::class, 'getTotalEmployee'])->name('dashboard.employee');
        Route::get('/getTotalVendor', [DashboardController::class, 'getTotalVendor'])->name('dashboard.vendor');
        Route::get('/getTotalWoByStatus', [DashboardController::class, 'getTotalWoByStatus'])->name('dashboard.woBystatus');
        Route::get('/getTotalWoByCategory', [DashboardController::class, 'getTotalWoByCategory'])->name('dashboard.woBycategory');
        Route::get('/getTotalWoByType', [DashboardController::class, 'getTotalWoByType'])->name('dashboard.woBytype');
        Route::get('/profile', ProfileController::class)->name('profile');
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleAndPermissionController::class);
        Route::get('/dashboard', function () {
            return redirect()->route('dashboard');
        });
        Route::get('kota/{provinsiId}', [WilayahController::class, 'kota'])->name('api.kota');
        Route::get('kecamatan/{kotaId}', [WilayahController::class, 'kecamatan'])->name('api.kecamatan');
        Route::get('kelurahan/{kecamatanId}', [WilayahController::class, 'kelurahan'])->name('api.kelurahan');
        Route::resource('positions', App\Http\Controllers\PositionController::class);
        Route::resource('departments', App\Http\Controllers\DepartmentController::class);
        Route::resource('positions', App\Http\Controllers\PositionController::class);
        Route::resource('setting-apps', App\Http\Controllers\SettingAppController::class);
        Route::resource('unit-items', App\Http\Controllers\UnitItemController::class);
        Route::resource('equipment-locations', App\Http\Controllers\EquipmentLocationController::class);
        Route::resource('equipment-categories', App\Http\Controllers\EquipmentCategoryController::class);
        Route::resource('provinces', App\Http\Controllers\ProvinceController::class);
        Route::resource('kabkots', App\Http\Controllers\KabkotController::class);
        Route::resource('kecamatans', App\Http\Controllers\KecamatanController::class);
        Route::resource('kelurahans', App\Http\Controllers\KelurahanController::class);
        Route::resource('employee-types', App\Http\Controllers\EmployeeTypeController::class);
        Route::resource('employees', App\Http\Controllers\EmployeeController::class);
        Route::get('download-format-employee', [App\Http\Controllers\EmployeeController::class, 'formatImport'])->name('download-format-employee');
        Route::get('export-data-employees', [App\Http\Controllers\EmployeeController::class, 'export'])->name('export-data-employees');
        Route::post('import-employees', [App\Http\Controllers\EmployeeController::class, 'import'])->name('action-import-employees');

        Route::resource('category-vendors', App\Http\Controllers\CategoryVendorController::class);
        Route::resource('vendors', App\Http\Controllers\VendorController::class);
        Route::get('download-format-vendor', [App\Http\Controllers\VendorController::class, 'formatImport'])->name('download-format-vendor');
        Route::get('export-data-vendors', [App\Http\Controllers\VendorController::class, 'export'])->name('export-data-vendors');
        Route::get('/GetFileVendor/{id}', [App\Http\Controllers\VendorController::class, 'GetFileVendor']);
        Route::post('import-vendor', [App\Http\Controllers\VendorController::class, 'import'])->name('action-import-vendor');
        Route::resource('spareparts', App\Http\Controllers\SparepartController::class);
        Route::get('export-data-spareparts', [App\Http\Controllers\SparepartController::class, 'export'])->name('export-data-spareparts');
        Route::get('download-format-sparepart', [App\Http\Controllers\SparepartController::class, 'formatImport'])->name('download-format-sparepart');
        Route::post('import-sparepart', [App\Http\Controllers\SparepartController::class, 'import'])->name('action-import-sparepart');

        Route::post('stok_in', [App\Http\Controllers\SparepartController::class, 'stok_in'])->name('stok_in');
        Route::post('stok_out', [App\Http\Controllers\SparepartController::class, 'stok_out'])->name('stok_out');
        Route::delete('delete_history/{id}', [App\Http\Controllers\SparepartController::class, 'delete_history'])->name('delete_history');
        Route::get('print_qr/{id}', [App\Http\Controllers\SparepartController::class, 'print_qr'])->name('print_qr');
        Route::get('totalAssetPart', [App\Http\Controllers\SparepartController::class, 'totalAssetPart'])->name('totalAssetPart');
        Route::get('print_histori/{id}', [App\Http\Controllers\SparepartController::class, 'print_histori'])->name('print_histori');
        Route::resource('nomenklaturs', App\Http\Controllers\NomenklaturController::class);
        Route::get('export-data-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'export'])->name('export-data-nomenklatur');
        Route::get('download-format-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'formatImport'])->name('download-format-nomenklatur');
        Route::post('import-nomenklatur', [App\Http\Controllers\NomenklaturController::class, 'import'])->name('action-import-nomenklatur');
        Route::resource('equipment', App\Http\Controllers\EquipmentController::class);
        Route::controller(EquipmentController::class)->group(function () {
            Route::get('/arsip-equipment', 'arsip')->name('arsip-equipment.index');
            Route::get('/undo-arsip-equipment/{id}', 'undoArsip')->name('undo-arsip-equipment');
        });
        Route::get('print_qr_equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'print_qr'])->name('print_qr_equipment');
        Route::get('print_history_equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'print_history'])->name('print_history_equipment');
        Route::get('print_penyusutan/{id}', [App\Http\Controllers\EquipmentController::class, 'print_penyusutan'])->name('print_penyusutan');
        Route::get('export-data-equipment', [App\Http\Controllers\EquipmentController::class, 'export'])->name('export-data-equipment');
        Route::get('totalAsset', [App\Http\Controllers\EquipmentController::class, 'totalAsset'])->name('totalAsset');
        Route::get('getDetailEquipment/{id}', [App\Http\Controllers\EquipmentController::class, 'getDetailEquipment'])->name('getDetailEquipment');
        Route::get('download-format-equipment', [App\Http\Controllers\EquipmentController::class, 'formatImport'])->name('download-format-equipment');
        Route::post('import-equipment', [App\Http\Controllers\EquipmentController::class, 'import'])->name('action-import-equipment');
        Route::resource('work-orders', App\Http\Controllers\WorkOrderController::class);
        Route::resource('work-order-approvals', App\Http\Controllers\WorkOrderApprovalController::class);
        Route::resource('work-order-processes', App\Http\Controllers\WorkOrderProcessController::class);
        Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessEdit']);
        Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}/info', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessInfo']);
        Route::get('work-order-processes/{workOrderId}/{workOrderProcessId}/print', [App\Http\Controllers\WorkOrderProcessController::class, 'woProcessPrint']);
        Route::resource('hospitals', App\Http\Controllers\HospitalController::class);
        Route::resource('loans', App\Http\Controllers\LoanController::class);
        Route::get('monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])->name('monitoring');
        Route::controller(ActivityLogController::class)->group(function () {
            Route::get('/activity-log', 'index')->name('activity-log.index');
        });
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/backup/download', [BackupController::class, 'downloadBackup'])->name('backup.download');
        Route::controller(KalenderWoController::class)->group(function () {
            Route::get('/kalender-wo/{tahun}/{jenis}', 'index')->name('kalender-wo.index');
            Route::get('/events', 'getEvents')->name('getEvents');
        });
    });
});
