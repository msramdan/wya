@extends('layouts.app')

@section('title', __('Work Orders'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Work Orders') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Work Orders') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                    <div class="card-header">
                            @can('work order create')
                                <a href="{{ route('work-orders.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new work order') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Equipment') }}</th>
											<th>{{ __('Type Wo') }}</th>
											<th>{{ __('Filed Date') }}</th>
											<th>{{ __('Category Wo') }}</th>
											<th>{{ __('Schedule Date') }}</th>
											<th>{{ __('Note') }}</th>
											<th>{{ __('User') }}</th>
											<th>{{ __('Status Wo') }}</th>
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
            ajax: "{{ route('work-orders.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'equipment',
                    name: 'equipment.id'
                },
				{
                    data: 'type_wo',
                    name: 'type_wo',
                },
				{
                    data: 'filed_date',
                    name: 'filed_date',
                },
				{
                    data: 'category_wo',
                    name: 'category_wo',
                },
				{
                    data: 'schedule_date',
                    name: 'schedule_date',
                },
				{
                    data: 'note',
                    name: 'note',
                },
				{
                    data: 'user',
                    name: 'user.name'
                },
				{
                    data: 'status_wo',
                    name: 'status_wo',
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
