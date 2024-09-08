<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use App\Http\Requests\{StoreEquipmentCategoryRequest, UpdateEquipmentCategoryRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class EquipmentCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lihat kategori peralatan')->only('index', 'show');
        $this->middleware('permission:tambah kategori peralatan')->only('create', 'store');
        $this->middleware('permission:edit kategori peralatan')->only('edit', 'update');
        $this->middleware('permission:hapus kategori peralatan')->only('destroy');
    }

    /**
     * Tampilkan daftar data.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $kategoriPeralatan = EquipmentCategory::with('hospital:id,name');
            $kategoriPeralatan = $kategoriPeralatan->where('hospital_id', session('sessionHospital'));
            return DataTables::of($kategoriPeralatan)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('action', 'equipment-categories.include.action')
                ->toJson();
        }

        return view('equipment-categories.index');
    }

    /**
     * Tampilkan form untuk membuat data baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment-categories.create');
    }

    /**
     * Simpan data yang baru dibuat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentCategoryRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        EquipmentCategory::create($attr);
        Alert::toast('Kategori peralatan berhasil dibuat.', 'success');
        return redirect()->route('equipment-categories.index');
    }

    /**
     * Tampilkan data yang ditentukan.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentCategory $equipmentCategory)
    {
        return view('equipment-categories.show', compact('equipmentCategory'));
    }

    /**
     * Tampilkan form untuk mengedit data yang ditentukan.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentCategory $equipmentCategory)
    {
        return view('equipment-categories.edit', compact('equipmentCategory'));
    }

    /**
     * Perbarui data yang ditentukan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentCategoryRequest $request, EquipmentCategory $equipmentCategory)
    {
        $equipmentCategory->update($request->validated());
        Alert::toast('Kategori peralatan berhasil diperbarui.', 'success');
        return redirect()->route('equipment-categories.index');
    }

    /**
     * Hapus data yang ditentukan.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentCategory $equipmentCategory)
    {
        try {
            $equipmentCategory->delete();
            Alert::toast('Kategori peralatan berhasil dihapus.', 'success');
            return redirect()->route('equipment-categories.index');
        } catch (\Throwable $th) {
            Alert::toast('Kategori peralatan tidak dapat dihapus karena terkait dengan tabel lain.', 'error');
            return redirect()->route('equipment-categories.index');
        }
    }

    public function getEquipmentCategory($hospitalId)
    {
        $data = DB::table('equipment_categories')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
