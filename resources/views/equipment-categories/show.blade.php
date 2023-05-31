@extends('layouts.app')

@section('title', __('Detail of Equipment Categories'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Equipment Categories') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('equipment-categories.index') }}">{{ __('Equipment Categories') }}</a>
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
                                        <td class="fw-bold">{{ trans('main-data/equipment/category/show.category_code') }}</td>
                                        <td>{{ $equipmentCategory->code_categoty }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('main-data/equipment/category/show.category_name') }}</td>
                                        <td>{{ $equipmentCategory->category_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('main-data/equipment/category/show.created_at') }}</td>
                                        <td>{{ $equipmentCategory->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('main-data/equipment/category/show.updated_at') }}</td>
                                        <td>{{ $equipmentCategory->updated_at->format('d/m/Y H:i') }}</td>
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
