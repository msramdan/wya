@extends('layouts.app')

@section('title', __('Detail of Kelurahans'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('region-data/kelurahan/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('kelurahans.index') }}">{{ trans('region-data/kelurahan/index.head') }}</a>
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
                                        <td class="fw-bold">{{ trans('region-data/kelurahan/show.subdistrict') }}</td>
                                        <td>{{ $kelurahan->kecamatan ? $kelurahan->kecamatan->kabkot_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kelurahan/show.ward') }}</td>
                                        <td>{{ $kelurahan->kelurahan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kelurahan/show.zip_code') }}</td>
                                        <td>{{ $kelurahan->kd_pos }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kelurahan/show.created_at') }}</td>
                                        <td>{{ $kelurahan->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('region-data/kelurahan/show.updated_at') }}</td>
                                        <td>{{ $kelurahan->updated_at->format('d/m/Y H:i') }}</td>
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
