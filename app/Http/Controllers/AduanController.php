<?php

namespace App\Http\Controllers;

use App\Exports\ExportAduan;
use App\Models\Aduan;
use App\Http\Requests\{StoreAduanRequest, UpdateAduanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select(
                'comments.id',
                'comments.komentar',
                'comments.tanggal',
                'users.name as user_name',
                'users.email as user_email',
                'users.avatar as user_avatar'
            )
            ->where('comments.aduan_id', $aduan->id)
            ->orderBy('comments.tanggal', 'asc')
            ->get();

        return view('aduans.show', compact('aduan', 'comments'));
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

    public function exportAduan()
    {
        $date = date('d-m-Y');
        $nameFile = 'Data Aduan' . $date;
        return Excel::download(new ExportAduan(), $nameFile . '.xlsx');
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status_aduan' => 'required|in:Dalam Penanganan,Ditolak,Selesai',
        ]);

        // Mengupdate status aduan di database
        $updated = DB::table('aduans')
            ->where('id', $id)
            ->update(['status' => $request->status_aduan]);

        // Cek apakah update berhasil
        if ($updated) {
            Alert::toast('Status aduan berhasil diperbarui.', 'success');
            return redirect()->route('aduans.show', $id);
        } else {
            Alert::toast('Terjadi kesalahan saat memperbarui status.', 'error');
            return redirect()->route('aduans.show', $id);
        }
    }

    public function storeComment(Request $request, $aduanId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Pastikan aduan dengan id tersebut ada
        $aduan = DB::table('aduans')->where('id', $aduanId)->first();
        if (!$aduan) {
            Alert::toast('Aduan tidak ditemukan.', 'error');
            return redirect()->back();
        }
        DB::table('comments')->insert([
            'aduan_id' => $aduanId,
            'user_id' => auth()->id(),
            'komentar' => $request->input('comment'),
            'tanggal' => now(),
        ]);
        Alert::toast('Komentar berhasil ditambahkan.', 'success');
        return redirect()->route('aduans.show', $aduanId);
    }
}
