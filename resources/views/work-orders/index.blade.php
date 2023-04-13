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
                                            <th style="white-space: nowrap">{{ __('Wo Number') }}</th>
                                            <th style="white-space: nowrap">{{ __('Equipment') }}</th>
                                            <th style="white-space: nowrap">{{ __('Type Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Category Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Requested Start Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Requested End Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Note') }}</th>
                                            <th style="white-space: nowrap">{{ __('User') }}</th>
                                            <th style="white-space: nowrap">{{ __('Approval Users') }}</th>
                                            <th style="white-space: nowrap">{{ __('Status Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Filed Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Action') }}</th>
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
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'wo_number',
                    name: 'wo_number'
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
                    data: 'category_wo',
                    name: 'category_wo',
                },
                {
                    data: 'schedule_date',
                    render: function(datum, type, row) {
                        return row.schedule_date ? row.schedule_date : '-';
                    }
                },
                {
                    data: 'start_date',
                    render: function(datum, type, row) {
                        return row.start_date ? row.start_date : '-';
                    }
                },
                {
                    data: 'end_date',
                    render: function(datum, type, row) {
                        return row.end_date ? row.end_date : '-';
                    }
                },
                {
                    data: 'schedule_wo',
                    render: function(datum, type, row) {
                        return row.schedule_wo ? row.schedule_wo : '-';
                    }
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
                    name: "approval_users_id",
                    render: function(datum, type, row) {
                        let htmlEl = '<ul>';
                        row.approval_users_id.forEach((e) => {
                            switch (e.status) {
                                case 'pending':
                                    rowStatus = 'primary';
                                    break;
                                case 'rejected':
                                    rowStatus = 'danger';
                                    break;
                                case 'accepted':
                                    rowStatus = 'success';
                                    break;
                                default:
                                    rowStatus = 'success';
                                    break;
                            }

                            htmlEl +=
                                `<li style="white-space: nowrap">${e.user_name}: <span class="badge bg-${rowStatus}">${e.status}</span></li>`;
                        })

                        htmlEl += '</ul>';

                        return htmlEl;
                    }
                },
                {
                    data: 'status_wo',
                    render: function(datum, type, row) {
                        switch (row.status_wo) {
                            case 'pending':
                                rowStatus = 'primary';
                                break;
                            case 'rejected':
                                rowStatus = 'danger';
                                break;
                            case 'accepted':
                                rowStatus = 'success';
                                break;
                            default:
                                rowStatus = 'success';
                                break;
                        }

                        return `<span class="badge bg-${rowStatus}">${['on-going', 'finished'].includes(row.status_wo) ? 'accepted' : row.status_wo}</span>`;
                    }
                },
                {
                    data: 'filed_date',
                    name: 'filed_date',
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
