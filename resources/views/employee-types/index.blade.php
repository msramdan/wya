@extends('layouts.app')

@section('title', __('Employee Types'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Employee Types') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Employee Types') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                    <div class="card-header">
                            @can('employee type create')
                                <a href="{{ route('employee-types.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new employee type') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name Employee Type') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
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
            ajax: "{{ route('employee-types.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name_employee_type',
                    name: 'name_employee_type',
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
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
