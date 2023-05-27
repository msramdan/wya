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



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));
        $hospitals = Hospital::all();
        $hospital_id = intval($request->query('hospital_id'));
        $sessionId = Auth::user()->roles->first()->hospital_id;
        if ($sessionId == null) {
            if (isset($hospital_id) && !empty($hospital_id)) {
                $ids = $hospital_id;
            } else {
                $ids = Hospital::first()->id;
            }
        } else {
            $ids = Auth::user()->roles->first()->hospital_id;
        }
        $countVendor = Vendor::where('hospital_id', $ids)->count();
        $countEmployee = Employee::where('hospital_id', $ids)->count();
        $countEquipment = Equipment::where('hospital_id', $ids)->count();
        $countWorkOrder = WorkOrder::where('hospital_id', $ids)->count();
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
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $microFrom = strtotime($from) * 1000;
            $in = $in->where('sparepart_trace.created_at', '>=', $from);
            $out = $out->where('sparepart_trace.created_at', '>=', $from);
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
            $microTo = $end_date;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $microTo = strtotime($to) * 1000;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
        }
        $sql = "SELECT * FROM `spareparts` WHERE hospital_id='$ids' and stock < opname limit 10";
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
            if (Auth::user()->roles->first()->hospital_id) {
                $workOrders = $workOrders->where('hospital_id', Auth::user()->roles->first()->hospital_id);
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
            if (Auth::user()->roles->first()->hospital_id) {
                $equipments = $equipments->where('hospital_id', Auth::user()->roles->first()->hospital_id);
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

            if (Auth::user()->roles->first()->hospital_id) {
                $employees = $employees->where('hospital_id', Auth::user()->roles->first()->hospital_id);
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
            if (Auth::user()->roles->first()->hospital_id) {
                $vendors = $vendors->where('hospital_id', Auth::user()->roles->first()->hospital_id);
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
}
