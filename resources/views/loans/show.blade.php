@extends('layouts.app')

@section('title', __('Detail of Loans'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Loans') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/panel">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('loans.index') }}">{{ __('Loans') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('Detail') }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                            <td class="fw-bold">{{ __('No Peminjaman') }}</td>
                                            <td>{{ $loan->no_peminjaman }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Equipment') }}</td>
                                        <td>{{ $loan->equipment ? $loan->equipment->condition : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Hospital') }}</td>
                                        <td>{{ $loan->hospital ? $loan->hospital->bot_telegram : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Equipment Location') }}</td>
                                        <td>{{ $loan->equipment_location ? $loan->equipment_location->created_at : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Equipment Location') }}</td>
                                        <td>{{ $loan->equipment_location ? $loan->equipment_location->created_at : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Waktu Pinjam') }}</td>
                                            <td>{{ isset($loan->waktu_pinjam) ? $loan->waktu_pinjam->format('d/m/Y H:i') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Waktu Dikembalikan') }}</td>
                                            <td>{{ isset($loan->waktu_dikembalikan) ? $loan->waktu_dikembalikan->format('d/m/Y H:i') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Alasan Peminjaman') }}</td>
                                            <td>{{ $loan->alasan_peminjaman }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Status Peminjaman') }}</td>
                                            <td>{{ $loan->status_peminjaman }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Catatan Pengembalian') }}</td>
                                            <td>{{ $loan->catatan_pengembalian }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Pic Penanggungjawab') }}</td>
                                            <td>{{ $loan->pic_penanggungjawab }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Bukti Peminjaman') }}</td>
                                        <td>
                                            @if ($loan->bukti_peminjaman == null)
                                            <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Bukti Peminjaman"  class="rounded" width="200" height="150" style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/bukti_peminjamen/' . $loan->bukti_peminjaman) }}" alt="Bukti Peminjaman" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Bukti Pengembalian') }}</td>
                                        <td>
                                            @if ($loan->bukti_pengembalian == null)
                                            <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Bukti Pengembalian"  class="rounded" width="200" height="150" style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/bukti_pengembalians/' . $loan->bukti_pengembalian) }}" alt="Bukti Pengembalian" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $loan->user ? $loan->user->created_at : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $loan->user ? $loan->user->created_at : '' }}</td>
                                    </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $loan->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $loan->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
@endsection
