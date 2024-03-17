<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\{StoreLoanRequest, UpdateLoanRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            $loans = Loan::with('equipment:id,barcode', 'hospital:id,name', 'equipment_location:id,code_location', 'equipment_location:id,code_location');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $loans = $loans->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $loans = $loans->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }


            return Datatables::of($loans)
                ->addIndexColumn()

                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
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
        return view('loans.create');
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
    public function show(Loan $loan)
    {
        $loan->load('equipment:id,condition', 'hospital:id,bot_telegram', 'equipment_location:id,created_at', 'equipment_location:id,created_at', 'user:id,created_at', 'user:id,created_at',);

        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $loan->load('equipment:id,condition', 'hospital:id,bot_telegram', 'equipment_location:id,created_at', 'equipment_location:id,created_at', 'user:id,created_at', 'user:id,created_at',);

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
