<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\{StoreLoanRequest, UpdateLoanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:loan view')->only('index', 'show');
        $this->middleware('permission:loan create')->only('create', 'store');
        $this->middleware('permission:loan edit')->only('edit', 'update');
        $this->middleware('permission:loan delete')->only('destroy');
    }

    /**
     * Menampilkan daftar sumber daya.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $loans = DB::table('loans')
                ->select(
                    'loans.*',
                    'equipment.barcode',
                    'equipment.manufacturer',
                    'equipment.type',
                    'equipment.serial_number',
                    'hospitals.name as hospital_name',
                    'employees.name as employee_name',
                    'el1.code_location as resource_location',
                    'el2.code_location as destination_location',
                    'uc.name as user_created_name',
                    'uu.name as user_updated_name',
                )
                ->leftJoin('equipment', 'loans.equipment_id', '=', 'equipment.id')
                ->leftJoin('hospitals', 'loans.hospital_id', '=', 'hospitals.id')
                ->leftJoin('employees', 'loans.pic_penanggungjawab', '=', 'employees.id')
                ->leftJoin('equipment_locations as el1', 'loans.lokasi_asal_id', '=', 'el1.id')
                ->leftJoin('equipment_locations as el2', 'loans.lokasi_peminjam_id', '=', 'el2.id')
                ->leftJoin('users as uc', 'loans.user_created', '=', 'uc.id')
                ->leftJoin('users as uu', 'loans.user_updated', '=', 'uu.id');
            $loans = $loans->where('loans.hospital_id', session('sessionHospital'));
            $loans = $loans->orderBy('loans.id', 'DESC')->get();
            return Datatables::of($loans)
                ->addIndexColumn()
                ->addColumn('equipment', function ($row) {
                    return $row->barcode ? $row->barcode : '';
                })
                ->addColumn('employee_name', function ($row) {
                    return $row->employee_name ? $row->employee_name : '';
                })
                ->addColumn('waktu_pinjam', function ($row) {
                    return \Carbon\Carbon::parse($row->waktu_pinjam)->format('Y-m-d');
                })

                ->addColumn('rencana_pengembalian', function ($row) {
                    if ($row->rencana_pengembalian > date('Y-m-d')) {
                        return '<button style="width:90px" class="btn btn-success btn-sm btn-block"> ' . $row->rencana_pengembalian . '</button>';
                    } else {
                        return '<button style="width:90px" class="btn btn-danger btn-sm btn-block"> ' . $row->rencana_pengembalian . '</button>';
                    }
                })
                ->addColumn('action', 'loans.include.action')
                ->rawColumns(['rencana_pengembalian', 'action'])
                ->toJson();
        }

        return view('loans.index');
    }

    /**
     * Menampilkan formulir untuk membuat sumber daya baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastLoan = Loan::where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))->orderBy('created_at', 'DESC')->first();

        if ($lastLoan) {
            $noPeminjaman = 'LN-' . date('Ymd') . '-' . str_pad(intval(explode('-', $lastLoan->no_peminjaman)[count(explode('-', $lastLoan->no_peminjaman)) - 1]) + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $noPeminjaman = 'LN-' . date('Ymd') . '-0001';
        }

        $data = [
            'noPeminjaman' => $noPeminjaman,
        ];

        return view('loans.create', $data);
    }

    /**
     * Menyimpan sumber daya baru ke dalam penyimpanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        $attr['status_peminjaman'] = 'Belum dikembalikan';
        $attr['user_created'] = Auth::id();
        $loan =  Loan::create($attr);

        if ($loan) {
            $insertedId = $loan->id;
            if ($request->hasFile('file_photo_sparepart')) {
                $name_photo = $request->name_photo;
                $file_photo = $request->file('file_photo_sparepart');
                foreach ($file_photo as $key => $a) {
                    $file_photo_name = $a->hashName();
                    $a->storeAs('public/img/moving_photo', $file_photo_name);
                    $dataPhoto = [
                        'loan_id' => $insertedId,
                        'name_photo' => $name_photo[$key],
                        'photo' => $file_photo_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    DB::table('loans_photo')->insert($dataPhoto);
                }
            }
        }

        Alert::toast('Peminjaman Alat berhasil dibuat.', 'success');
        return redirect()
            ->route('loans.index');
    }

    /**
     * Menampilkan sumber daya yang ditentukan.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = DB::table('loans')
            ->select(
                'loans.*',
                'equipment.barcode',
                'hospitals.name as hospital_name',
                'employees.name as employee_name',
                'el1.code_location as resource_location',
                'el2.code_location as destination_location',
                'uc.name as user_created_name',
                'uu.name as user_updated_name',
            )
            ->leftJoin('equipment', 'loans.equipment_id', '=', 'equipment.id')
            ->leftJoin('hospitals', 'loans.hospital_id', '=', 'hospitals.id')
            ->leftJoin('employees', 'loans.pic_penanggungjawab', '=', 'employees.id')
            ->leftJoin('equipment_locations as el1', 'loans.lokasi_asal_id', '=', 'el1.id')
            ->leftJoin('equipment_locations as el2', 'loans.lokasi_peminjam_id', '=', 'el2.id')
            ->leftJoin('users as uc', 'loans.user_created', '=', 'uc.id')
            ->leftJoin('users as uu', 'loans.user_updated', '=', 'uu.id')
            ->where('loans.id', $id)
            ->first();
        $photo  = DB::table('loans_photo')->where('loan_id', $id)->get();
        return view('loans.show', compact('loan', 'photo'));
    }

    /**
     * Menampilkan formulir untuk mengedit sumber daya yang ditentukan.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = DB::table('loans')
            ->select(
                'loans.*',
                'equipment.barcode',
                'hospitals.name as hospital_name',
                'employees.name as employee_name',
                'el1.code_location as resource_location',
                'el2.code_location as destination_location',
                'uc.name as user_created_name',
                'uu.name as user_updated_name',
            )
            ->leftJoin('equipment', 'loans.equipment_id', '=', 'equipment.id')
            ->leftJoin('hospitals', 'loans.hospital_id', '=', 'hospitals.id')
            ->leftJoin('employees', 'loans.pic_penanggungjawab', '=', 'employees.id')
            ->leftJoin('equipment_locations as el1', 'loans.lokasi_asal_id', '=', 'el1.id')
            ->leftJoin('equipment_locations as el2', 'loans.lokasi_peminjam_id', '=', 'el2.id')
            ->leftJoin('users as uc', 'loans.user_created', '=', 'uc.id')
            ->leftJoin('users as uu', 'loans.user_updated', '=', 'uu.id')
            ->where('loans.id', $id)
            ->first();
        cekAksesRs($loan->hospital_id);
        $photo  = DB::table('loans_photo')->where('loan_id', $id)->get();
        return view('loans.edit', compact('loan', 'photo'));
    }

    /**
     * Memperbarui sumber daya yang ditentukan dalam penyimpanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $attr = $request->validated();
        $attr['user_updated'] = Auth::id();

        if ($request->hasFile('file_photo_sparepart')) {
            $name_photo = $request->name_photo;
            $file_photo = $request->file('file_photo_sparepart');
            foreach ($file_photo as $key => $a) {
                $file_photo_name = $a->hashName();
                $a->storeAs('public/img/moving_photo', $file_photo_name);
                $dataPhoto = [
                    'loan_id' => $loan->id,
                    'name_photo' => $name_photo[$key],
                    'photo' => $file_photo_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                DB::table('loans_photo')->insert($dataPhoto);
            }
        }

        $loan->update($attr);
        Alert::toast('Peminjaman Alat berhasil diubah.', 'success');
        return redirect()
            ->route('loans.index');
    }

    /**
     * Menghapus sumber daya yang ditentukan dari penyimpanan.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        cekAksesRs($loan->hospital_id);
        DB::table('loans_photo')->where('loan_id', $id)->delete();
        $loan->delete();
        Alert::toast('Peminjaman Alat berhasil dihapus.', 'success');
        return redirect()->route('loans.index');
    }
}
