<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\{StoreLoanRequest, UpdateLoanRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use RealRashid\SweetAlert\Facades\Alert;

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
    public function index()
    {
        if (request()->ajax()) {
            $loans = Loan::with('equipment:id,condition', 'hospital:id,bot_telegram', 'equipment_location:id,created_at', 'equipment_location:id,created_at', 'user:id,created_at', 'user:id,created_at', );

            return Datatables::of($loans)
                ->addColumn('alasan_peminjaman', function($row){
                    return str($row->alasan_peminjaman)->limit(100);
                })
				->addColumn('catatan_pengembalian', function($row){
                    return str($row->catatan_pengembalian)->limit(100);
                })
				->addColumn('bukti_peminjaman', function($row){
                    return str($row->bukti_peminjaman)->limit(100);
                })
				->addColumn('bukti_pengembalian', function($row){
                    return str($row->bukti_pengembalian)->limit(100);
                })
				->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->condition : '';
                })->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->bot_telegram : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->created_at : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->created_at : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->created_at : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->created_at : '';
                })
                ->addColumn('bukti_peminjaman', function ($row) {
                    if ($row->bukti_peminjaman == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/bukti-peminjamen/' . $row->bukti_peminjaman);
                })
                ->addColumn('bukti_pengembalian', function ($row) {
                    if ($row->bukti_pengembalian == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/bukti-pengembalians/' . $row->bukti_pengembalian);
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

        Loan::create($attr);

        return redirect()
            ->route('loans.index')
            ->with('success', __('The loan was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        $loan->load('equipment:id,condition', 'hospital:id,bot_telegram', 'equipment_location:id,created_at', 'equipment_location:id,created_at', 'user:id,created_at', 'user:id,created_at', );

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
        $loan->load('equipment:id,condition', 'hospital:id,bot_telegram', 'equipment_location:id,created_at', 'equipment_location:id,created_at', 'user:id,created_at', 'user:id,created_at', );

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
