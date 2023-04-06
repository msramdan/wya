<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WorkOrder;
use App\Models\WorkOrderProcess;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderProcessController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::whereIn('work_orders.status_wo', ['accepted', 'on-going', 'finished'])

                ->with('equipment:id,barcode', 'user:id,name')->orderByRaw(
                    'CASE 
                        WHEN `status_wo` = "accepted" then 1
                        WHEN `status_wo` = "on-going" then 2
                        ELSE 23
                    END'
                )->orderBy('updated_at', 'DESC');

            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('finished_processes', function ($row) {
                    return $row->countWoProcess('finished') . '/' . $row->countWoProcess();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })
                ->toJson();
        }

        return view('work-order-process.index');
    }

    public function show($workOrderId)
    {
        if (request()->ajax()) {
            $workOrderProcesses = WorkOrderProcess::where('work_order_id', $workOrderId)->orderBy('start_date', 'ASC');

            return DataTables::of($workOrderProcesses)
                ->addIndexColumn()
                ->toJson();
        }

        return view('work-order-process.show', [
            'workOrderId' => $workOrderId
        ]);
    }

    public function update(Request $request, $workOrderProcessId)
    {
        $this->validate($request, [
            'status' => 'required|in:on-progress,finished'
        ]);

        $workOrderProcess = WorkOrderProcess::find($workOrderProcessId);
        $workOrder = WorkOrder::find($workOrderProcess->work_order_id);
        $workOrderProcess->update([
            'status' => $request->status
        ]);

        if ($request->status == 'on-progress') {
            $workOrder->update([
                'status_wo' => 'on-going'
            ]);
        } else if ($request->status == 'finished') {
            if ($workOrder->countWoProcess('ready-to-start') == 0) {
                if ($workOrder->countWoProcess('on-progress') == 0) {
                    $workOrder->update([
                        'status_wo' => 'finished'
                    ]);
                }
            }
        }

        Alert::toast('The Work Order Process status was updated successfully.', 'success');
        return back();
    }

    public function woProcessEdit($workOrderId, $workOrderProcesessId)
    {
        $workOrderProcesess = WorkOrderProcess::find($workOrderProcesessId);
        $workOrder = WorkOrder::find($workOrderId);
        $vendors = Vendor::select('id', 'name_vendor')->get();
        $spareparts = Sparepart::select('id', 'sparepart_name')->get();

        return view('work-order-process.wo-process-wo', [
            'workOrder' => $workOrder,
            'workOrderProcesess' => $workOrderProcesess,
            'vendors' => $vendors,
            'spareparts' => $spareparts,
        ]);
    }
}
