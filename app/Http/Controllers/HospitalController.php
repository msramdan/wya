<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Http\Requests\{StoreHospitalRequest, UpdateHospitalRequest};
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hospital view')->only('index', 'show');
        $this->middleware('permission:hospital create')->only('create', 'store');
        // $this->middleware('permission:hospital edit')->only('edit', 'update');
        $this->middleware('permission:hospital delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $hospitals = Hospital::query();

            return Datatables::of($hospitals)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return str($row->address)->limit(100);
                })
                ->addColumn('work_order_has_access_approval_users_id', function ($row) {
                    return str($row->work_order_has_access_approval_users_id)->limit(100);
                })

                ->addColumn('logo', function ($row) {
                    if ($row->logo == null) {
                        return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                    }
                    return asset('storage/uploads/logos/' . $row->logo);
                })

                ->addColumn('action', 'hospitals.include.action')
                ->toJson();
        }

        return view('hospitals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('hospitals.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHospitalRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['logo'] = $filename;
        }

        $attr['work_order_has_access_approval_users_id'] = json_encode($request->work_order_has_access_approval_users_id);

        Hospital::create($attr);

        return redirect()
            ->route('hospitals.index')
            ->with('success', __('The hospital was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospital $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(Hospital $hospital)
    {
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.hospital_id')
            ->where('roles.hospital_id', $hospital->id)
            ->get();
        return view('hospitals.edit', compact('hospital', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old logo from storage
            if ($hospital->logo != null && file_exists($path . $hospital->logo)) {
                unlink($path . $hospital->logo);
            }

            $attr['logo'] = $filename;
        }
        $attr['work_order_has_access_approval_users_id'] = json_encode($request->work_order_has_access_approval_users_id);

        $hospital->update($attr);
        Alert::toast('The hospital was updated successfully.', 'success');
        if (session('sessionHospital') != null) {
            return redirect()->back();
        } else {
            return redirect()->route('hospitals.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        try {
            $path = storage_path('app/public/uploads/logos/');

            if ($hospital->logo != null && file_exists($path . $hospital->logo)) {
                unlink($path . $hospital->logo);
            }
            $hospital->delete();
            Alert::toast('The hospital was deleted successfully.', 'success');
            return redirect()
                ->route('hospitals.index');
        } catch (\Throwable $th) {
            Alert::toast('The hospital cant be deleted because its related to another table.', 'error');
            return redirect()
                ->route('hospitals.index');
        }
    }

    public function hospitalSelectSession(Request $request)
    {
        // remove session
        session()->forget('sessionHospital');
        // set session baru
        $value = $request->input('selectedValue');
        session(['sessionHospital' => $value]);
        return response()->json([
            'success' => true
        ]);
    }


}
