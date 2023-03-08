@extends('layouts.app')

@section('title', __('Detail of Vendors'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Vendors') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('vendors.index') }}">{{ __('Vendors') }}</a>
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
                                            <td class="fw-bold">{{ __('Code Vendor') }}</td>
                                            <td>{{ $vendor->code_vendor }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Name Vendor') }}</td>
                                            <td>{{ $vendor->name_vendor }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Category Vendor') }}</td>
                                        <td>{{ $vendor->category_vendor ? $vendor->category_vendor->name_category_vendors : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Email') }}</td>
                                            <td>{{ $vendor->email }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Province') }}</td>
                                        <td>{{ $vendor->province ? $vendor->province->provinsi : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kabkot') }}</td>
                                        <td>{{ $vendor->kabkot ? $vendor->kabkot->provinsi_id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kecamatan') }}</td>
                                        <td>{{ $vendor->kecamatan ? $vendor->kecamatan->kabkot_id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kelurahan') }}</td>
                                        <td>{{ $vendor->kelurahan ? $vendor->kelurahan->kecamatan_id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Zip Kode') }}</td>
                                            <td>{{ $vendor->zip_kode }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $vendor->longitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Latitude') }}</td>
                                            <td>{{ $vendor->latitude }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $vendor->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $vendor->updated_at->format('d/m/Y H:i') }}</td>
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
