<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Requests\{StorePositionRequest, UpdatePositionRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:position view')->only('index', 'show');
        $this->middleware('permission:position create')->only('create', 'store');
        $this->middleware('permission:position edit')->only('edit', 'update');
        $this->middleware('permission:position delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $positions = Position::with('hospital:id,name');
            $positions = $positions->where('hospital_id', session('sessionHospital'));

            return DataTables::of($positions)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('action', 'positions.include.action')
                ->toJson();
        }

        return view('positions.index');
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(StorePositionRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        Position::create($attr);
        Alert::toast('Jabatan berhasil dibuat.', 'success'); // Mengubah teks alert ke bahasa Indonesia
        return redirect()->route('positions.index');
    }

    public function show(Position $position)
    {
        return view('positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        cekAksesRs($position->hospital_id);
        return view('positions.edit', compact('position'));
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $position->update($request->validated());
        Alert::toast('Jabatan berhasil diperbarui.', 'success'); // Mengubah teks alert ke bahasa Indonesia
        return redirect()->route('positions.index');
    }

    public function destroy(Position $position)
    {
        try {
            $position->delete();
            Alert::toast('Jabatan berhasil dihapus.', 'success'); // Mengubah teks alert ke bahasa Indonesia
            return redirect()->route('positions.index');
        } catch (\Throwable $th) {
            Alert::toast('Jabatan tidak bisa dihapus karena terkait dengan tabel lain.', 'error'); // Mengubah teks alert ke bahasa Indonesia
            return redirect()->route('positions.index');
        }
    }

    public function getPosition($hospitalId)
    {
        $data = DB::table('positions')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
