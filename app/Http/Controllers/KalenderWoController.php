<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KalenderWoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kalender wo view')->only('index', 'show');
    }

    public function index($tahun, $jenis)
    {
        return view('kalender-wo.index', [
            'year' => $tahun,
            'selectedJenis' => $jenis,
        ]);
    }

    public function getEvents(Request $request)
    {
        $type = $request->input('jenis');
        $year = $request->input('year', Carbon::now()->year);
        $startDate = Carbon::create($year, 1, 1)->startOfDay();
        $endDate = Carbon::create($year, 12, 31)->endOfDay();
        $query = DB::table('work_order_processes')
            ->select('work_order_processes.schedule_date as pelaksanaan', 'work_order_processes.status', 'work_orders.*', 'equipment.barcode', 'equipment.manufacturer', 'equipment.serial_number')
            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
            ->join('equipment', 'work_orders.equipment_id', '=', 'equipment.id')
            ->whereBetween('work_order_processes.schedule_date', [$startDate, $endDate])
            ->where('work_orders.status_wo', 'accepted');

        if ($type && $type != 'All') {
            $query->where('work_orders.type_wo', $type);
        }

        if (Auth::user()->roles->first()->hospital_id) {
            $query = $query->where('work_orders.hospital_id', Auth::user()->roles->first()->hospital_id);
        }

        $events = $query->orderBy('work_order_processes.schedule_date', 'ASC')->get();
        $events = $events->map(function ($event) {
            return [
                'title' => $event->wo_number . ' - ' . ($event->type_wo == 'Training' ? 'Training/Uji fungsi' : $event->type_wo) . ' - ' . $event->barcode,
                'wo_number' => $event->wo_number,
                'type_wo' => $event->type_wo == 'Training' ? 'Training/Uji fungsi' : $event->type_wo,
                'barcode' => $event->barcode,
                'manufacturer' => $event->manufacturer,
                'serial_number' => $event->serial_number,
                'pelaksanaan' => $event->pelaksanaan,
                'status' => $event->status,
                'start' => \Carbon\Carbon::parse($event->pelaksanaan)->format('Y-m-d\TH:i:s'),
                'end' => \Carbon\Carbon::parse($event->pelaksanaan)->format('Y-m-d\TH:i:s'),
                'allDay' => true,
            ];
        });

        return response()->json($events);
    }
}
