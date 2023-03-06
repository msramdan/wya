<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Http\Requests\{StoreCatRequest, UpdateCatRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CatController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cat view')->only('index', 'show');
        $this->middleware('permission:cat create')->only('create', 'store');
        $this->middleware('permission:cat edit')->only('edit', 'update');
        $this->middleware('permission:cat delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $cats = Cat::query();

            return DataTables::of($cats)
                ->addColumn('action', 'cats.include.action')
                ->toJson();
        }

        return view('cats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCatRequest $request)
    {
        
        Cat::create($request->validated());
        Alert::toast('The cat was created successfully.', 'success');
        return redirect()->route('cats.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function show(Cat $cat)
    {
        return view('cats.show', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function edit(Cat $cat)
    {
        return view('cats.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatRequest $request, Cat $cat)
    {
        
        $cat->update($request->validated());
        Alert::toast('The cat was updated successfully.', 'success');
        return redirect()
            ->route('cats.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cat $cat)
    {
        try {
            $cat->delete();
            Alert::toast('The cat was deleted successfully.', 'success');
            return redirect()->route('cats.index');
        } catch (\Throwable $th) {
            Alert::toast('The cat cant be deleted because its related to another table.', 'error');
            return redirect()->route('cats.index');
        }
    }
}
