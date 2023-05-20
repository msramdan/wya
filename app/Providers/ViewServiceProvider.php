<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Auth;

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

            if (!Auth::user()->roles->first()->hospital_id) {
                $data = Role::select('id', 'name')->get();
            } else {
                $data = Role::select('id', 'name')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }

            return $view->with(
                'roles',
                $data
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
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->get();
            } else {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'employeeTypes',
                $data
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->get();
            } else {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'departments',
                $data
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->get();
            } else {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'positions',
                $data
            );
        });


        View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\CategoryVendor::select('id', 'name_category_vendors')->get();
            } else {
                $data = \App\Models\CategoryVendor::select('id', 'name_category_vendors')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'categoryVendors',
                $data
            );
        });

        View::composer(['vendors.create', 'vendors.edit'], function ($view) {
            return $view->with(
                'provinces',
                \App\Models\Province::select('id', 'provinsi')->get()
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'nomenklaturs',
                \App\Models\Nomenklatur::select('id', 'name_nomenklatur')->get()
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->get();
            } else {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'equipmentCategories',
                $data
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->get();
            } else {
                $data = \App\Models\EmployeeType::select('id', 'name_employee_type')->where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'vendors',
                $data
            );
        });

        View::composer(['equipments.create', 'equipments.edit'], function ($view) {
            return $view->with(
                'equipmentLocations',
                \App\Models\EquipmentLocation::select('id', 'location_name')->get()
            );
        });


        View::composer(['work-orders.create', 'work-orders.edit'], function ($view) {
            return $view->with(
                'equipments',
                \App\Models\Equipment::select('id', 'barcode')->get()
            );
        });

        View::composer(['work-orders.create', 'work-orders.edit'], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer(['hospitals.create', 'hospitals.edit'], function ($view) {
            if (!Auth::user()->roles->first()->hospital_id) {
                $data = \App\Models\Hospital::select('id', 'work_order_has_access_approval_users_id')->get();
            } else {
                $data = \App\Models\Hospital::select('id', 'work_order_has_access_approval_users_id')->where('id', Auth::user()->roles->first()->hospital_id)->get();
            }
            return $view->with(
                'rs',
                json_encode($data)
            );
        });

        View::composer(
            [
                'unit-items.*',
                'users.*',
                'roles.*',
                'equipment-locations.*',
                'equipment-categories.*',
                'category-vendors.*',
                'vendors.*',
                'employees.*',
                'employee-types.*',
                'positions.*',
                'departments.*',
                'spareparts.*',
                'equipments.*',
                'work-orders.*',
                'work-order-process.*',
                'work-order-approvals.*',
                'hospitals.*',
            ],
            function ($view) {
                return $view->with(
                    'hispotals',
                    \App\Models\Hospital::select('id', 'name')->get()
                );
            }
        );
    }
}
