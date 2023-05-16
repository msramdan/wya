<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Requests\{StorePositionRequest, UpdatePositionRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Auth;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:position view')->only('index', 'show');
        $this->middleware('permission:position create')->only('create', 'store');
        $this->middleware('permission:position edit')->only('edit', 'update');
        $this->middleware('permission:position delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $positions = Position::with('hospital:id,name');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $positions = $positions->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $positions = $positions->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            return DataTables::of($positions)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('hospital', function ($row) {
                return $row->hospital ? $row->hospital->name : '';
            })

                ->addColumn('action', 'positions.include.action')
                ->toJson();
        }

        return view('positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionRequest $request)
    {

        Position::create($request->validated());
        Alert::toast('The position was created successfully.', 'success');
        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {

        $position->update($request->validated());
        Alert::toast('The position was updated successfully.', 'success');
        return redirect()
            ->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        try {
            $position->delete();
            Alert::toast('The position was deleted successfully.', 'success');
            return redirect()->route('positions.index');
        } catch (\Throwable $th) {
            Alert::toast('The position cant be deleted because its related to another table.', 'error');
            return redirect()->route('positions.index');
        }
    }
}