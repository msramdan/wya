<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Http\Requests\{StoreWorkOrderRequest, UpdateWorkOrderRequest};
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
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name', );

            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('note', function($row){
                    return str($row->note)->limit(100);
                })
				->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', 'work-orders.include.action')
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
        return view('work-orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkOrderRequest $request)
    {
        
        WorkOrder::create($request->validated());
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
        $workOrder->load('equipment:id,barcode', 'user:id,name', );

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
        $workOrder->load('equipment:id,barcode', 'user:id,name', );

		return view('work-orders.edit', compact('workOrder'));
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
            Alert::toast('The workOrder was deleted successfully.', 'success');
            return redirect()->route('work-orders.index');
        } catch (\Throwable $th) {
            Alert::toast('The workOrder cant be deleted because its related to another table.', 'error');
            return redirect()->route('work-orders.index');
        }
    }
}
