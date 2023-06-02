@extends('layouts.app')

@section('title', __('Detail of Departments'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('employee/departement/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('departments.index') }}">{{ trans('employee/departement/index.head') }}</a>
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
                                        <td class="fw-bold">{{ trans('employee/departement/show.code') }}</td>
                                        <td>{{ $department->code_department }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/departement/show.name') }}</td>
                                        <td>{{ $department->name_department }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/departement/show.is_active') }}</td>
                                        <td>{{ $department->is_active == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/departement/show.created_at') }}</td>
                                        <td>{{ $department->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/departement/show.updated_at') }}</td>
                                        <td>{{ $department->updated_at->format('d/m/Y H:i') }}</td>
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
