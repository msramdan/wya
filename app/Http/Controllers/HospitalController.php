<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;

class HospitalController extends Controller
{
    protected $logoPath = '/uploads/images/logos/';
    public function __construct()
    {
        $this->middleware('permission:hospitals view')->only('index', 'show');
        $this->middleware('permission:hospitals create')->only('create', 'store');
        $this->middleware('permission:hospitals edit')->only('edit', 'update');
        $this->middleware('permission:hospitals delete')->only('destroy');
    }
    public function index()
    {
        if (request()->ajax()) {
            $hospital = Hospital::query();
            return DataTables::of($hospital)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('logo', function ($row) {
                    if ($row->logo == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->name))) . '&s=500';
                    }
                    return asset($this->logoPath . $row->logo);
                })
                ->addColumn('action', 'hospitals.include.action')
                ->toJson();
        }
        return view('hospitals.index');
    }
    public function create()
    {
        return view('hospitals.create');
    }
    public function store(StoreHospitalRequest $request)
    {
        $attr = $request->validated();
        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $filename = $request->file('logo')->hashName();

            if (!file_exists($folder = public_path($this->logoPath))) {
                mkdir($folder, 0777, true);
            }

            try {
                Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($this->logoPath . $filename);
            } catch (\Throwable $th) {
                // throw $th;
            }

            $attr['logo'] = $filename;
        }
        Hospital::create($attr);
        return redirect()
            ->route('hospitals.index')
            ->with('success', __('The hospital was created successfully.'));
    }
    public function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }
    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $filename = $request->file('logo')->hashName();

            // if folder dont exist, then create folder
            if (!file_exists($folder = public_path($this->logoPath))) {
                mkdir($folder, 0777, true);
            }

            // Intervention Image
            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->logoPath) . $filename);

            // delete old avatar from storage
            if ($hospital->logo != null && file_exists($oldLogo = public_path($this->logoPath .
                $hospital->logo))) {
                unlink($oldLogo);
            }

            $attr['logo'] = $filename;
        } else {
            $attr['logo'] = $hospital->logo;
        }
        $hospital->update($attr);
        return redirect()
            ->route('hospitals.index')
            ->with('success', __('The hospital was updated successfully.'));
    }
    public function destroy(Hospital $hospital)
    {
        if ($hospital->logo != null && file_exists($oldLogo = public_path($this->logoPath . $hospital->logo))) {
            unlink($oldLogo);
        }
        $hospital->delete();
        return redirect()
            ->route('hospitals.index')
            ->with('success', __('The user was deleted successfully.'));
    }
}
