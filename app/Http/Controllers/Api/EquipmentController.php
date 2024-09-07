<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    public function index(Request $request)
    {
        return response()->json([
            'data' => Equipment::when($request->equipment_location_id, function ($query, $location_id) {
                $query->where('equipment_location_id', $location_id);
            })
                ->where('hospital_id', session('sessionHospital')) // Filter by hospital_id
                ->get(),
        ]);
    }


    public function show(int $id)
    {
        return response()->json([
            'data' => Equipment::with('nomenklatur')
                ->with('equipment_category')
                ->with('vendor')
                ->with('equipment_location')
                ->whereIn('id', [$id])
                ->get()
                ->first()
        ]);
    }

    public function barcode(string $barcode)
    {
        return response()->json([
            'data' => Equipment::with('nomenklatur')
                ->with('equipment_category')
                ->with('vendor')
                ->with('equipment_location')
                ->whereIn('barcode', [$barcode])
                ->get()
                ->first()
        ]);
    }
}
