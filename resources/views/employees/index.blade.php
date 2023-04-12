@extends('layouts.app')

@section('title', __('Employees'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Employees') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Employees') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('employee create')
                                <a href="{{ route('employees.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new employee') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Nid Employee') }}</th>
                                            <th>{{ __('Employee Type') }}</th>
                                            <th>{{ __('Employee Status') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th>{{ __('Position') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'nid_employee',
                    name: 'nid_employee',
                },
                {
                    data: 'employee_type',
                    name: 'employee_type.name_employee_type'
                },
                {
                    data: 'employee_status',
                    name: 'employee_status',
                },
                {
                    data: 'department',
                    name: 'department.code_department'
                },
                {
                    data: 'position',
                    name: 'position.code_position'
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
