<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['users.create', 'users.edit'], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });


        View::composer(['kabkots.create', 'kabkots.edit', 'employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'provinces',
                \App\Models\Province::select('id', 'provinsi')->get()
            );
        });

        View::composer(['kecamatans.create', 'kecamatans.edit'], function ($view) {
            return $view->with(
                'kabkots',
                \App\Models\Kabkot::select('id', 'kabupaten_kota')->get()
            );
        });

        View::composer(['kelurahans.create', 'kelurahans.edit'], function ($view) {
            return $view->with(
                'kecamatans',
                \App\Models\Kecamatan::select('id', 'kecamatan')->get()
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'employeeTypes',
                \App\Models\EmployeeType::select('id', 'name_employee_type')->get()
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'departments',
                \App\Models\Department::select('id', 'name_department')->get()
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'positions',
                \App\Models\Position::select('id', 'name_position')->get()
            );
        });


        View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'categoryVendors',
                \App\Models\CategoryVendor::select('id', 'name_category_vendors')->get()
            );
        });

        View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'provinces',
                \App\Models\Province::select('id', 'provinsi')->get()
            );
        });

        View::composer(['spareparts.create', 'spareparts.edit'], function ($view) {
            return $view->with(
                'unitItems',
                \App\Models\UnitItem::select('id', 'code_unit')->get()
            );
        });

        View::composer(['spareparts.create', 'spareparts.edit'], function ($view) {
            return $view->with(
                'unitItems',
                \App\Models\UnitItem::select('id', 'code_unit')->get()
            );
        });


        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'nomenklaturs',
                \App\Models\Nomenklatur::select('id', 'code_nomenklatur')->get()
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'equipmentCategories',
                \App\Models\EquipmentCategory::select('id', 'code_categoty')->get()
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'vendors',
                \App\Models\Vendor::select('id', 'code_vendor')->get()
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'equipmentLocations',
                \App\Models\EquipmentLocation::select('id', 'code_location')->get()
            );
        });
    }
}
