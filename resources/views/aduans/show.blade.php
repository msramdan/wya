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
                <div class="col-md-12">
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
                                                <button class="btn btn-secondary">{{ $aduan->status }}</button>
                                            @elseif ($aduan->status == 'Ditolak')
                                                <button class="btn btn-danger">{{ $aduan->status }}</button>
                                            @elseif ($aduan->status == 'Selesai')
                                                <button class="btn btn-success">{{ $aduan->status }}</button>
                                            @else
                                                <span>{{ $aduan->status }}</span>
                                                <!-- Fallback if status is not one of the known values -->
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
