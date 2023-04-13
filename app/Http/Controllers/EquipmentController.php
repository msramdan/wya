<?php

namespace App\Http\Controllers;

use App\Exports\EquiptmentExport;
use App\Models\Equipment;
use App\Http\Requests\{StoreEquipmentRequest, UpdateEquipmentRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

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
    public function index()
    {
        if (request()->ajax()) {
            $equipments = Equipment::with('nomenklatur:id,name_nomenklatur', 'equipment_category:id,category_name', 'vendor:id,name_vendor', 'equipment_location:id,location_name');

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
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

        return view('equipments.index');
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
                'barcode' => 'required|string|min:1|max:100',
                'nomenklatur_id' => 'required|exists:App\Models\Nomenklatur,id',
                'equipment_category_id' => 'required|exists:App\Models\EquipmentCategory,id',
                'manufacturer' => 'required|string|min:1|max:255',
                'type' => 'required|string|min:1|max:255',
                'serial_number' => 'required|string|min:1|max:255',
                'vendor_id' => 'required|exists:App\Models\Vendor,id',
                'condition' => 'required',
                'risk_level' => 'required',
                'equipment_location_id' => 'required|exists:App\Models\EquipmentLocation,id',
                'financing_code' => 'required|string|min:1|max:255',
                'photo'     => 'required|image|mimes:png,jpg,jpeg',
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
            ]);
            $insertedId = $equipment->id;
            if ($equipment) {
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
            }

            Alert::toast('The equipment was created successfully.', 'success');
            return redirect()->route('equipment.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data failed to save', 'error');
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
        $equipment->load('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location',);
        $file = DB::table('equipment_files')->where('equipment_id', $equipment->id)->get();
        $fittings  = DB::table('equipment_fittings')->where('equipment_id', $equipment->id)->get();
        return view('equipments.edit', compact('equipment', 'file', 'fittings'));
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
                'barcode' => 'required|string|min:1|max:100',
                'nomenklatur_id' => 'required|exists:App\Models\Nomenklatur,id',
                'equipment_category_id' => 'required|exists:App\Models\EquipmentCategory,id',
                'manufacturer' => 'required|string|min:1|max:255',
                'type' => 'required|string|min:1|max:255',
                'serial_number' => 'required|string|min:1|max:255',
                'vendor_id' => 'required|exists:App\Models\Vendor,id',
                'condition' => 'required',
                'risk_level' => 'required',
                'equipment_location_id' => 'required|exists:App\Models\EquipmentLocation,id',
                'financing_code' => 'required|string|min:1|max:255',
                'photo'     => 'image|mimes:png,jpg,jpeg',
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
        ]);

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
}
