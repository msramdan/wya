@extends('layouts.app')

@section('title', __('Detail of Aduans'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Aduans') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('aduans.index') }}">{{ __('Aduans') }}</a>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama') }}</td>
                                        <td>{{ $aduan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $aduan->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Judul') }}</td>
                                        <td>{{ $aduan->judul }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Keterangan') }}</td>
                                        <td>{{ $aduan->keterangan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal') }}</td>
                                        <td>{{ $aduan->tanggal }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Type') }}</td>
                                        <td>{{ $aduan->type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Read') }}</td>
                                        <td>{{ $aduan->is_read }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status') }}</td>
                                        <td>
                                            @if ($aduan->status == 'Dalam Penanganan')
                                                <button class="btn btn-secondary">
                                                    <i class="fa fa-spinner fa-spin"></i> {{ $aduan->status }}
                                                </button>
                                            @elseif ($aduan->status == 'Ditolak')
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-times-circle"></i> {{ $aduan->status }}
                                                </button>
                                            @elseif ($aduan->status == 'Selesai')
                                                <button class="btn btn-success">
                                                    <i class="fa fa-check-circle"></i> {{ $aduan->status }}
                                                </button>
                                            @else
                                                <span>{{ $aduan->status }}</span>
                                                <!-- Fallback if status is not one of the known values -->
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Token') }}</td>
                                        @if ($aduan->token != null)
                                            <td><b>{{ $aduan->token }}</b></td>
                                        @else
                                            <td><b>-</b></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"
                                    aria-hidden="true"></i> {{ __('Kembali') }}</a>
                            @can('update aduan')
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#statusModal">{{ __('Update Status') }}</button>
                            @endcan


                            <!-- Modal -->
                            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusModalLabel">{{ __('Update Status Aduan') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('aduans.updateStatus', $aduan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="status"
                                                        class="form-label">{{ __('Status Baru') }}</label>
                                                    <select class="form-select" id="status_aduan" name="status_aduan"
                                                        required>
                                                        <option value="Dalam Penanganan"
                                                            {{ $aduan->status == 'Dalam Penanganan' ? 'selected' : '' }}>
                                                            {{ __('Dalam Penanganan') }}
                                                        </option>
                                                        <option value="Ditolak"
                                                            {{ $aduan->status == 'Ditolak' ? 'selected' : '' }}>
                                                            {{ __('Ditolak') }}
                                                        </option>
                                                        <option value="Selesai"
                                                            {{ $aduan->status == 'Selesai' ? 'selected' : '' }}>
                                                            {{ __('Selesai') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
