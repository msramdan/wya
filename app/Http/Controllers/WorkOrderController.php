<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Http\Requests\{StoreWorkOrderRequest, UpdateWorkOrderRequest};
use App\Marsweb\Notifications\NotifWhatsappWorkOrderCreated;
use App\Marsweb\Notifications\NotifWhatsappWorkOrderDeleted;
use App\Models\Equipment;
use App\Models\EquipmentLocation;
use App\Models\Hospital;
use App\Models\User;
use App\Models\WorkOrderProcess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name', 'hospital:id,name')->orderBy('work_orders.id', 'DESC');
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
            $equipment_id = intval($request->query('equipment_id'));
            $type_wo = $request->query('type_wo');
            $category_wo = $request->query('category_wo');
            $created_by = intval($request->query('created_by'));
            $workOrders = $workOrders->where('hospital_id', session('sessionHospital'));
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
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('type_wo', function ($row) {
                    return $row->type_wo == 'Training' ? 'Training/Uji fungsi' : $row->type_wo;
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
                ->toJson();
        }

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        $equimentHospital = Equipment::where('hospital_id', session('sessionHospital'))->get();
        $dataUser = User::all();
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        $equipment_id = $request->query('equipment_id') ?? null;
        $type_wo = $request->query('type_wo') ?? null;
        $category_wo = $request->query('category_wo') ?? null;
        $created_by = $request->query('created_by') !== null ? intval($request->query('created_by')) : null;
        return view('work-orders.index', [
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
        $settingApp = Hospital::findOrFail(session('sessionHospital'));
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
        $data['hospital_id'] = session('sessionHospital');
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

        DB::beginTransaction();
        try {
            $workOrder = WorkOrder::create($data);
            $insertedId = $workOrder->id;

            if ($request->hasFile('file_photo_work_order_photo_before')) {
                $name_photo = $request->name_photo;
                $file_photo = $request->file('file_photo_work_order_photo_before');
                foreach ($file_photo as $key => $a) {
                    $file_photo_name = $a->hashName();
                    $a->storeAs('public/img/work_order_photo_before', $file_photo_name);
                    $dataPhoto = [
                        'work_order_id' => $insertedId,
                        'name_photo' => $name_photo[$key],
                        'photo' => $file_photo_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    DB::table('work_order_photo_before')->insert($dataPhoto);
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
                            'code' => $workOrderProcessCode,
                            'schedule_date' => $workOrderSchedule['schedule_date'],
                            'start_date' => null,
                            'end_date' => null,
                            'schedule_wo' => $workOrder->schedule_wo,
                            'status' => 'ready-to-start',
                        ]);
                    }
                } elseif ($workOrder->category_wo == 'Non Rutin') {
                    $workOrderProcessCode = mt_rand(100000, 999999);

                    while (WorkOrderProcess::where('code', $workOrderProcessCode)->count() > 0) {
                        $workOrderProcessCode = mt_rand(100000, 999999);
                    }

                    WorkOrderProcess::create([
                        'work_order_id' => $workOrder->id,
                        'code' => $workOrderProcessCode,
                        'schedule_date' => $workOrder->schedule_date,
                        'start_date' => null,
                        'end_date' => null,
                        'schedule_wo' => null,
                        'status' => 'ready-to-start',
                    ]);
                }
            }

            if ($settingApp->bot_telegram == 1) {
                notifTele($request, 'create_wo');
            }

            if ($settingApp->notif_wa == 1) {
                $receiverUsers = json_decode($workOrder->approval_users_id, true);
                foreach ($receiverUsers as $receiverUserId) {
                    $receiverUser = User::find($receiverUserId);

                    if ($receiverUser) {
                        try {
                            if ($receiverUser->no_hp) {
                                new NotifWhatsappWorkOrderCreated($receiverUser->no_hp, $workOrder, session('sessionHospital'));
                            }
                        } catch (\Throwable $th) {
                            if ($receiverUser[0]->no_hp) {
                                new NotifWhatsappWorkOrderCreated($receiverUser[0]->no_hp, $workOrder, session('sessionHospital'));
                            }
                        }
                    }
                }
            }

            DB::commit();
            Alert::toast('Work Order berhasil dibuat.', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Terjadi kesalahan saat membuat Work Order: ' . $e->getMessage());
            return redirect()->route('work-orders.create')->withInput();
        }

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
        cekAksesRs($workOrder->hospital_id);
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
        try {
            $workOrder->update($request->validated());
            Alert::toast('Work order berhasil diperbarui.', 'success');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat memperbarui work order: ' . $e->getMessage(), 'error');
        }

        return redirect()->route('work-orders.index');
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
            $settingApp = Hospital::findOrFail($workOrder->hospital_id);

            if ($settingApp->bot_telegram == 1) {
                notifTele($workOrder, 'delete_wo');
            }

            if ($settingApp->notif_wa == 1) {
                $receiverUsers = json_decode($workOrder->approval_users_id, true);
                foreach ($receiverUsers as $receiverUserId) {
                    $receiverUser = User::find($receiverUserId['user_id']);
                    if ($receiverUser) {
                        if ($receiverUser->no_hp) {
                            new NotifWhatsappWorkOrderDeleted($receiverUser->no_hp, $workOrder, $workOrder->hospital_id);
                        }
                    }
                }
            }

            Alert::success('Berhasil', 'Work Order berhasil dihapus');
            return redirect()->route('work-orders.index');
        } catch (\Throwable $th) {
            Alert::toast('Work Order tidak bisa dihapus karena terkait dengan tabel lain.', 'error');
            return redirect()->route('work-orders.index');
        }
    }
}
