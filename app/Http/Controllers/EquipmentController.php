<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Imports\EquipmentImport;
use App\Exports\EquiptmentExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\FormatImport\GenerateEquipmentFormat;
use App\Imports\EquipmentImportMultipleSheet;
use App\Exports\GenerateEquipmentWithMultipleSheet;
use App\Http\Requests\{ImportEquipmentRequest, StoreEquipmentRequest, UpdateEquipmentRequest};
use App\Models\EquipmentCategory;
use App\Models\EquipmentLocation;
use App\Models\Vendor;
use App\Models\Hospital;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:equipment view')->only('index', 'show');
        $this->middleware('permission:equipment create')->only('create', 'store');
        $this->middleware('permission:equipment edit')->only('edit', 'update');
        $this->middleware('permission:equipment delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $equipments = Equipment::with('nomenklatur:id,name_nomenklatur', 'equipment_category:id,category_name', 'vendor:id,name_vendor', 'equipment_location:id,location_name', 'hospital:id,name')->orderBy('equipment.id', 'DESC');
            $equipment_location_id = intval($request->query('equipment_location_id'));
            $equipment_id = intval($request->query('equipment_id'));
            $commisioning = $request->query('commisioning');
            if (isset($equipment_location_id) && !empty($equipment_location_id)) {
                $equipments = $equipments->where('equipment_location_id', $equipment_location_id);
            }

            $equipments = $equipments->where('hospital_id', session('sessionHospital'));

            if (isset($commisioning) && !empty($commisioning)) {
                $equipments = $equipments->where('equipment.is_decommissioning', $commisioning);
            }

            if (isset($equipment_id) && !empty($equipment_id)) {
                $equipments = $equipments->where('equipment.id', $equipment_id);
            }

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('nilai_buku', function ($row) {
                    return rupiah(getNilaiBuku($row->id, $row->nilai_perolehan));
                })
                ->addColumn('nomenklatur', function ($row) {
                    return $row->nomenklatur ? $row->nomenklatur->name_nomenklatur : '';
                })->addColumn('equipment_category', function ($row) {
                    return $row->equipment_category ? $row->equipment_category->category_name : '';
                })->addColumn('vendor', function ($row) {
                    return $row->vendor ? $row->vendor->name_vendor : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->location_name : '';
                })->addColumn('action', 'equipments.include.action')
                ->toJson();
        }
        $equipment_id = $request->id;
        return view('equipments.index', [
            'equipment_id' => $equipment_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'barcode' => 'required|string|min:1|max:100|unique:equipment,barcode',
                'nomenklatur_id' => 'required|exists:App\Models\Nomenklatur,id',
                'equipment_category_id' => 'required|exists:App\Models\EquipmentCategory,id',
                'manufacturer' => 'required|string|min:1|max:255',
                'type' => 'required|string|min:1|max:255',
                'serial_number' => 'required|string|min:1|max:255|unique:equipment,serial_number',
                'vendor_id' => 'required|exists:App\Models\Vendor,id',
                'condition' => 'required',
                'risk_level' => 'required',
                'equipment_location_id' => 'required|exists:App\Models\EquipmentLocation,id',
                'financing_code' => 'required|string|min:1|max:255',
                'photo'     => 'required|image|mimes:png,jpg,jpeg',
                'tgl_pembelian' => 'required',
                'metode' => 'required',
                'nilai_perolehan' => 'required',
                'nilai_residu' => 'required',
                'masa_manfaat' => 'required',
                'hospital_id' => 'required'
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }


        DB::beginTransaction();
        try {
            //upload photo
            $photo = $request->file('photo');
            $photo->storeAs('public/img/equipment', $photo->hashName());
            $equipment = Equipment::create([
                'barcode' => $request->barcode,
                'nomenklatur_id' => $request->nomenklatur_id,
                'equipment_category_id' => $request->equipment_category_id,
                'manufacturer' => $request->manufacturer,
                'type' => $request->type,
                'serial_number' => $request->serial_number,
                'vendor_id' => $request->vendor_id,
                'condition' => $request->condition,
                'risk_level' => $request->risk_level,
                'equipment_location_id' => $request->equipment_location_id,
                'financing_code' => $request->financing_code,
                'photo'     => $photo->hashName(),
                'tgl_pembelian' => $request->tgl_pembelian,
                'metode' => $request->metode,
                'nilai_perolehan' => $request->nilai_perolehan,
                'nilai_residu' => $request->nilai_residu,
                'masa_manfaat' => $request->masa_manfaat,
                'hospital_id' => $request->hospital_id
            ]);
            $insertedId = $equipment->id;
            if ($equipment) {
                // save price resuction
                if ($request->metode == 'Garis Lurus') {
                    $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($request->tgl_pembelian)));
                    $penambahan = '+' . $request->masa_manfaat . ' year';
                    $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($request->tgl_pembelian)));
                    $x = ($request->nilai_perolehan - $request->nilai_residu) / $request->masa_manfaat;
                    $i = 0;

                    while ($tgl_awal <= $end_tgl) {
                        $dataPenyusutan = [
                            'equipment_id' => $insertedId,
                            'periode' => $tgl_awal,
                            'month' => substr($tgl_awal, 0, 7),
                            'total_penyusutan' => round(($i / 12) * $x, 3),
                            'nilai_buku' => $request->nilai_perolehan - round(($i / 12) * $x, 3)
                        ];
                        DB::table('equipment_reduction_price')->insert(
                            $dataPenyusutan
                        );
                        $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                        $i++;
                    }
                } else {
                    $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($request->tgl_pembelian)));
                    $penambahan = '+' . $request->masa_manfaat . ' year';
                    $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($request->tgl_pembelian)));
                    $PersentasePenyusutan = (2 * (100 / $request->masa_manfaat)) / 100; // 0.5
                    $awalPenyusutan = ($PersentasePenyusutan * $request->nilai_perolehan) / 12;
                    $totalPenyusutan = 0;
                    $perolehan = $request->nilai_perolehan;
                    $nilaiBukuSekarang = $perolehan;
                    $i = substr($tgl_awal, 5, 2) - 1;
                    while ($tgl_awal <= $end_tgl) {
                        $dataPenyusutan = [
                            'equipment_id' => $insertedId,
                            'periode' => $tgl_awal,
                            'month' => substr($tgl_awal, 0, 7),
                            'total_penyusutan' => round($totalPenyusutan, 3),
                            'nilai_buku' => round($nilaiBukuSekarang, 3)
                        ];
                        DB::table('equipment_reduction_price')->insert(
                            $dataPenyusutan
                        );

                        $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                        $i++;
                        if ($i > 12) {
                            $awalPenyusutan = ($PersentasePenyusutan * $nilaiBukuSekarang) / 12;
                            $nilaiBukuSekarang = $nilaiBukuSekarang - $awalPenyusutan;
                            $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                            $i = 1;
                        } else {
                            $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                            $nilaiBukuSekarang = $perolehan - $totalPenyusutan;
                        }
                    }
                }

                $files = $request->file('file');
                $name_file = $request->name_file;

                if ($request->hasFile('file')) {
                    foreach ($files as $key => $file) {
                        $name = $file->hashName();
                        $file->storeAs('public/img/file_equipment', $name);
                        $data = [
                            'equipment_id' => $insertedId,
                            'file' => $name,
                            'name_file' => $name_file[$key],
                        ];

                        DB::table('equipment_files')->insert($data);
                    }
                }

                $name_fittings = $request->name_fittings;
                $qty = $request->qty;
                $equipment_fittings = $request->file('equipment_fittings');
                if ($request->hasFile('equipment_fittings')) {
                    foreach ($equipment_fittings as $key => $equipment_fittings) {
                        $equipment_fittings_name = $equipment_fittings->hashName();
                        $equipment_fittings->storeAs('public/img/equipment_fittings', $equipment_fittings_name);
                        $data = [
                            'equipment_id' => $insertedId,
                            'name_fittings' => $name_fittings[$key],
                            'qty' => $qty[$key],
                            'photo' => $equipment_fittings_name,
                        ];
                        DB::table('equipment_fittings')->insert($data);
                    }
                }

                // photo
                $name_photo = $request->name_photo;
                $file_photo = $request->file('file_photo_eq');
                if ($request->hasFile('file_photo_eq')) {
                    foreach ($file_photo as $key => $a) {
                        $file_photo_name = $a->hashName();
                        $a->storeAs('public/img/file_photo', $file_photo_name);
                        $dataPhoto = [
                            'equipment_id' => $insertedId,
                            'name_photo' => $name_photo[$key],
                            'photo' => $file_photo_name,
                        ];
                        DB::table('equipment_photo')->insert($dataPhoto);
                    }
                }
            }

            Alert::toast('The equipment was created successfully.', 'success');
            return redirect()->route('equipment.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data failed to save' . $th->getMessage(), 'error');
            return redirect()->route('equipment.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location',);

        return view('equipments.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        $equipment->load('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location');
        $file = DB::table('equipment_files')->where('equipment_id', $equipment->id)->get();
        $fittings  = DB::table('equipment_fittings')->where('equipment_id', $equipment->id)->get();
        $photo  = DB::table('equipment_photo')->where('equipment_id', $equipment->id)->get();
        $equipmentCategories = EquipmentCategory::where('hospital_id', $equipment->hospital_id)->get();
        $vendors = Vendor::where('hospital_id', $equipment->hospital_id)->get();
        $equipmentLocations = EquipmentLocation::where('hospital_id', $equipment->hospital_id)->get();
        return view('equipments.edit', compact('equipment', 'file', 'fittings', 'photo', 'equipmentCategories', 'vendors', 'equipmentLocations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'barcode' => 'required|string|min:1|max:100|unique:equipment,barcode,' . $equipment->id,
                'nomenklatur_id' => 'required|exists:App\Models\Nomenklatur,id',
                'equipment_category_id' => 'required|exists:App\Models\EquipmentCategory,id',
                'manufacturer' => 'required|string|min:1|max:255',
                'type' => 'required|string|min:1|max:255',
                'serial_number' => 'required|string|min:1|max:255|unique:equipment,serial_number,' . $equipment->id,
                'vendor_id' => 'required|exists:App\Models\Vendor,id',
                'condition' => 'required',
                'risk_level' => 'required',
                'equipment_location_id' => 'required|exists:App\Models\EquipmentLocation,id',
                'financing_code' => 'required|string|min:1|max:255',
                'photo'     => 'image|mimes:png,jpg,jpeg',
                'tgl_pembelian' => 'required',
                'metode' => 'required',
                'nilai_perolehan' => 'required',
                'nilai_residu' => 'required',
                'masa_manfaat' => 'required',
                'hospital_id' => 'required'
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $equipment = Equipment::findOrFail($equipment->id);

        if ($request->file('photo') != null || $request->file('photo') != '') {
            Storage::disk('local')->delete('public/img/equipment/' . $equipment->photo);
            $photo = $request->file('photo');
            $photo->storeAs('public/img/equipment', $photo->hashName());
            $equipment->update([
                'photo'     => $photo->hashName(),
            ]);
        }

        $equipment->update([
            'barcode' => $request->barcode,
            'nomenklatur_id' => $request->nomenklatur_id,
            'equipment_category_id' => $request->equipment_category_id,
            'manufacturer' => $request->manufacturer,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
            'vendor_id' => $request->vendor_id,
            'condition' => $request->condition,
            'risk_level' => $request->risk_level,
            'equipment_location_id' => $request->equipment_location_id,
            'financing_code' => $request->financing_code,
            'tgl_pembelian' => $request->tgl_pembelian,
            'metode' => $request->metode,
            'nilai_perolehan' => $request->nilai_perolehan,
            'nilai_residu' => $request->nilai_residu,
            'masa_manfaat' => $request->masa_manfaat,
            'hospital_id' => $request->hospital_id,
        ]);

        // hapus reduction price lama
        DB::table('equipment_reduction_price')->where('equipment_id', $equipment->id)->delete();

        // insert baru
        if ($request->metode == 'Garis Lurus') {
            $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($request->tgl_pembelian)));
            $penambahan = '+' . $request->masa_manfaat . ' year';
            $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($request->tgl_pembelian)));
            $x = ($request->nilai_perolehan - $request->nilai_residu) / $request->masa_manfaat;
            $i = 0;

            while ($tgl_awal <= $end_tgl) {
                $dataPenyusutan = [
                    'equipment_id' => $equipment->id,
                    'periode' => $tgl_awal,
                    'month' => substr($tgl_awal, 0, 7),
                    'total_penyusutan' => round(($i / 12) * $x,
                        3
                    ),
                    'nilai_buku' => $request->nilai_perolehan - round(($i / 12) * $x, 3)
                ];
                DB::table('equipment_reduction_price')->insert(
                    $dataPenyusutan
                );
                $tgl_awal = date('Y-m-d', strtotime(
                    '+1 month',
                    strtotime($tgl_awal)
                ));
                $i++;
            }
        } else {
            $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($request->tgl_pembelian)));
            $penambahan = '+' . $request->masa_manfaat . ' year';
            $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($request->tgl_pembelian)));
            $PersentasePenyusutan = (2 * (100 / $request->masa_manfaat)) / 100; // 0.5
            $awalPenyusutan = ($PersentasePenyusutan * $request->nilai_perolehan) / 12;
            $totalPenyusutan = 0;
            $perolehan = $request->nilai_perolehan;
            $nilaiBukuSekarang = $perolehan;
            $i = substr($tgl_awal, 5, 2) - 1;
            while ($tgl_awal <= $end_tgl) {
                $dataPenyusutan = [
                    'equipment_id' => $equipment->id,
                    'periode' => $tgl_awal,
                    'month' => substr($tgl_awal, 0, 7),
                    'total_penyusutan' => round($totalPenyusutan, 3),
                    'nilai_buku' => round($nilaiBukuSekarang, 3)
                ];
                DB::table('equipment_reduction_price')->insert(
                    $dataPenyusutan
                );

                $tgl_awal = date('Y-m-d', strtotime(
                    '+1 month',
                    strtotime($tgl_awal)
                ));
                $i++;
                if ($i > 12) {
                    $awalPenyusutan = ($PersentasePenyusutan * $nilaiBukuSekarang) / 12;
                    $nilaiBukuSekarang = $nilaiBukuSekarang - $awalPenyusutan;
                    $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                    $i = 1;
                } else {
                    $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                    $nilaiBukuSekarang = $perolehan - $totalPenyusutan;
                }
            }
        }

        // hapus file
        if ($request->id_asal_file == null) {
            $tidak_terhapus_file = [];
        } else {
            $tidak_terhapus_file = $request->id_asal_file;
        }
        $hapus_file = DB::table('equipment_files')
            ->where('equipment_id', '=', $equipment->id)
            ->whereNotIn('id', $tidak_terhapus_file)
            ->get();
        foreach ($hapus_file as $row) {
            DB::table('equipment_files')->where('id', $row->id)->delete();
            Storage::disk('local')->delete('public/img/file_equipment/' . $row->file);
        }
        // upload file baru
        $files = $request->file('file');
        $name_file = $request->name_file;
        $asal_file = $request->id_asal_file;
        if ($request->hasFile('file')) {
            foreach ($files as $key => $file) {
                // if ($asal_file[$key] == null) {
                $name = $file->hashName();
                $file->storeAs('public/img/file_equipment', $name);
                $data = [
                    'equipment_id' => $equipment->id,
                    'file' => $name,
                    'name_file' => $name_file[$key],
                ];
                DB::table('equipment_files')->insert($data);
                // }
            }
        }

        // hapus fitting
        if ($request->id_asal_fittings == null) {
            $tidak_terhapus_fittings = [];
        } else {
            $tidak_terhapus_fittings = $request->id_asal_fittings;
        }
        $hapus_equipment_fittings = DB::table('equipment_fittings')
            ->where('equipment_id', '=', $equipment->id)
            ->whereNotIn('id', $tidak_terhapus_fittings)
            ->get();
        foreach ($hapus_equipment_fittings as $row) {
            DB::table('equipment_fittings')->where('id', $row->id)->delete();
            Storage::disk('local')->delete('public/img/equipment_fittings/' . $row->photo);
        }

        // upload fitting baru
        $name_fittings = $request->name_fittings;
        $qty = $request->qty;
        $equipment_fittings = $request->file('equipment_fittings');
        $asal_fittings = $request->id_asal_fittings;
        if ($name_fittings != null) {
            foreach ($name_fittings as $key => $value) {
                if ($asal_fittings[$key] != null) {
                    $cek = DB::table('equipment_fittings')
                        ->where('id', '=', $asal_fittings[$key])
                        ->first();
                    if ($cek) {
                        DB::table('equipment_fittings')
                            ->where('id', $cek->id)
                            ->update([
                                'name_fittings' => $name_fittings[$key],
                                'qty' => $qty[$key],
                            ]);
                    }
                } else {
                    $equipment_fittings[$key]->storeAs('public/img/equipment_fittings', $equipment_fittings[$key]->hashName());
                    $data_fittings = [
                        'equipment_id' => $equipment->id,
                        'name_fittings' => $name_fittings[$key],
                        'qty' => $qty[$key],
                        'photo' => $equipment_fittings[$key]->hashName(),
                    ];
                    DB::table('equipment_fittings')->insert($data_fittings);
                }
            }
        }

        // hapus photo
        if ($request->id_asal_photo == null) {
            $tidak_terhapus_fittings = [];
        } else {
            $tidak_terhapus_fittings = $request->id_asal_photo;
        }
        $hapus_equipment_photo = DB::table('equipment_photo')
            ->where('equipment_id', '=', $equipment->id)
            ->whereNotIn('id', $tidak_terhapus_fittings)
            ->get();
        foreach ($hapus_equipment_photo as $row) {
            DB::table('equipment_photo')->where('id', $row->id)->delete();
            Storage::disk('local')->delete('public/img/file_photo/' . $row->photo);
        }
        // upload photo baru
        $name_photo = $request->name_photo;
        $file_photo = $request->file('file_photo_eq');
        if ($request->hasFile('file_photo_eq')) {
            foreach ($file_photo as $key => $a) {
                $file_photo_name = $a->hashName();
                $a->storeAs('public/img/file_photo', $file_photo_name);
                $dataPhoto = [
                    'equipment_id' => $equipment->id,
                    'name_photo' => $name_photo[$key],
                    'photo' => $file_photo_name,
                ];
                DB::table('equipment_photo')->insert($dataPhoto);
            }
        }


        Alert::toast('The equipment was updated successfully.', 'success');
        return redirect()
            ->route('equipment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        try {
            // hapus equipment_fittings
            $equipment_fittings = DB::table('equipment_fittings')
                ->where('equipment_id', '=', $equipment->id)
                ->get();
            foreach ($equipment_fittings as $value) {
                Storage::disk('local')->delete('public/img/equipment_fittings/' . $value->photo);
                DB::table('equipment_fittings')->where('id', '=', $value->id)->delete();
            }

            // hapus equipment_files
            $equipment_files = DB::table('equipment_files')
                ->where('equipment_id', '=', $equipment->id)
                ->get();
            foreach ($equipment_files as $value) {
                Storage::disk('local')->delete('public/img/file_equipment/' . $value->file);
                DB::table('equipment_files')->where('id', '=', $value->id)->delete();
            }
            // hapus equipment_photo
            $equipment_photo = DB::table('equipment_photo')
                ->where('equipment_id', '=', $equipment->id)
                ->get();
            foreach ($equipment_photo as $value) {
                Storage::disk('local')->delete('public/img/file_photo/' . $value->photo);
                DB::table('equipment_photo')->where('id', '=', $value->id)->delete();
            }

            Storage::disk('local')->delete('public/img/equipment/' . $equipment->photo);
            $equipment->delete();
            Alert::toast('The equipment was deleted successfully.', 'success');
            return redirect()->route('equipment.index');
        } catch (\Throwable $th) {
            Alert::toast('The equipment cant be deleted because its related to another table.', 'error');
            return redirect()->route('equipment.index');
        }
    }


    public function export()
    {
        $date = date('d-m-Y');
        $nameFile = 'Daftar-Equipment' . $date;
        return Excel::download(new EquiptmentExport(), $nameFile . '.xlsx');
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_equipment' . $date;
        return Excel::download(new GenerateEquipmentWithMultipleSheet(), $nameFile . '.xlsx');
    }

    public function import(ImportEquipmentRequest $request)
    {
        Excel::import(new EquipmentImportMultipleSheet, $request->file('import_equipment'));

        Alert::toast('Equipment has been successfully imported.', 'success');
        return back();
    }

    public function print_qr(Request $request, $id)
    {
        $equipment = DB::table('equipment')
            ->join('equipment_locations', 'equipment.equipment_location_id', '=', 'equipment_locations.id')
            ->select('equipment.*', 'equipment_locations.location_name')
            ->where('equipment.id', '=', $id)
            ->first();
        $settQR = Hospital::findOrFail($equipment->hospital_id);
        if ($settQR->paper_qr_code == '68.0315') {
            $widthQR = 80;
            $hightPaper = 115;
        } else {
            $widthQR = 114;
            $hightPaper = 147;
        }
        $pdf = PDF::loadview('equipments.qr', [
            'barcode' => $equipment->barcode,
            'equipment' => $equipment,
            'widthQR' => $widthQR
        ])
            ->setPaper([0, 0, $hightPaper, $settQR->paper_qr_code], 'landscape');
        return $pdf->stream();
        // return $pdf->download('qr.pdf');
    }
    public function print_history($id)
    {
        $equipment = Equipment::with('equipment_location:id,location_name', 'equipment_category:id,category_name')->findOrFail($id);
        $hospital = Hospital::find($equipment->hospital_id);
        $photo  = DB::table('equipment_photo')->where('equipment_id', $id)->get();
        $pdf = PDF::loadview('equipments.history_print', [
            'equipment' => $equipment,
            'hospital' => $hospital,
            'photo' => $photo,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function print_penyusutan($id)
    {
        $equipment = Equipment::with('equipment_location:id,location_name', 'equipment_category:id,category_name')->findOrFail($id);
        $hospital = Hospital::find($equipment->hospital_id);
        $pdf = PDF::loadview('equipments.print_penyusutan', [
            'equipment' => $equipment,
            'hospital' => $hospital,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function totalAsset(Request $request)
    {
        $month = date('Y-m');
        $location = $request->equipment_location_id;
        $isDecommissioning = $request->commisioning;
        if (Auth::user()->roles->first()->hospital_id == null) {
            $id = $request->id;
            if ($id != null && $location == null || $id != '' && $location == null) {
                $query = "SELECT SUM(nilai_buku) AS total FROM equipment_reduction_price
                join equipment on equipment_reduction_price.equipment_id = equipment.id
                WHERE equipment.hospital_id='$id' and month='$month'";

                if ($isDecommissioning !== null) {
                    $query .= " and equipment.is_decommissioning='$isDecommissioning'";
                }
            } else if ($id != null && $location != null || $id != '' && $location != null) {
                $query = "SELECT SUM(nilai_buku) AS total FROM equipment_reduction_price
                join equipment on equipment_reduction_price.equipment_id = equipment.id
                WHERE equipment.hospital_id='$id' and month='$month' and equipment.equipment_location_id='$location'";

                if ($isDecommissioning !== null) {
                    $query .= " and equipment.is_decommissioning='$isDecommissioning'";
                }
            } else {
                $query = "SELECT SUM(nilai_buku) AS total FROM equipment_reduction_price
                join equipment on equipment_reduction_price.equipment_id = equipment.id
                WHERE month='$month'";

                if ($isDecommissioning !== null) {
                    $query .= " and equipment.is_decommissioning='$isDecommissioning'";
                }
            }
        } else {
            $id = Auth::user()->roles->first()->hospital_id;
            if ($location != null) {
                $query = "SELECT SUM(nilai_buku) AS total FROM equipment_reduction_price
                join equipment on equipment_reduction_price.equipment_id = equipment.id
                WHERE equipment.hospital_id='$id' and month='$month' and equipment.equipment_location_id='$location'";

                if ($isDecommissioning !== null) {
                    $query .= " and equipment.is_decommissioning='$isDecommissioning'";
                }
            } else {
                $query = "SELECT SUM(nilai_buku) AS total FROM equipment_reduction_price
                join equipment on equipment_reduction_price.equipment_id = equipment.id
                WHERE equipment.hospital_id='$id' and month='$month'";

                if ($isDecommissioning !== null) {
                    $query .= " and equipment.is_decommissioning='$isDecommissioning'";
                }
            }
        }

        $data = DB::select($query);
        if ($data[0]->total != null) {
            return rupiah($data[0]->total);
        } else {
            return rupiah(0);
        }
    }

    public function getDetailEquipment($barcode)
    {
        $data = Equipment::with('nomenklatur:id,name_nomenklatur', 'equipment_category:id,category_name', 'vendor:id,name_vendor', 'equipment_location:id,location_name')->where('barcode', $barcode)->first();
        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function getEquipment($locationId)
    {
        $data = DB::table('equipment')->where('equipment_location_id', $locationId)->get();
        return response()->json(compact('data'));
    }

    public function getEquipmentByBarcode($barcode)
    {
        $equipment = Equipment::where('barcode', $barcode)->first();

        if ($equipment) {
            return response()->json([
                'barcode' => $equipment->barcode,
                'nomenklatur_id' => $equipment->nomenklatur_id,
                'equipment_category_id' => $equipment->equipment_category_id,
                'manufacturer' => $equipment->manufacturer,
                'type' => $equipment->type,
                'serial_number' => $equipment->serial_number,
                'vendor_id' => $equipment->vendor_id,
                'condition' => $equipment->condition,
                'risk_level' => $equipment->risk_level,
                'equipment_location_id' => $equipment->equipment_location_id,
                'financing_code' => $equipment->financing_code,
                'photo' => $equipment->photo,
                'tgl_pembelian' => $equipment->tgl_pembelian,
                'metode' => $equipment->metode,
                'nilai_perolehan' => $equipment->nilai_perolehan,
                'nilai_residu' => $equipment->nilai_residu,
                'masa_manfaat' => $equipment->masa_manfaat,
                'hospital_id' => $equipment->hospital_id,
            ]);
        } else {
            return response()->json(['message' => 'Equipment not found'], 404);
        }
    }
}
