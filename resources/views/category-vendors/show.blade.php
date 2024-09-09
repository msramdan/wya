@extends('layouts.app')

@section('title', __('Detail of Category Vendors'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('category-vendor/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('category-vendors.index') }}">{{ trans('category-vendor/index.head') }}</a>
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
                                        <td class="fw-bold">{{ trans('category-vendor/show.name') }}</td>
                                        <td>{{ $categoryVendor->name_category_vendors }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('category-vendor/show.created') }}</td>
                                        <td>{{ $categoryVendor->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('category-vendor/show.updated') }}</td>
                                        <td>{{ $categoryVendor->updated_at->format('d/m/Y H:i') }}</td>
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
