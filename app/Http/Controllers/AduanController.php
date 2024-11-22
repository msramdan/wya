<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Http\Requests\{StoreAduanRequest, UpdateAduanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class AduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:aduan view')->only('index', 'show');
        $this->middleware('permission:aduan create')->only('create', 'store');
        $this->middleware('permission:aduan edit')->only('edit', 'update');
        $this->middleware('permission:aduan delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            // Order by id in descending order
            $aduans = Aduan::query()->orderBy('id', 'desc');

            return DataTables::of($aduans)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'Dalam Penanganan') {
                        return '<span class="badge badge-label bg-info badge-width"><i class="mdi mdi-circle-medium"></i>Dalam Penanganan</span>';
                    } else if ($row->status == 'Ditolak') {
                        return '<span class="badge badge-label bg-danger badge-width"><i class="mdi mdi-circle-medium"></i>Ditolak</span>';
                    } else {
                        return '<span class="badge badge-label bg-success badge-width"><i class="mdi mdi-circle-medium"></i>Selesai</span>';
                    }
                })
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('token', function ($row) {
                    if ($row->token != null) {
                        return $row->token;
                    }
                    return '-';
                })
                ->addColumn('is_read', function ($row) {
                    if ($row->type == 'Private') {
                        return $row->is_read;
                    }
                    return '-';
                })
                ->addColumn('action', 'aduans.include.action')
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return view('aduans.index');
    }

    public function create()
    {
        return view('aduans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAduanRequest $request)
    {

        Aduan::create($request->validated());
        Alert::toast('The aduan was created successfully.', 'success');
        return redirect()->route('aduans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aduan  $aduan
     * @return \Illuminate\Http\Response
     */
    public function show(Aduan $aduan)
    {
        return view('aduans.show', compact('aduan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aduan  $aduan
     * @return \Illuminate\Http\Response
     */
    public function edit(Aduan $aduan)
    {
        return view('aduans.edit', compact('aduan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aduan  $aduan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAduanRequest $request, Aduan $aduan)
    {

        $aduan->update($request->validated());
        Alert::toast('The aduan was updated successfully.', 'success');
        return redirect()
            ->route('aduans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aduan  $aduan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aduan $aduan)
    {
        try {
            $aduan->delete();
            Alert::toast('The aduan was deleted successfully.', 'success');
            return redirect()->route('aduans.index');
        } catch (\Throwable $th) {
            Alert::toast('The aduan cant be deleted because its related to another table.', 'error');
            return redirect()->route('aduans.index');
        }
    }
}
