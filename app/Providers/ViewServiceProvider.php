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


		View::composer(['kabkots.create', 'kabkots.edit','employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'provinces',
                \App\Models\Province::select('id', 'provinsi')->get()
            );
        });

		View::composer(['kecamatans.create', 'kecamatans.edit','employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'kabkots',
                \App\Models\Kabkot::select('id', 'kabupaten_kota')->get()
            );
        });

		View::composer(['kelurahans.create', 'kelurahans.edit','employees.create', 'employees.edit'], function ($view) {
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

		View::composer(['employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'kelurahans',
                \App\Models\Kelurahan::select('id', 'kelurahan')->get()
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

		View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'kabkots',
                \App\Models\Kabkot::select('id', 'provinsi_id')->get()
            );
        });

		View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'kecamatans',
                \App\Models\Kecamatan::select('id', 'kabkot_id')->get()
            );
        });

		View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'kelurahans',
                \App\Models\Kelurahan::select('id', 'kecamatan_id')->get()
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

	}
}