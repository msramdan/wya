<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\{Role, Permission};
use App\Http\Requests\{StoreRoleRequest, UpdateRoleRequest};

class RoleAndPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role & permission view')->only('index', 'show');
        $this->middleware('permission:role & permission create')->only('create', 'store');
        $this->middleware('permission:role & permission edit')->only('edit', 'update');
        $this->middleware('permission:role & permission delete')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $role = DB::table('roles')
                ->leftJoin('hospitals', 'roles.hospital_id', '=', 'hospitals.id')
                ->select('roles.*', 'hospitals.name as hospital_name')
                ->get();
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                if ($request->hospital_id == 'mta') {
                    $role = $role->where('hospital_id', '');
                } else {
                    $role = $role->where('hospital_id', $request->hospital_id);
                }
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $role = $role->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            return DataTables::of($role)
                ->addIndexColumn()
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital_name ? $row->hospital_name : 'Role MTA';
                })
                ->addColumn('action', 'roles.include.action')
                ->toJson();
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name, 'hospital_id' => $request->hospital_id]);

        $role->givePermissionTo($request->permissions);

        return redirect()
            ->route('roles.index')
            ->with('success', __('The role was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update(['name' => $request->name, 'hospital_id' => $request->hospital_id]);

        $role->syncPermissions($request->permissions);

        return redirect()
            ->route('roles.index')
            ->with('success', __('The role was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        // if any user where role.id = $id
        if ($role->users_count < 1) {
            $role->delete();

            return redirect()
                ->route('roles.index')
                ->with('success', __('The role was deleted successfully.'));
        } else {
            return redirect()
                ->route('roles.index')
                ->with('error', __('Can`t delete role.'));
        }

        return redirect()->route('role.index');
    }
}
