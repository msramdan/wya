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
                                        <a href="/">{{ __('Dashboard') }}</a>
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
                                            <td class="fw-bold">{{ __('Name') }}</td>
                                            <td>{{ $employee->name }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nid Employee') }}</td>
                                            <td>{{ $employee->nid_employee }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Employee Type') }}</td>
                                        <td>{{ $employee->employee_type ? $employee->employee_type->name_employee_type : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Employee Status') }}</td>
                                        <td>{{ $employee->employee_status == 1 ? 'True' : 'False' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Department') }}</td>
                                        <td>{{ $employee->department ? $employee->department->code_department : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Position') }}</td>
                                        <td>{{ $employee->position ? $employee->position->code_position : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Email') }}</td>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Phone') }}</td>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Province') }}</td>
                                        <td>{{ $employee->province ? $employee->province->provinsi : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kabkot') }}</td>
                                        <td>{{ $employee->kabkot ? $employee->kabkot->provinsi_id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kecamatan') }}</td>
                                        <td>{{ $employee->kecamatan ? $employee->kecamatan->kabkot_id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kelurahan') }}</td>
                                        <td>{{ $employee->kelurahan ? $employee->kelurahan->kecamatan_id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Zip Kode') }}</td>
                                            <td>{{ $employee->zip_kode }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Address') }}</td>
                                            <td>{{ $employee->address }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $employee->longitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $employee->longitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Join Date') }}</td>
                                            <td>{{ isset($employee->join_date) ? $employee->join_date->format('d/m/Y') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Photo') }}</td>
                                            <td>{{ $employee->photo }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $employee->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
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
