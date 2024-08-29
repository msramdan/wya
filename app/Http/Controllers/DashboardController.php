<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\Hospital;
use App\Models\Equipment;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd(session('sessionHospital'));
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));
        $hospitals = Hospital::all();
        $hospital_id = intval($request->query('hospital_id'));
        $sessionId = session('sessionHospital');
        if ($sessionId == null) {
            if (isset($hospital_id) && !empty($hospital_id)) {
                $ids = $hospital_id;
            } else {
                $ids = Hospital::first()->id;
            }
        } else {
            $ids = session('sessionHospital');
        }
        $countVendor = Vendor::where('hospital_id', $ids)->count();
        $countEmployee = Employee::where('hospital_id', $ids)->count();
        $countEquipment = Equipment::where('hospital_id', $ids)->count();
        $countWorkOrder = WorkOrder::where('hospital_id', $ids);
        $vendor = Vendor::where('hospital_id', $ids)->get();
        $employees = Employee::where('hospital_id', $ids)->get();
        $in = DB::table('sparepart_trace')
            ->join('spareparts', 'sparepart_trace.sparepart_id', '=', 'spareparts.id')
            ->select('sparepart_trace.*', 'spareparts.hospital_id')
            ->where('hospital_id', $ids)
            ->where('type', '=', 'In')
            ->limit(10);
        $out = DB::table('sparepart_trace')
            ->join('spareparts', 'sparepart_trace.sparepart_id', '=', 'spareparts.id')
            ->select('sparepart_trace.*', 'spareparts.hospital_id')
            ->where('hospital_id', $ids)
            ->where('type', '=', 'Out')
            ->limit(10);
        if (isset($start_date) && !empty($start_date)) {
            $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
            $microFrom = $start_date;
            $in = $in->where('sparepart_trace.created_at', '>=', $from);
            $out = $out->where('sparepart_trace.created_at', '>=', $from);
            $countWorkOrder = $countWorkOrder->where('filed_date', '>=', $from);
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $microFrom = strtotime($from) * 1000;
            $in = $in->where('sparepart_trace.created_at', '>=', $from);
            $out = $out->where('sparepart_trace.created_at', '>=', $from);
            $countWorkOrder = $countWorkOrder->where('filed_date', '>=', $from);
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
            $microTo = $end_date;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
            $countWorkOrder = $countWorkOrder->where('filed_date', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $microTo = strtotime($to) * 1000;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
            $countWorkOrder = $countWorkOrder->where('filed_date', '<=', $to);
        }
        $sql = "SELECT * FROM `spareparts` WHERE hospital_id='$ids' and stock < opname limit 10";
        $countWorkOrder = $countWorkOrder->count();
        return view('dashboard', [
            'vendor' => $vendor,
            'employees' => $employees,
            'microFrom' => $microFrom,
            'microTo' => $microTo,
            'in' => $in->orderBy('id', 'desc')->get(),
            'out' => $out->orderBy('id', 'desc')->get(),
            'dataOpname' => DB::select($sql),
            'hispotals' => $hospitals,
            'ids' => $ids,
            'countVendor' => $countVendor,
            'countEmployee' => $countEmployee,
            'countEquipment' => $countEquipment,
            'countWorkOrder' => $countWorkOrder
        ]);
    }
    public function getTotalWorkOrder(Request $request)
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name', 'hospital:id,name')->orderBy('work_orders.id', 'DESC');
            $type_wo = $request->query('type_wo');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $workOrders = $workOrders->where('hospital_id', $request->hospital_id);
            } else {
                $hospital = Hospital::first();
                $workOrders = $workOrders->where('hospital_id', $hospital->id);
            }
            if (session('sessionHospital')) {
                $workOrders = $workOrders->where('hospital_id', session('sessionHospital'));
            }

            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });
                })
                ->make(true);
        }
    }
    public function getTotalEquipment(Request $request)
    {
        if (request()->ajax()) {
            $equipments = Equipment::with('nomenklatur:id,name_nomenklatur', 'equipment_category:id,category_name', 'vendor:id,name_vendor', 'equipment_location:id,location_name', 'hospital:id,name')->orderBy('equipment.id', 'DESC');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $equipments = $equipments->where('hospital_id', $request->hospital_id);
            }
            if (session('sessionHospital')) {
                $equipments = $equipments->where('hospital_id', session('sessionHospital'));
            }

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('nomenklatur', function ($row) {
                    return $row->nomenklatur ? $row->nomenklatur->name_nomenklatur : '';
                })->addColumn('equipment_category', function ($row) {
                    return $row->equipment_category ? $row->equipment_category->category_name : '';
                })->addColumn('vendor', function ($row) {
                    return $row->vendor ? $row->vendor->name_vendor : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->location_name : '';
                })
                ->make(true);
        }
    }
    public function getTotalEmployee(Request $request)
    {
        if (request()->ajax()) {
            $employees = Employee::with('employee_type:id,name_employee_type', 'department:id,name_department', 'position:id,name_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $employees = $employees->where('hospital_id', $request->hospital_id);
            }

            if (session('sessionHospital')) {
                $employees = $employees->where('hospital_id', session('sessionHospital'));
            }

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return str($row->address)->limit(100);
                })
                ->addColumn('employee_status', function ($row) {
                    if ($row->employee_status) {
                        return 'Aktif';
                    } else {
                        return 'Non Aktif';
                    }
                })
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('employee_type', function ($row) {
                    return $row->employee_type ? $row->employee_type->name_employee_type : '';
                })->addColumn('department', function ($row) {
                    return $row->department ? $row->department->name_department : '';
                })->addColumn('position', function ($row) {
                    return $row->position ? $row->position->name_position : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })
                ->make(true);
        }
    }
    public function getTotalVendor(Request $request)
    {
        if (request()->ajax()) {
            $vendors = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $vendors = $vendors->where('hospital_id', $request->hospital_id);
            }
            if (session('sessionHospital')) {
                $vendors = $vendors->where('hospital_id', session('sessionHospital'));
            }
            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('category_vendor', function ($row) {
                    return $row->category_vendor ? $row->category_vendor->name_category_vendors : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })
                ->toJson();
        }
    }
    public function getTotalWoByStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByStatusDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });
                })
                ->make(true);
        }
    }
    public function getTotalWoByCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByCategoryDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return view('work-orders.include.action', ['model' => $row, 'displayAction' => $displayAction, 'arrApprovalUsers' => $arrApprovalUsers]);
                })
                ->make(true);
        }
    }
    public function getTotalWoByType(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByTypeDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return view('work-orders.include.action', ['model' => $row, 'displayAction' => $displayAction, 'arrApprovalUsers' => $arrApprovalUsers]);
                })
                ->make(true);
        }
    }

    public function generalReport(Request $request)
    {
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));

        if (isset($start_date) && !empty($start_date)) {
            $from = date("Y-m-d", substr($request->query('start_date'), 0, 10));
            $carbonFromDate = Carbon::parse($from);
            $dateFromIndonesia = $carbonFromDate->isoFormat('D MMMM YYYY');
        } else {
            $from = date('Y-m-d');
            $carbonFromDate = Carbon::parse($from);
            $dateFromIndonesia = $carbonFromDate->isoFormat('D MMMM YYYY');
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d", substr($request->query('end_date'), 0, 10));
            $carbonToDate = Carbon::parse($to);
            $dateToIndonesia = $carbonToDate->isoFormat('D MMMM YYYY');
        } else {
            $to = date('Y-m-d');
            $carbonToDate = Carbon::parse($to);
            $dateToIndonesia = $carbonToDate->isoFormat('D MMMM YYYY');
        }
        $get_hospital_id = session('sessionHospital');
        $penyaji = '';
        if ($get_hospital_id == null) {
            $hospital = Hospital::firstWhere('id', $request->hospital_id);
            $penyaji = $hospital->name;
            $hospital_id  = $request->hospital_id;
        } else {
            $hospital = Hospital::firstWhere('id', session('sessionHospital'));
            $penyaji = $hospital->name;
            $hospital_id  = session('sessionHospital');
        }

        // Bab 1
        $array = DB::table('work_order_processes')
            ->select('work_order_processes.schedule_date', 'work_order_processes.status', 'work_orders.type_wo')
            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
            ->where('work_orders.hospital_id', $hospital_id)
            ->whereBetween('work_order_processes.schedule_date', [$from, $to])
            ->get()
            ->toArray();
        // Bab 1
        // Inspection and Preventive Maintenance
        $countIpm = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Inspection and Preventive Maintenance';
        }));
        $countIpmFinished = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Inspection and Preventive Maintenance' && $item->status === 'finished';
        }));
        $persentaseIpm = ($countIpm != 0) ? ($countIpmFinished / $countIpm) * 100 : 0;

        // Service
        $countService = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Service';
        }));
        $countServiceFinished = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Service' && $item->status === 'finished';
        }));
        $persentaseService = ($countService != 0) ? ($countServiceFinished / $countService) * 100 : 0;

        // Kalibrasi
        $countCalibration = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Calibration';
        }));
        $countCalibrationFinished = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Calibration' && $item->status === 'finished';
        }));
        $persentaseCalibration = ($countCalibration != 0) ? ($countCalibrationFinished / $countCalibration) * 100 : 0;

        // Traning
        $countTraining = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Training';
        }));
        $countTrainingFinished = count(array_filter($array, function ($item) {
            return $item->type_wo === 'Training' && $item->status === 'finished';
        }));
        $persentaseTraining = ($countTraining != 0) ? ($countTrainingFinished / $countTraining) * 100 : 0;

        // 2.2 MANAJEMEN INVENTORY
        $arryInventory = DB::table('equipment')
            ->select('equipment.barcode', 'equipment_categories.category_name')
            ->join('equipment_categories', 'equipment.equipment_category_id', '=', 'equipment_categories.id')
            ->where('equipment.hospital_id', $hospital_id)
            ->get()
            ->toArray();
        $totalAsset = count($arryInventory);

        // Inisialisasi array untuk menyimpan hasil penghitungan
        $countByCategory = [];

        // Hitung jumlah data dalam setiap grup
        foreach ($arryInventory as $item) {
            $categoryName = $item->category_name;
            if (isset($countByCategory[$categoryName])) {
                $countByCategory[$categoryName]++;
            } else {
                $countByCategory[$categoryName] = 1;
            }
        }
        $currentMonth = date('Y-m');
        $totalNilaiBukuByCategory = DB::table('equipment_reduction_price')
                ->join('equipment', 'equipment_reduction_price.equipment_id', '=', 'equipment.id')
                ->join('equipment_categories', 'equipment.equipment_category_id', '=', 'equipment_categories.id')
                ->where('equipment.hospital_id', '=', $hospital_id)
                ->where('equipment_reduction_price.month', $currentMonth)
                ->groupBy('equipment.equipment_category_id')
                ->select('equipment.equipment_category_id', 'equipment_categories.category_name', DB::raw('SUM(equipment_reduction_price.nilai_buku) as total_nilai_buku'))
                ->get();


        // 2.3      MANAJEMEN PERALATAN DAN SPAREPART
        // total asset spare part
        $totalSparePart =  "SELECT SUM(estimated_price * stock) AS total FROM spareparts WHERE hospital_id='$hospital_id'";
        $data = DB::select($totalSparePart);
        if ($data[0]->total != null) {
            $totalSparePart =  rupiah($data[0]->total);
        } else {
            $totalSparePart =  rupiah(0);
        }

        // Total asset bulan berjalan
        $totalNilaiBuku = DB::table('equipment_reduction_price')
                    ->join('equipment', 'equipment_reduction_price.equipment_id', '=', 'equipment.id')
                    ->where('equipment.hospital_id', '=', $hospital_id)
                    ->where('equipment_reduction_price.month', $currentMonth)
                    ->sum('equipment_reduction_price.nilai_buku');
        // Bab 3 kesimpulan
        $totalBiaya = Expense('Service', $start_date, $end_date, $hospital_id) + Expense('Calibration', $start_date, $end_date, $hospital_id) + Expense('Replacement', $start_date, $end_date, $hospital_id);
        $hitungPersentase = ($totalBiaya / $totalNilaiBuku) * 100;


        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'calibri', 'size' => 12)
        );
        $styleFont2 = array('bold' => true, 'size' => 12, 'name' => 'Calibri');
        $phpWord->addTitleStyle(null, array('size' => 20, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(1, array('size' => 24, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(2, array('size' => 18, 'color' => '000'), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(3, array('size' => 14, 'italic' => true));
        $phpWord->addTitleStyle(4, array('size' => 12, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));

        $multilevelNumberingStyleName = 'multilevel';
        $phpWord->addNumberingStyle(
            $multilevelNumberingStyleName,
            array(
                'type'   => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360, 'bold' => true),
                    array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720, 'bold' => true),
                    array('format' => 'decimal', 'text' => '%3.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 1080, 'bold' => true),
                    array('format' => 'bullet', 'text' => '%4.', 'left' => 1280, 'hanging' => 360, 'tabPos' => 1280, 'bold' => true),
                ),
            )
        );

        // Add first page
        $section = $phpWord->addSection();
        $section->addTitle('General Report', 0);
        $section->addTitle($penyaji, 0);
        $section->addTextBreak(4);
        $section->addTitle('PROGRAM', 1);
        $section->addTitle('Inspection Preventive Maintenace', 1);
        $section->addTextBreak(17);
        $section->addTitle('Di Sajikan Oleh', 2);
        $section->addTitle($penyaji, 2);
        $section->addTitle($from . ' - ' . $to, 2);

        // Create a second page
        $section->addPageBreak();
        $section->addTitle('BAB I', 4);
        $section->addTitle('PENDAHULUAN', 4);
        $section->addTextBreak();
        $section->addText('             Infrastruktur Pelayanan Kesehatan adalah suatu alat dan/atau tempat yang digunakan untuk menyelenggarakan upaya kesehatan, baik promotif, preventif, kuratif maupun rehabilitatif yang dilakukan oleh pemerintah maupun masyarakat. Infrastruktur pada sebuah institusi Rumah Sakit pada umumnya dapat di klasifikasikan menjadi 5 sektor, diantaranya adalah Medical Equipment, Non Medical Equipment, Building, Human Resource dan Operational', $fontStyleName, $paragraphStyleName);
        $section->addImage(public_path('gr.png'), array('width' => 470, 'height' => 230));
        $section->addText('             Medical Equipment adalah infrastruktur terbesar dengan capaian persentase sekitar 37%. Sebagai infrastruktur Rumah Sakit terbesar tentu diharapkan agar peralatan medik tetap dalam kinerja optimal sehingga pelayan Rumah Sakit tidak terhambat. Terkait dengan peraturan Kementrian Kesehatan RI No.35 tentang pentingnya pemeliharaan dan panduan pemeliharaan untuk asset Rumah Sakit bahwa menjamin tersedianya alat kesehatan sesuai standar pelayanan, persyaratan mutu, keamanan, manfaat, keselamatan, dan laik pakai perlu adanya pemeliharaan secara periodik.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Untuk itu perlu dilakukan Program Inspeksi, Pengujian dan Pemeliharaan Peralatan Medik (Inspection Preventive Maintenance). Dimana program ini merupakan suatu pengamatan secara sistematik yang disertai analisis teknis dan ekonomis untuk menjamin berfungsinya suatu alat kesehatan dan memperpanjang usia alat itu sendiri. Tujuannya untuk memastikan keandalan asset agar memperoleh suatu kualitas alat yang aman, laik pakai, serta menghilangkan potensi kegagalan peralatan.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Berdasarkan hasil pengolahan data pada pemeliharaan periodik, diperoleh statistik yang dapat dimanfaatkan untuk program manajemen peralatan medik, sebagai perencanaan jangka panjang untuk upgrade dan penggantian alat. Dalam upaya pelaksanaannya, diperlukan aplikasi penunjang untuk melakukan pengelolaan peralatan medik.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Aplikasi Manajemen Aset Rumah Sakit (MARS) dapat memenuhi kebutuhan Program Inspeksi, Pengujian dan Pemeliharaan Peralatan Medik tersebut, karena meliputi pencatatan dan pelaporan sesuai dengan Peraturan Menteri Kesehatan (PMK) No.15 Tahun 2023 tentang Pemeliharaan Alat Kesehatan di Fasilitas Pelayanan Kesehatan. Beberapa fitur yang terdapat pada aplikasi MARS diantaranya:', $fontStyleName, $paragraphStyleName);
        $section->addText(" 1. Manajemen Preventive Maintenane", $fontStyleName, $paragraphStyleName);
        $section->addText(" 2. Manajemen Inventory", $fontStyleName, $paragraphStyleName);
        $section->addText(" 3. Manajemen Peralatan dan Sparepart", $fontStyleName, $paragraphStyleName);
        $section->addText(" 4. Manajemen Expense", $fontStyleName, $paragraphStyleName);
        $section->addText(" 5. Manajemen Dokumen", $fontStyleName, $paragraphStyleName);
        $section->addText(" 6. General Report", $fontStyleName, $paragraphStyleName);
        $section->addText('             Statistik dari setiap fitur diperlukan sebagai rujukan pengembangan dan tolak ukur dalam Manajemen Fasilitas dan Keselamatan (MFK) dari Rumah Sakit. ', $fontStyleName, $paragraphStyleName);

        // Create a four page
        $section->addPageBreak();
        $section->addTitle('BAB II', 4);
        $section->addTitle('MANAJEMEN PERALATAN MEDIK', 4);
        $section->addTextBreak();

        $section->addText("2.1      MANAJEMEN INSPECTION PREVENTIVE MAINTENANCE (IPM)", $styleFont2, $paragraphStyleName);
        $section->addText('             Secara umum, Manajemen Inspection Preventive Maintenance (IPM) meliputi 4 (empat) jenis kegiatan yaitu: Preventive Maintenace, Service, Kalibrasi dan Training Berdasarkan hasil pengamatan berkala dalam periode ' . $dateFromIndonesia . ' - ' . $dateToIndonesia . ' dilaporkan statistik sebagai berikut:', $fontStyleName, $paragraphStyleName);

        $section->addListItem('Preventive Maintenance', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut tercatat " . $countIpmFinished . " kegiatan Preventive Maintenance Peralatan Medik yang telah terlaksana dari " . $countIpm . " jadwal kegiatan Preventive Maintenance yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Preventive Maintenance adalah sebesar " . $persentaseIpm . "% dari Jadwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Service', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat " . $countServiceFinished . " kegiatan Service Peralatan Medik yang telah terlaksana dari " . $countService . " jadwal kegiatan Service yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Service adalah sebesar " . $persentaseService . "% dari Jadwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Kalibrasi', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat " . $countCalibrationFinished . " kegiatan kalibrasi Peralatan Medik yang terlaksana dari " . $countCalibration . " jadwal kegiatan Kalibrasi yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Kalibrasi adalah sebesar " . $persentaseCalibration . "% dari Jadwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Training', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat " . $countTrainingFinished . " kegiatan Training terlaksana dari " . $countTraining . " jadwal kegiatan Training yang telah di rencanakan, baik itu kegiatan Training yang dilakukan secara internal ataupun kegiatan yang di selenggarakan oleh Pihak Ketiga.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Training adalah sebesar " . $persentaseTraining . "% dari Jadwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        // Create a five page
        $section->addPageBreak();
        $section->addText("2.2      MANAJEMEN INVENTORY", $styleFont2, $paragraphStyleName);
        $section->addText("             Inventarisasi peralatan kesehatan telah dilaksanan dan mencatat total asset sebanyak " . $totalAsset . " units telah di lakukan pendataan dan penempelan label QR-Code, Label QR-Code ini bermanfaat dalam pencarian data peralatan dengan cepat, dengan memanfaatkan teknologi camera pada smartphone ataupun menggunakan barcode scanner.", $fontStyleName, $paragraphStyleName);
        $section->addText('             Inventory Peralatan terbagi menjadi beberapa kategori Peralatan, dengan rincian sebagai berikut :', $fontStyleName, $paragraphStyleName);
        foreach ($countByCategory as $categoryName => $count) {
        $section->addText("• " . ucfirst(strtolower($categoryName)) . " terdapat " . $count . " unit Peralatan", $fontStyleName, $paragraphStyleName);
        }
        $section->addText("• Dengan Akumulasi Total Aset yang di miliki Rumah Sakit sebanyak " . $totalAsset . " units Peralatan", $fontStyleName, $paragraphStyleName);

        $section->addText("2.3      MANAJEMEN PERALATAN DAN SPAREPART", $styleFont2, $paragraphStyleName);
        $section->addText("1.       Asset Peralatan", $fontStyleName, $paragraphStyleName);
        $section->addText("Sampai dengan periode dibuat nya laporan ini, dapat kami sajikan data Inventory beserta Total Asset yang dimiliki :", $fontStyleName, $paragraphStyleName);
        foreach ($totalNilaiBukuByCategory as $row) {
        $section->addText("• ".ucfirst(strtolower($row->category_name)) . " dengan Total Asset " .rupiah($row->total_nilai_buku), $fontStyleName, $paragraphStyleName);
        }
        $section->addText("• Dengan Akumulasi Total Aset yang di miliki Rumah Sakit sebanyak " . $totalAsset . " units Peralatan dengan nilai asset Peralatan sejumlah " .rupiah($totalNilaiBuku), $fontStyleName, $paragraphStyleName);

        $section->addText("2.       Riwayat Peralatan", $fontStyleName, $paragraphStyleName);
        $section->addText("Selain menyajikan jumlah peralatan yang dimiliki, marsweb juga menyajikan riwayat peralatan masing-masing peralatannya, riwayat yang disajikan merupakan riwayat service, riwayat kalibrasi, riwayat maintenance, riwayat training, riwayat penggantian sparepart hingga riwayat pengeluaran biaya-biaya selama peralatan tersebut beroperasi. Riwayat Peralatan dapat dicetak secara terpisah sebagai lampiran.", $fontStyleName, $paragraphStyleName);
        $section->addText("3.       Asset Sparepart", $fontStyleName, $paragraphStyleName);

        $section->addText("Selain asset Peralatan kesehatan, marsweb juga menyajikan total asset sparepart/ asessoris,  dimana tercatat Aset Sparepart yang di miliki oleh Rumah Sakit dan tercatat memiliki Total Aset Sparepart sebesar " . $totalSparePart, $fontStyleName, $paragraphStyleName);
        $section->addText("4.       Riwayat Sparepart", $fontStyleName, $paragraphStyleName);
        $section->addText("Selain riwayat peralatan kesehatan, marsweb juga menyajikan data riwayat  keluar masuk nya sparepart dan asesoris yang kami sajikan terpisah sebagai lampiran. Keluar dan masuk nya sparepart dapat dilakukan secara manual, stock sparepart akan terupdate secara otomatis apabila di dalam kegiatan work order menggunakan stock sparepart dari gudang.", $fontStyleName, $paragraphStyleName);


        $section->addText("2.4      MANAJEMEN EXPENSES", $styleFont2, $paragraphStyleName);
        $section->addText("             Di dalam pelaksanaan kegiatan Work Order, marsweb juga akan mencatat biaya biaya yang muncul selama pelaksanaan diantaranya adalah biaya kalibrasi, biaya service dan biaya penggantian sparepart.", $fontStyleName, $paragraphStyleName);
        $section->addText("• Pada periode ini tercatat biaya pengeluaran untuk kegiatan Service sebesar " . rupiah(Expense('Service', $start_date, $end_date, $hospital_id)), $fontStyleName, $paragraphStyleName);
        $section->addText("• Pada periode ini tercatat biaya pengeluaran untuk kegiatan Kalibrasi sebesar " . rupiah( Expense('Calibration', $start_date, $end_date, $hospital_id)), $fontStyleName, $paragraphStyleName);
        $section->addText("• Pada periode ini tercatat biaya pengeluaran untuk kegiatan Penggantian Sparepart dan Asesoris sebesar " . rupiah(Expense('Replacement', $start_date, $end_date, $hospital_id)), $fontStyleName, $paragraphStyleName);


        $section->addText("2.5      MANAJEMEN DOKUMEN", $styleFont2, $paragraphStyleName);
        $section->addText("            Marsweb juga memberikan fasilitas kepada pengguna untuk dapat menyimpan dokumen penting peralatan, seperti user manual, service manual, sop, service report, tanda terima dan lain lain ataupun menyimpan foto-foto peralatan. Untuk menyimpan dan mengunduh dokumen dapat di lakukan pada menu peralatan.", $fontStyleName, $paragraphStyleName);

        $section->addText("2.6      GENERAL REPORT", $styleFont2, $paragraphStyleName);
        $section->addText("            Marsweb menyajikan General Report dengan template sederhana dalam bentuk file microsoft word sehingga template yang di sajikan dapat dengan mudah di lakukan penambahan data-data yang belum tercatat di dalam aplikasi.", $fontStyleName, $paragraphStyleName);
        $section->addText("            Format general report yang di sajikan merupakan ringkasan dari semua kegiatan yang tercatat di dalam aplikasi marsweb.", $fontStyleName, $paragraphStyleName);

        // Create a seventh page
        $section->addPageBreak();
        $section->addTitle('BAB III', 4);
        $section->addTitle('Kesimpulan', 4);
        $section->addTextBreak(1);
        $section->addText('             Berdasarkan ukuran statistik yang menunjukkan pemeliharaan atas peralatan medik, manajemen dapat menarik kesimpulan bahwa program Inspection Preventive Maintenance (IPM) memiliki peranan dan manfaat yang sangat penting dalam upaya peningkatan mutu pelayanan Rumah Sakit. Statistik tersebut dapat digunakan sebagai bahan acuan perencanaan program IPM berikutnya ataupun perencanaan penambahan peralatan medik.', $fontStyleName, $paragraphStyleName);
        $section->addTextBreak(0);
        $section->addText('             Dari statistik yang tercatat selama periode 01 April 2024 sampai dengan 30 April 2024, dapat dilaporkan bahwa:', $fontStyleName, $paragraphStyleName);
        $section->addText("1. Program Inspection Preventive Maintenance (IPM) telah terlaksana dengan presentase ". persentaseWoType('Inspection and Preventive Maintenance', $start_date, $end_date, $hospital_id). "% dari program preventive maintenance yang telah di jadwalkan.", $fontStyleName, $paragraphStyleName);
        $section->addText("2. Program service telah terlaksana dengan presentase ". persentaseWoType('Service', $start_date, $end_date, $hospital_id). "% dari program service yang telah di jadwalkan.", $fontStyleName, $paragraphStyleName);
        $section->addText("3. Program kalibrasi telah terlaksana dengan presentase ". persentaseWoType('Calibration', $start_date, $end_date, $hospital_id). "% dari program kalibrasi yang telah di jadwalkan.", $fontStyleName, $paragraphStyleName);
        $section->addText("4. Program training telah terlaksana dengan presentase ". persentaseWoType('Training', $start_date, $end_date, $hospital_id). "% dari program training yang telah di jadwalkan.", $fontStyleName, $paragraphStyleName);
        $section->addText("5. Secara keseluruhan program kegiatan yang telah di tetapkan selama masa periode berjalan rata-rata tercapai ". persentaseAllType($start_date, $end_date, $hospital_id). " %.", $fontStyleName, $paragraphStyleName);
        $section->addText("6. Sesuai hasil catatan di dalam marsweb ini, tercatat biaya biaya maintenance, service, kalibrasi dan penggantian part/ asessoris dalam pelaksanaan work order sebesar ". rupiah($totalBiaya).", merupakan ".  round($hitungPersentase, 2)."% dari Total Asset yang di miliki oleh rumah sakit sebesar ".rupiah($totalNilaiBuku), $fontStyleName, $paragraphStyleName);
        // ramdan
        $section->addTextBreak(2);
        $section->addText("                                                                                                                      Jakarta, " . date('d') . ' ' . getMonthIndo(date('m')) . ' ' . date('Y'));
        $section->addText("                                                                                                                $penyaji");
        $section->addTextBreak(4);
        $section->addText("                                                                                                                           (Manager Teknik)");



        // Add footer
        $footer = $section->addFooter();
        $footer->addLink('https://marsweb.id', 'Present by Manajemen Aset Rumah Sakit (MARS)');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('General-Report.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('General-Report.docx'));
    }
}
