<?php

namespace App\Http\Controllers;

use App\Models\CategoryVendor;
use App\Http\Requests\{StoreCategoryVendorRequest, UpdateCategoryVendorRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryVendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category vendor view')->only('index', 'show');
        $this->middleware('permission:category vendor create')->only('create', 'store');
        $this->middleware('permission:category vendor edit')->only('edit', 'update');
        $this->middleware('permission:category vendor delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $categoryVendors = CategoryVendor::query();

            return DataTables::of($categoryVendors)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'category-vendors.include.action')
                ->toJson();
        }

        return view('category-vendors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category-vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryVendorRequest $request)
    {
        
        CategoryVendor::create($request->validated());
        Alert::toast('The categoryVendor was created successfully.', 'success');
        return redirect()->route('category-vendors.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryVendor  $categoryVendor
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryVendor $categoryVendor)
    {
        return view('category-vendors.show', compact('categoryVendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryVendor  $categoryVendor
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryVendor $categoryVendor)
    {
        return view('category-vendors.edit', compact('categoryVendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryVendor  $categoryVendor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryVendorRequest $request, CategoryVendor $categoryVendor)
    {
        
        $categoryVendor->update($request->validated());
        Alert::toast('The categoryVendor was updated successfully.', 'success');
        return redirect()
            ->route('category-vendors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryVendor  $categoryVendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryVendor $categoryVendor)
    {
        try {
            $categoryVendor->delete();
            Alert::toast('The categoryVendor was deleted successfully.', 'success');
            return redirect()->route('category-vendors.index');
        } catch (\Throwable $th) {
            Alert::toast('The categoryVendor cant be deleted because its related to another table.', 'error');
            return redirect()->route('category-vendors.index');
        }
    }
}