@extends('layouts.app')

@section('title', __('Detail of Vendors'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('vendor/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('vendors.index') }}">{{ trans('vendor/index.head') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ trans('vendor/show.detail') }}
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
                                        <td class="fw-bold">{{ trans('vendor/show.vendor_code') }}</td>
                                        <td>{{ $vendor->code_vendor }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.vendor_name') }}</td>
                                        <td>{{ $vendor->name_vendor }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.vendor_category') }}</td>
                                        <td>{{ $vendor->category_vendor ? $vendor->category_vendor->name_category_vendors : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.email') }}</td>
                                        <td>{{ $vendor->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.province') }}</td>
                                        <td>{{ $vendor->province ? $vendor->province->provinsi : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kabkot') }}</td>
                                        <td>{{ $vendor->kabkot ? $vendor->kabkot->provinsi_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.subdistrict') }}</td>
                                        <td>{{ $vendor->kecamatan ? $vendor->kecamatan->kabkot_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.ward') }}</td>
                                        <td>{{ $vendor->kelurahan ? $vendor->kelurahan->kecamatan_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.zip_code') }}</td>
                                        <td>{{ $vendor->zip_kode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.longitude') }}</td>
                                        <td>{{ $vendor->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.latitude') }}</td>
                                        <td>{{ $vendor->latitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.created') }}</td>
                                        <td>{{ $vendor->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('vendor/show.updated') }}</td>
                                        <td>{{ $vendor->updated_at->format('d/m/Y H:i') }}</td>
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
