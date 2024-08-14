<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWorkOrderApprovalRequest;
use App\Models\User;
use App\Models\Equipment;
use App\Models\WorkOrder;
use App\Models\WorkOrderProcess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;
use App\Marsweb\Notifications\NotifWhatsappWorkOrderApproved;
use App\Marsweb\Notifications\NotifWhatsappWorkOrderRejected;



class WorkOrderApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:work order approval')->only('index');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name', 'hospital:id,name')->orderByRaw(
                'CASE
                    WHEN `status_wo` = "pending" then 1
                    ELSE 2
                END'
            )->orderBy('work_orders.id', 'DESC');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $workOrders = $workOrders->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $workOrders = $workOrders->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
            $equipment_id = intval($request->query('equipment_id'));
            $type_wo = $request->query('type_wo');
            $category_wo = $request->query('category_wo');
            $created_by = intval($request->query('created_by'));

            if (isset($start_date) && !empty($start_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $workOrders = $workOrders->where('filed_date', '>=', $from);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $workOrders = $workOrders->where('filed_date', '>=', $from);
            }
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $workOrders = $workOrders->where('filed_date', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $workOrders = $workOrders->where('filed_date', '<=', $to);
            }

            if (isset($equipment_id) && !empty($equipment_id)) {
                if ($equipment_id != 'All') {
                    $workOrders = $workOrders->where('equipment_id', $equipment_id);
                }
            }

            if (isset($type_wo) && !empty($type_wo)) {
                if ($type_wo != 'All') {
                    $workOrders = $workOrders->where('type_wo', $type_wo);
                }
            }

            if (isset($category_wo) && !empty($category_wo)) {
                if ($category_wo != 'All') {
                    $workOrders = $workOrders->where('category_wo', $category_wo);
                }
            }

            if (isset($created_by) && !empty($created_by)) {
                if ($created_by != 'All') {
                    $workOrders = $workOrders->where('created_by', $created_by);
                }
            }
            $workOrders = $workOrders->orderBy('wo_number', 'DESC');
            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('type_wo', function ($row) {
                    return $row->type_wo == 'Training' ? 'Training/Uji fungsi' : $row->type_wo;
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = false;

                    foreach (json_decode($row->approval_users_id) as $index => $rowApprovalUser) {
                        if ($rowApprovalUser->user_id == request()->user_id && $rowApprovalUser->status == 'pending' && $row->status_wo == 'pending') {
                            if (!isset(json_decode($row->approval_users_id)[$index - 1])) {
                                $displayAction = true;
                            } else {
                                $prevRow = json_decode($row->approval_users_id)[$index - 1];

                                if ($prevRow->status == 'pending') {
                                    $displayAction = false;
                                } else {
                                    $displayAction = true;
                                }
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return view('work-order-approvals.include.action', ['model' => $row, 'arrApprovalUsers' => $arrApprovalUsers, 'displayAction' => $displayAction]);
                })
                ->toJson();
        }

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;

        if (Auth::user()->roles->first()->hospital_id) {
            $equimentHospital = Equipment::where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
            $dataUser = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.hospital_id')
                ->where('roles.hospital_id', Auth::user()->roles->first()->hospital_id)
                ->get();
        } else {
            $equimentHospital = Equipment::all();
            $dataUser = User::all();
        }

        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        $equipment_id = $request->query('equipment_id') ?? null;
        $type_wo = $request->query('type_wo') ?? null;
        $category_wo = $request->query('category_wo') ?? null;
        $created_by = $request->query('created_by') !== null ? intval($request->query('created_by')) : null;
        $hospital_id = $request->query('hospital_id') !== null ? intval($request->query('hospital_id')) : null;


        return view('work-order-approvals.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
            'user' => $dataUser,
            'equipment' => $equimentHospital,
            'equipment_id' => $equipment_id,
            'type_wo' => $type_wo,
            'category_wo' => $category_wo,
            'created_by' => $created_by,

        ]);
    }

    public function update(UpdateWorkOrderApprovalRequest $request, $id)
    {
        $workOrder = WorkOrder::find($id);
        $workOrderApprovalUsers = [];
        $existsPendingStatus = false;
        $allRejected = false;

        foreach (json_decode($workOrder->approval_users_id, true) as $woApprovalUserId) {
            if ($allRejected) {
                $woApprovalUserId['status'] = 'rejected';
            }

            if ($woApprovalUserId['user_id'] == Auth::user()->id) {
                $woApprovalUserId['status'] = $request->status;

                if ($request->status == 'rejected') {
                    $allRejected = true;
                }
            }

            if ($woApprovalUserId['status'] == 'pending') {
                $existsPendingStatus = true;
            }

            $workOrderApprovalUsers[] = $woApprovalUserId;
        }

        $workOrder->update([
            'approval_users_id' => json_encode($workOrderApprovalUsers),
            'status_wo' => $request->status == 'rejected' ? 'rejected' : ($existsPendingStatus ? 'pending' : $request->status),
            'approved_at' => $request->status == 'rejected' ? null : ($existsPendingStatus ? null : date('Y-m-d H:i:s')),
        ]);

        // send notif wa ke all user
        $settingApp = Hospital::findOrFail(Auth::user()->roles->first()->hospital_id);
        if ($settingApp->notif_wa == 1) {
            $receiverUsers = json_decode($workOrder->approval_users_id, true);
            foreach ($receiverUsers as $receiverUserId) {
                $receiverUser = User::find($receiverUserId);
                if ($receiverUser) {
                    try {
                        if ($receiverUser->no_hp) {
                            if($request->status == 'accepted'){
                                new NotifWhatsappWorkOrderApproved($receiverUser->no_hp, $workOrder, Auth::user()->roles->first()->hospital_id);
                            }else{
                                new NotifWhatsappWorkOrderRejected($receiverUser->no_hp, $workOrder, Auth::user()->roles->first()->hospital_id);
                            }

                        }
                    } catch (\Throwable $th) {
                        if ($receiverUser[0]->no_hp) {
                            if($request->status == 'accepted'){
                                new NotifWhatsappWorkOrderApproved($receiverUser[0]->no_hp, $workOrder, Auth::user()->roles->first()->hospital_id);
                            }else{
                                new NotifWhatsappWorkOrderRejected($receiverUser[0]->no_hp, $workOrder, Auth::user()->roles->first()->hospital_id);
                            }
                        }
                    }
                }
            }
        }

        if ($workOrder->status_wo == 'accepted') {
            if ($workOrder->category_wo == 'Rutin') {
                $startDateValue = $workOrder->start_date;
                $endDateValue = $workOrder->end_date;
                $scheduleWoValue = $workOrder->schedule_wo;
                $scheduleWoFormatted = '';
                $stepModeAmount = 1;
                $counter = 1;
                $workOrderSchedules = [];

                if ($startDateValue && $endDateValue && $scheduleWoValue) {
                    switch ($scheduleWoValue) {
                        case 'Harian':
                            $scheduleWoFormatted = 'days';
                            break;
                        case 'Mingguan':
                            $scheduleWoFormatted = 'weeks';
                            break;
                        case 'Bulanan':
                            $scheduleWoFormatted = 'months';
                            break;
                        case '2 Bulanan':
                            $stepModeAmount = 2;
                            $scheduleWoFormatted = 'months';
                            break;
                        case '3 Bulanan':
                            $stepModeAmount = 3;
                            $scheduleWoFormatted = 'months';
                            break;
                        case '4 Bulanan':
                            $stepModeAmount = 4;
                            $scheduleWoFormatted = 'months';
                            break;
                        case '6 Bulanan':
                            $stepModeAmount = 6;
                            $scheduleWoFormatted = 'months';
                            break;
                        case 'Tahunan':
                            $scheduleWoFormatted = 'years';
                            break;
                    }

                    while ($startDateValue <= $endDateValue) {
                        $tempEndData = Carbon::createFromFormat('Y-m-d', $startDateValue)->add($stepModeAmount, $scheduleWoFormatted)->format('Y-m-d');

                        if (Carbon::createFromFormat('Y-m-d', $tempEndData)->subDay()->format('Y-m-d') <= $endDateValue) {
                            $workOrderSchedules[] = [
                                'schedule_date' => $startDateValue,
                            ];
                        }

                        $startDateValue = $tempEndData;
                        $counter++;
                    }
                }

                foreach ($workOrderSchedules as $workOrderSchedule) {
                    $workOrderProcessCode = mt_rand(100000, 999999);

                    while (WorkOrderProcess::where('code', $workOrderProcessCode)->count() > 0) {
                        $workOrderProcessCode = mt_rand(100000, 999999);
                    }

                    WorkOrderProcess::create([
                        'work_order_id' => $workOrder->id,
                        'schedule_date' => $workOrderSchedule['schedule_date'],
                        'start_date' => null,
                        'code' => $workOrderProcessCode,
                        'end_date' => null,
                        'schedule_wo' => $workOrder->schedule_wo,
                        'status' => 'ready-to-start'
                    ]);
                }
            } else if ($workOrder->category_wo == 'Non Rutin') {
                $workOrderProcessCode = mt_rand(100000, 999999);

                while (WorkOrderProcess::where('code', $workOrderProcessCode)->count() > 0) {
                    $workOrderProcessCode = mt_rand(100000, 999999);
                }

                WorkOrderProcess::create([
                    'work_order_id' => $workOrder->id,
                    'schedule_date' => $workOrder->schedule_date,
                    'start_date' => null,
                    'code' => $workOrderProcessCode,
                    'end_date' => null,
                    'schedule_wo' => null,
                    'status' => 'ready-to-start'
                ]);
            }
        }
        Alert::toast('The workOrder was updated successfully.', 'success');
        return Redirect::to($request->currentUrl);
    }
}
