<?php

namespace App\Http\Controllers;

use App\Helpers\ModelFileUploadHelper;
use App\Http\Requests\UpdateWorkOrderProcesessRequest;
use App\Models\Employee;
use App\Models\Sparepart;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WoProcessHistory;
use App\Models\WorkOrder;
use App\Models\WorkOrderProcess;
use App\Models\WorkOrderProcessHasCalibrationPerformance;
use App\Models\WorkOrderProcessHasEquipmentInspectionCheck;
use App\Models\WorkOrderProcessHasFunctionCheck;
use App\Models\WorkOrderProcessHasPhysicalCheck;
use App\Models\WorkOrderProcessHasReplacementOfPart;
use App\Models\WorkOrderProcessHasToolMaintenance;
use App\Models\WorkOrderProcessHasWoDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $workOrderProcesses = WorkOrderProcess::where('work_order_id', $workOrderId)->orderBy('schedule_date', 'ASC');

            return DataTables::of($workOrderProcesses)
                ->addIndexColumn()
                ->toJson();
        }

        return view('work-order-process.show', [
            'workOrderId' => $workOrderId
        ]);
    }

    public function update(UpdateWorkOrderProcesessRequest $request, $workOrderProcessId)
    {
        $workOrderProcess = WorkOrderProcess::find($workOrderProcessId);
        $workOrder = WorkOrder::find($workOrderProcess->work_order_id);
        $workOrderProcess->update([
            'status' => $request->status == 'Doing' ? 'on-progress' : 'finished',
            'initial_temperature' => $request->initial_temperature,
            'initial_humidity' => $request->initial_humidity,
            'final_temperature' => $request->final_temperature,
            'final_humidity' => $request->final_humidity,
            'work_date' => $request->work_date,
            'executor' => $request->executor,
            'work_executor_technician_id' => $request->executor == 'technician' ? $request->work_executor_technician_id : null,
            'work_executor_vendor_id' => $request->executor == 'vendor_or_supplier' ? $request->work_executor_vendor_id : null,
            'mesh_voltage' => $request->mesh_voltage,
            'ups' => $request->ups,
            'grounding' => $request->grounding,
            'leakage_electric' => $request->leakage_electric,
            'electrical_safety_note' => $request->electrical_safety_note,
            'calibration_performance_is_feasible_to_use' => $request->calibration_performance_is_feasible_to_use,
            'calibration_performance_calibration_price' => $request->calibration_performance_calibration_price,
            'replacement_of_part_service_price' => $request->replacement_of_part_service_price,
            'tools_can_be_used_well' => $request->tools_can_be_used_well ? true : false,
            'tool_cannot_be_used' => $request->tool_cannot_be_used ? true : false,
            'tool_need_repair' => $request->tool_need_repair ? true : false,
            'tool_can_be_used_need_replacement_accessories' => $request->tool_can_be_used_need_replacement_accessories ? true : false,
            'tool_need_calibration' => $request->tool_need_calibration ? true : false,
            'tool_need_bleaching' => $request->tool_need_bleaching ? true : false,
            'start_date' => $request->start_date == null ? $request->work_date : $workOrder->start_date,
            'end_date' => $request->status != 'Doing' ? date('Y-m-d') : null
        ]);

        WorkOrderProcessHasCalibrationPerformance::where('work_order_process_id', $workOrderProcess->id)->delete();
        foreach ($request->calibration_performance_tool_performance_check as $indexToolPerformanceCheck => $calibration_performance_tool_performance_check) {
            if ($calibration_performance_tool_performance_check) {
                WorkOrderProcessHasCalibrationPerformance::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'tool_performance_check' => $calibration_performance_tool_performance_check,
                    'setting' => $request->calibration_performance_setting[$indexToolPerformanceCheck],
                    'measurable' => $request->calibration_performance_measurable[$indexToolPerformanceCheck],
                    'reference_value' => $request->calibration_performance_reference_value[$indexToolPerformanceCheck],
                    'is_good' => isset($request->calibration_performance_is_good[$indexToolPerformanceCheck]) ? $request->calibration_performance_is_good[$indexToolPerformanceCheck] : null,
                ]);
            }
        }

        WorkOrderProcessHasPhysicalCheck::where('work_order_process_id', $workOrderProcess->id)->delete();
        foreach ($request->physical_check as $indexPhysicalCheck => $physicalCheck) {
            if ($physicalCheck) {
                WorkOrderProcessHasPhysicalCheck::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'physical_check' => $physicalCheck,
                    'physical_health' => isset($request->physical_health[$indexPhysicalCheck]) ? $request->physical_health[$indexPhysicalCheck] : null,
                    'physical_cleanliness' => isset($request->physical_cleanliness[$indexPhysicalCheck]) ? $request->physical_cleanliness[$indexPhysicalCheck] : null,
                ]);
            }
        }

        WorkOrderProcessHasFunctionCheck::where('work_order_process_id', $workOrderProcess->id)->delete();
        foreach ($request->function_check_information as $indexCheckInformation => $checkInformation) {
            if ($checkInformation) {
                WorkOrderProcessHasFunctionCheck::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'information' => $checkInformation,
                    'status' => isset($request->function_check_status[$indexCheckInformation]) ? $request->function_check_status[$indexCheckInformation] : null,
                ]);
            }
        }

        WorkOrderProcessHasEquipmentInspectionCheck::where('work_order_process_id', $workOrderProcess->id)->delete();
        foreach ($request->equipment_inspect_information as $indexEqInspectInformation => $eqInspectInformation) {
            if ($eqInspectInformation) {
                WorkOrderProcessHasEquipmentInspectionCheck::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'information' => $eqInspectInformation,
                    'status' => isset($request->equipment_inspect_status[$indexEqInspectInformation]) ? $request->equipment_inspect_status[$indexEqInspectInformation] : null,
                ]);
            }
        }

        WorkOrderProcessHasToolMaintenance::where('work_order_process_id', $workOrderProcess->id)->delete();
        foreach ($request->tool_maintenance_information as $indexToolMaintenanceInformation => $toolMaintenanceInformation) {
            if ($toolMaintenanceInformation) {
                WorkOrderProcessHasToolMaintenance::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'information' => $toolMaintenanceInformation,
                    'status' => isset($request->tool_maintenance_status[$indexToolMaintenanceInformation]) ? $request->tool_maintenance_status[$indexToolMaintenanceInformation] : null,
                ]);
            }
        }

        $posibbleWoProcessHasReplacements = WorkOrderProcessHasReplacementOfPart::where('work_order_process_id', $workOrderProcess->id)->pluck('id');
        $updatedWoProcessHasReplacements = request()->replacement_id;


        foreach ($posibbleWoProcessHasReplacements as $posibbleWoProcessHasReplacement) {
            if (!in_array($posibbleWoProcessHasReplacement, $updatedWoProcessHasReplacements)) {
                WorkOrderProcessHasReplacementOfPart::where('id', $posibbleWoProcessHasReplacement)->delete();
            }
        }

        foreach ($request->replacement_sparepart_id as $indexReplacementSparepartId => $replacementSparepartId) {
            if ($replacementSparepartId && !isset(request()->replacement_id[$indexReplacementSparepartId])) {

                $sparepart = Sparepart::find($replacementSparepartId);
                $sparepart->update([
                    'stock' => (int) $sparepart->stock - $request->replacement_qty[$indexReplacementSparepartId]
                ]);

                WorkOrderProcessHasReplacementOfPart::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'sparepart_id' => $replacementSparepartId,
                    'price' => $request->replacement_price[$indexReplacementSparepartId],
                    'amount' => $request->replacement_amount[$indexReplacementSparepartId],
                    'qty' => $request->replacement_qty[$indexReplacementSparepartId],
                ]);

                DB::table('sparepart_trace')->insert([
                    'qty' => $request->replacement_qty[$indexReplacementSparepartId],
                    'sparepart_id' => $replacementSparepartId,
                    'note' => 'Work Order Process',
                    'no_referensi' => $workOrderProcess->code,
                    'type' => 'Out',
                    'user_id' => Auth::user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        foreach (WorkOrderProcessHasWoDocument::where('work_order_process_id', $workOrderProcess->id)->get() as $delWoProcWoDoc) {
            if (!in_array($delWoProcWoDoc->id, $request->old_id)) {
                ModelFileUploadHelper::modelFileDelete($delWoProcWoDoc, 'file');
            }
            $delWoProcWoDoc->delete();
        }

        foreach ($request->wo_doc_document_name as $indexWoDocDocumentName => $woDocDocumentName) {
            if ($woDocDocumentName) {
                WorkOrderProcessHasWoDocument::create([
                    'work_order_process_id' => $workOrderProcess->id,
                    'document_name' => $woDocDocumentName,
                    'description' => $request->wo_doc_description[$indexWoDocDocumentName],
                    'file' => isset(request()->old_wo_doc_file[$indexWoDocDocumentName]) ? explode('/', request()->old_wo_doc_file[$indexWoDocDocumentName])[count(explode('/', request()->old_wo_doc_file[$indexWoDocDocumentName])) - 1] : ModelFileUploadHelper::modelFileStore('work_order_process_has_wo_documents', 'file', $request->file('wo_doc_file')[$indexWoDocDocumentName])
                ]);
            }
        }

        if ($request->status == 'Doing') {
            $workOrder->update([
                'status_wo' => 'on-going'
            ]);
        } else if ($request->status == 'Finish') {
            if ($workOrder->countWoProcess('ready-to-start') == 0) {
                if ($workOrder->countWoProcess('on-progress') == 0) {
                    $workOrder->update([
                        'status_wo' => 'finished',
                        'end_date' => date('Y-m-d')
                    ]);
                }
            }
        }

        WoProcessHistory::create([
            'wo_process_id' => $workOrderProcess->id,
            'status_wo_process' => $workOrderProcess->status,
            'date_time' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id
        ]);

        Alert::toast('The Work Order Process status was updated successfully.', 'success');
        return redirect('/panel/work-order-processes/' . $workOrder->id);
    }

    public function woProcessEdit($workOrderId, $workOrderProcesessId)
    {
        $workOrderProcesess = WorkOrderProcess::find($workOrderProcesessId);
        $workOrder = WorkOrder::find($workOrderId);
        $vendors = Vendor::select('id', 'name_vendor')->get();
        $spareparts = Sparepart::where('stock', '>', 0)->get();

        return view('work-order-process.wo-process-wo', [
            'workOrder' => $workOrder,
            'workOrderProcesess' => $workOrderProcesess,
            'vendors' => $vendors,
            'spareparts' => $spareparts,
            'employees' => Employee::get(),
            'readonly' => false
        ]);
    }

    public function woProcessInfo($workOrderId, $workOrderProcesessId)
    {
        $workOrderProcesess = WorkOrderProcess::find($workOrderProcesessId);
        $workOrder = WorkOrder::find($workOrderId);
        $vendors = Vendor::select('id', 'name_vendor')->get();
        $spareparts = Sparepart::get();

        return view('work-order-process.wo-process-wo', [
            'workOrder' => $workOrder,
            'workOrderProcesess' => $workOrderProcesess,
            'vendors' => $vendors,
            'spareparts' => $spareparts,
            'employees' => Employee::get(),
            'readonly' => true
        ]);
    }

    public function woProcessPrint($workOrderId, $workOrderProcesessId)
    {
        $workOrderProcesess = WorkOrderProcess::find($workOrderProcesessId);
        $workOrder = WorkOrder::find($workOrderId);
        $vendors = Vendor::select('id', 'name_vendor')->get();
        $spareparts = Sparepart::get();

        $pdf = Pdf::loadView('work-order-process.wo-process-wo-print', [
            'workOrder' => $workOrder,
            'workOrderProcesess' => $workOrderProcesess,
            'vendors' => $vendors,
            'spareparts' => $spareparts,
            'employees' => Employee::get(),
            'readonly' => true
        ]);

        return $pdf->stream();
    }
}