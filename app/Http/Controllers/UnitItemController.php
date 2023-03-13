<?php

namespace App\Http\Controllers;

use App\Models\UnitItem;
use App\Http\Requests\{StoreUnitItemRequest, UpdateUnitItemRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class UnitItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:unit item view')->only('index', 'show');
        $this->middleware('permission:unit item create')->only('create', 'store');
        $this->middleware('permission:unit item edit')->only('edit', 'update');
        $this->middleware('permission:unit item delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $unitItems = UnitItem::query();

            return DataTables::of($unitItems)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'unit-items.include.action')
                ->toJson();
        }

        return view('unit-items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit-items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitItemRequest $request)
    {

        UnitItem::create($request->validated());
        Alert::toast('The unitItem was created successfully.', 'success');
        return redirect()->route('unit-items.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function show(UnitItem $unitItem)
    {
        return view('unit-items.show', compact('unitItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitItem $unitItem)
    {
        return view('unit-items.edit', compact('unitItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitItemRequest $request, UnitItem $unitItem)
    {

        $unitItem->update($request->validated());
        Alert::toast('The unitItem was updated successfully.', 'success');
        return redirect()
            ->route('unit-items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitItem $unitItem)
    {
        try {
            $unitItem->delete();
            Alert::toast('The unitItem was deleted successfully.', 'success');
            return redirect()->route('unit-items.index');
        } catch (\Throwable $th) {
            Alert::toast('The unitItem cant be deleted because its related to another table.', 'error');
            return redirect()->route('unit-items.index');
        }
    }
}
