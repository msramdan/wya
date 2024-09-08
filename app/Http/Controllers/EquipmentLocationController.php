<?php

namespace App\Http\Controllers;

use App\Models\EquipmentLocation;
use App\Http\Requests\{StoreEquipmentLocationRequest, UpdateEquipmentLocationRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lihat lokasi peralatan')->only('index', 'show');
        $this->middleware('permission:buat lokasi peralatan')->only('create', 'store');
        $this->middleware('permission:ubah lokasi peralatan')->only('edit', 'update');
        $this->middleware('permission:hapus lokasi peralatan')->only('destroy');
    }

    /**
     * Menampilkan daftar lokasi peralatan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $equipmentLocations = EquipmentLocation::with('hospital:id,name');
            $equipmentLocations = $equipmentLocations->where('hospital_id', session('sessionHospital'));
            return DataTables::of($equipmentLocations)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('action', 'equipment-locations.include.action')
                ->toJson();
        }

        return view('equipment-locations.index');
    }

    /**
     * Menampilkan form untuk membuat lokasi peralatan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment-locations.create');
    }

    /**
     * Menyimpan lokasi peralatan yang baru dibuat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentLocationRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        EquipmentLocation::create($attr);
        Alert::toast('Lokasi peralatan berhasil dibuat.', 'success');
        return redirect()->route('equipment-locations.index');
    }

    /**
     * Menampilkan detail lokasi peralatan tertentu.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentLocation $equipmentLocation)
    {
        return view('equipment-locations.show', compact('equipmentLocation'));
    }

    /**
     * Menampilkan form untuk mengedit lokasi peralatan.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentLocation $equipmentLocation)
    {
        return view('equipment-locations.edit', compact('equipmentLocation'));
    }

    /**
     * Memperbarui lokasi peralatan yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentLocationRequest $request, EquipmentLocation $equipmentLocation)
    {
        $equipmentLocation->update($request->validated());
        Alert::toast('Lokasi peralatan berhasil diperbarui.', 'success');
        return redirect()->route('equipment-locations.index');
    }

    /**
     * Menghapus lokasi peralatan tertentu.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentLocation $equipmentLocation)
    {
        try {
            $equipmentLocation->delete();
            Alert::toast('Lokasi peralatan berhasil dihapus.', 'success');
            return redirect()->route('equipment-locations.index');
        } catch (\Throwable $th) {
            Alert::toast('Lokasi peralatan tidak dapat dihapus karena terkait dengan tabel lain.', 'error');
            return redirect()->route('equipment-locations.index');
        }
    }

    /**
     * Mengambil daftar lokasi peralatan berdasarkan ID rumah sakit.
     *
     * @param  int  $hospitalId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEquipmentLocation($hospitalId)
    {
        $data = DB::table('equipment_locations')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
