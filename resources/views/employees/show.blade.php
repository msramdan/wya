@extends('layouts.app')

@section('title', __('Detail of Employees'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Employees') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('employees.index') }}">{{ __('Employees') }}</a>
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
                                        <td class="fw-bold">{{ trans('employee/show.name') }}</td>
                                        <td>{{ $employee->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.nid') }}</td>
                                        <td>{{ $employee->nid_employee }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.type') }}</td>
                                        <td>{{ $employee->employee_type ? $employee->employee_type->name_employee_type : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.status') }}</td>
                                        <td>{{ $employee->employee_status == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.department') }}</td>
                                        <td>{{ $employee->department ? $employee->department->code_department : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.position') }}</td>
                                        <td>{{ $employee->position ? $employee->position->code_position : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.email') }}</td>
                                        <td>{{ $employee->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.phone') }}</td>
                                        <td>{{ $employee->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.province') }}</td>
                                        <td>{{ $employee->province ? $employee->province->provinsi : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kabkot') }}</td>
                                        <td>{{ $employee->kabkot ? $employee->kabkot->provinsi_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.subdistrict') }}</td>
                                        <td>{{ $employee->kecamatan ? $employee->kecamatan->kabkot_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.ward') }}</td>
                                        <td>{{ $employee->kelurahan ? $employee->kelurahan->kecamatan_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.zip_code') }}</td>
                                        <td>{{ $employee->zip_kode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.address') }}</td>
                                        <td>{{ $employee->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.longitude') }}</td>
                                        <td>{{ $employee->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.longitude') }}</td>
                                        <td>{{ $employee->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.join_date') }}</td>
                                        <td>{{ isset($employee->join_date) ? $employee->join_date->format('d/m/Y') : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.photo') }}</td>
                                        <td>{{ $employee->photo }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.created_at') }}</td>
                                        <td>{{ $employee->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('employee/show.updateda_at') }}</td>
                                        <td>{{ $employee->updated_at->format('d/m/Y H:i') }}</td>
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
