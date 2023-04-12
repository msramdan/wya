<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Http\Requests\{StoreWorkOrderRequest, UpdateWorkOrderRequest};
use App\Models\EquipmentLocation;
use App\Models\SettingApp;
use App\Models\User;
use App\Models\WorkOrderProcess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:work order view')->only('index', 'show');
        $this->middleware('permission:work order create')->only('create', 'store');
        $this->middleware('permission:work order edit')->only('edit', 'update');
        $this->middleware('permission:work order delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name')->orderBy('work_orders.id', 'DESC');

            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
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
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    if ($displayAction) {
                        return view('work-orders.include.action', ['model' => $row]);
                    } else {
                        return '-';
                    }
                })
                ->toJson();
        }

        return view('work-orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastWorkOrder = WorkOrder::where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))->orderBy('created_at', 'DESC')->first();

        if ($lastWorkOrder) {
            $woNumber = 'WO-' . date('Ymd') . '-' . str_pad(intval(explode('-', $lastWorkOrder->wo_number)[count(explode('-', $lastWorkOrder->wo_number)) - 1]) + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $woNumber = 'WO-' . date('Ymd') . '-0001';
        }

        $data = [
            'equipmentLocations' => EquipmentLocation::orderBy('location_name', 'ASC')->get(),
            'woNumber' => $woNumber,
        ];

        return view('work-orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkOrderRequest $request)
    {
        $settingApp = SettingApp::first();
        $workOrderHasAccessApprovalUsersId = json_decode($settingApp->work_order_has_access_approval_users_id, true);
        $approvalUserId = [];

        if ($workOrderHasAccessApprovalUsersId) {
            if (count($workOrderHasAccessApprovalUsersId) > 0) {
                foreach ($workOrderHasAccessApprovalUsersId as $userId) {
                    $approvalUserId[] = [
                        'user_id' => $userId,
                        'status' => 'pending'
                    ];
                }
            }
        }

        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        $data['status_wo'] = count($approvalUserId) > 0 ? 'pending' : 'accepted';
        $data['approval_users_id'] = json_encode($approvalUserId);

        if ($data['status_wo'] == 'accepted') {
            $data['approved_at'] = date('Y-m-d H:i:s');
        }

        if ($request->category_wo == 'Rutin') {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['schedule_wo'] = $request->schedule_wo;
        } else {
            unset($data['start_date']);
            unset($data['end_date']);
            unset($data['schedule_wo']);
        }

        $workOrder = WorkOrder::create($data);

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
                                'start_date' => $startDateValue,
                                'end_date' => in_array($workOrder->schedule_wo, ['Harian', 'Mingguan']) ? Carbon::createFromFormat('Y-m-d', $tempEndData)->subDay()->format('Y-m-d') : null,
                            ];
                        }

                        $startDateValue = $tempEndData;
                        $counter++;
                    }
                }

                foreach ($workOrderSchedules as $workOrderSchedule) {
                    WorkOrderProcess::create([
                        'work_order_id' => $workOrder->id,
                        'schedule_date' => null,
                        'start_date' => $workOrderSchedule['start_date'],
                        'end_date' => $workOrderSchedule['end_date'],
                        'schedule_wo' => $workOrder->schedule_wo,
                        'status' => 'ready-to-start'
                    ]);
                }
            } elseif ($workOrder->category_wo == 'Non Rutin') {
                WorkOrderProcess::create([
                    'work_order_id' => $workOrder->id,
                    'schedule_date' => $workOrder->schedule_date,
                    'start_date' => null,
                    'end_date' => null,
                    'schedule_wo' => null,
                    'status' => 'ready-to-start'
                ]);
            }
        }

        if ($settingApp->bot_telegram == 1) {
            notifTele($request, 'create_wo');
        }
        Alert::toast('The workOrder was created successfully.', 'success');
        return redirect()->route('work-orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load('equipment:id,barcode', 'user:id,name',);

        return view('work-orders.show', compact('workOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkOrder $workOrder)
    {
        $workOrder->load('equipment:id,barcode', 'user:id,name',);
        $workOrderObj = WorkOrder::find($workOrder->id);
        $equipmentLocations = EquipmentLocation::orderBy('location_name', 'ASC')->get();

        return view('work-orders.edit', compact('workOrder', 'workOrderObj', 'equipmentLocations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkOrderRequest $request, WorkOrder $workOrder)
    {

        $workOrder->update($request->validated());
        Alert::toast('The workOrder was updated successfully.', 'success');
        return redirect()
            ->route('work-orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkOrder $workOrder)
    {
        try {
            $workOrder->delete();
            if (setting_web()->bot_telegram == 1) {
                notifTele($workOrder, 'delete_wo');
            }
            Alert::toast('The workOrder was deleted successfully.', 'success');
            return redirect()->route('work-orders.index');
        } catch (\Throwable $th) {
            Alert::toast('The workOrder cant be deleted because its related to another table.', 'error');
            return redirect()->route('work-orders.index');
        }
    }
}
