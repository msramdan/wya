<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreRoleRequest, UpdateRoleRequest};
use Spatie\Permission\Models\{Role, Permission};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class RoleAndPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role & permission view')->only('index', 'show');
        $this->middleware('permission:role & permission create')->only('create', 'store');
        $this->middleware('permission:role & permission edit')->only('edit', 'update');
        $this->middleware('permission:role & permission delete')->only('delete');
    }

    public function index()
    {
        if (request()->ajax()) {
            $users = Role::query();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d/m/Y H:i');
                })
                ->addColumn('action', 'roles.include.action')
                ->toJson();
        }

        return view('roles.index');
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($request->permissions);
        Alert::toast('Pedan dan Izin Akses berhasil dibuat.', 'success');
        return redirect()
            ->route('roles.index');
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('roles.show', compact('role'));
    }

    public function edit(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);
        Alert::toast('Pedan dan Izin Akses berhasil diperbaharui.', 'success');
        return redirect()
            ->route('roles.index');
    }

    public function destroy(int $id)
    {
        $role = Role::withCount('users')->findOrFail($id);
        if ($role->users_count < 1) {
            $role->delete();
            Alert::toast('Pedan dan Izin Akses berhasil dihapus.', 'success');
            return redirect()
                ->route('roles.index');
        } else {
            Alert::toast('Can`t delete role.', 'error');
            return redirect()
                ->route('roles.index');
        }

        return redirect()->route('role.index');
    }
}
