@extends('layouts.app')

@section('title', __('Detail of Kecamatans'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('region-data/kecamatan/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('kecamatans.index') }}">{{ trans('region-data/kecamatan/index.head') }}</a>
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
                                        <td class="fw-bold">{{ trans('region-data/kecamatan/show.city_district') }}</td>
                                        <td>{{ $kecamatan->kabkot ? $kecamatan->kabkot->provinsi_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kecamatan/show.subdistrict') }}</td>
                                        <td>{{ $kecamatan->kecamatan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kecamatan/show.created_at') }}</td>
                                        <td>{{ $kecamatan->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kecamatan/show.updated_at') }}</td>
                                        <td>{{ $kecamatan->updated_at->format('d/m/Y H:i') }}</td>
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
