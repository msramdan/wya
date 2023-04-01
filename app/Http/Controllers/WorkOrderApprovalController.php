<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWorkOrderApprovalRequest;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class WorkOrderApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:work order approval')->only('index');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name',)->orderByRaw(
                'CASE 
                    WHEN `status_wo` = "pending" then 1
                    ELSE 2 
                END'
            )->orderBy('updated_at', 'DESC');

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

                    if ($displayAction) {
                        return view('work-order-approvals.include.action', ['model' => $row]);
                    } else {
                        return '-';
                    }
                })
                ->toJson();
        }

        return view('work-order-approvals.index');
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
            'status_wo' => $request->status == 'rejected' ? 'rejected' : ($existsPendingStatus ? 'pending' : $request->status)
        ]);

        Alert::toast('The workOrder was updated successfully.', 'success');
        return redirect()
            ->route('work-order-approvals.index');
    }
}
