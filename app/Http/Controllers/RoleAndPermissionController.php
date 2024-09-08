<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\{Role, Permission};
use App\Http\Requests\{StoreRoleRequest, UpdateRoleRequest};
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

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $role = DB::table('roles')
                ->select('roles.*')
                ->where('hospital_id', session('sessionHospital'))
                ->get();
            return DataTables::of($role)
                ->addIndexColumn()
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
        Alert::toast('Peran dan Izin Akses berhasil dibuat.', 'success'); // Mengubah teks alert ke bahasa Indonesia
        return redirect()
            ->route('roles.index');
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        cekAksesRs($role->hospital_id);
        return view('roles.show', compact('role'));
    }

    public function edit(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        cekAksesRs($role->hospital_id);
        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $oldPermissions = $role->permissions->pluck('name')->toArray();
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        $newPermissions = $role->permissions->pluck('name')->toArray();
        if ($oldPermissions !== $newPermissions) {
            activity()
                ->useLog('log_role')
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->withProperties([
                    'old' => ['permissions' => $oldPermissions],
                    'attributes' => ['permissions' => $newPermissions],
                ])
                ->event('updated')
                ->log("Peran dan Izin Akses {$role->name} permissions diperbarui");
        }

        Alert::toast('Peran dan Izin Akses berhasil diperbarui.', 'success'); // Mengubah teks alert ke bahasa Indonesia
        return redirect()->route('roles.index');
    }

    public function destroy(int $id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        // if any user where role.id = $id
        if ($role->users_count < 1) {
            $role->delete();
            Alert::toast('Peran dan Izin Akses berhasil dihapus.', 'success'); // Mengubah teks alert ke bahasa Indonesia
            return redirect()
                ->route('roles.index');
        } else {
            Alert::toast('Tidak dapat menghapus Peran dan Izin Akses karena masih terkait dengan pengguna.', 'error'); // Mengubah teks alert ke bahasa Indonesia
            return redirect()
                ->route('roles.index');
        }

        return redirect()->route('roles.index');
    }
}
