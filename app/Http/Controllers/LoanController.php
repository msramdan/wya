<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\{StoreLoanRequest, UpdateLoanRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
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
     * Display a listing of the resource.
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

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $loans = $loans->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $loans = $loans->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }
            $loans = $loans->orderBy('loans.id', 'DESC')->get();
            return Datatables::of($loans)
                ->addIndexColumn()
                ->addColumn('equipment', function ($row) {
                    return $row->barcode ? $row->barcode : '';
                })->addColumn('hospital', function ($row) {
                    return $row->hospital_name ? $row->hospital_name : '';
                })
                ->addColumn('employee_name', function ($row) {
                    return $row->employee_name ? $row->employee_name : '';
                })
                ->addColumn('action', 'loans.include.action')
                ->toJson();
        }

        return view('loans.index');
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('bukti_peminjaman') && $request->file('bukti_peminjaman')->isValid()) {

            $path = storage_path('app/public/uploads/bukti_peminjamen/');
            $filename = $request->file('bukti_peminjaman')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('bukti_peminjaman')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['bukti_peminjaman'] = $filename;
        }
        if ($request->file('bukti_pengembalian') && $request->file('bukti_pengembalian')->isValid()) {

            $path = storage_path('app/public/uploads/bukti_pengembalians/');
            $filename = $request->file('bukti_pengembalian')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('bukti_pengembalian')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['bukti_pengembalian'] = $filename;
        }
        $attr['status_peminjaman'] = 'Belum dikembalikan';
        $attr['user_created'] = Auth::id();
        Loan::create($attr);
        Alert::toast('The loan was created successfully.', 'success');
        return redirect()
            ->route('loans.index');
    }

    /**
     * Display the specified resource.
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
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
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
        return view('loans.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $attr = $request->validated();

        if ($request->file('bukti_peminjaman') && $request->file('bukti_peminjaman')->isValid()) {

            $path = storage_path('app/public/uploads/bukti_peminjamen/');
            $filename = $request->file('bukti_peminjaman')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('bukti_peminjaman')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old bukti_peminjaman from storage
            if ($loan->bukti_peminjaman != null && file_exists($path . $loan->bukti_peminjaman)) {
                unlink($path . $loan->bukti_peminjaman);
            }

            $attr['bukti_peminjaman'] = $filename;
        }
        if ($request->file('bukti_pengembalian') && $request->file('bukti_pengembalian')->isValid()) {

            $path = storage_path('app/public/uploads/bukti_pengembalians/');
            $filename = $request->file('bukti_pengembalian')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('bukti_pengembalian')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old bukti_pengembalian from storage
            if ($loan->bukti_pengembalian != null && file_exists($path . $loan->bukti_pengembalian)) {
                unlink($path . $loan->bukti_pengembalian);
            }

            $attr['bukti_pengembalian'] = $filename;
        }

        $loan->update($attr);

        return redirect()
            ->route('loans.index')
            ->with('success', __('The loan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        try {
            $path = storage_path('app/public/uploads/bukti_peminjamen/');

            if ($loan->bukti_peminjaman != null && file_exists($path . $loan->bukti_peminjaman)) {
                unlink($path . $loan->bukti_peminjaman);
            }
            $path = storage_path('app/public/uploads/bukti_pengembalians/');

            if ($loan->bukti_pengembalian != null && file_exists($path . $loan->bukti_pengembalian)) {
                unlink($path . $loan->bukti_pengembalian);
            }

            $loan->delete();

            return redirect()
                ->route('loans.index')
                ->with('success', __('The loan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('loans.index')
                ->with('error', __("The loan can't be deleted because it's related to another table."));
        }
    }
}
