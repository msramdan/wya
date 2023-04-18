@extends('layouts.app')

@section('title', __('Work Order Processes'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Work Order Procesess') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Work Order Procesess') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Actual Start Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Actual End Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Status') }}</th>
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

@push('css-libs')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endpush

@push('js')
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('work-order-processes.index') }}/{{ $workOrderId }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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
                    data: 'status',
                    render: function(datum, type, row) {
                        let rowStatus = '';
                        switch (row.status) {
                            case 'ready-to-start':
                                rowStatus = 'dark';
                                break;
                            case 'on-progress':
                                rowStatus = 'info';
                                break;
                            case 'finished':
                                rowStatus = 'success';
                                break;
                        }

                        return `<span class="badge bg-${rowStatus}">${row.status}</span>`;
                    }
                },
                {
                    data: 'status',
                    render: function(datum, type, row) {
                        if (row.status != 'finished') {
                            return `<div class="d-flex align-items-center justify-content-center"><a href="/panel/work-order-processes/${row.work_order_id}/${row.id}" class="btn btn-sm btn-primary d-flex align-items-center" style="width: fit-content"><span class="material-symbols-outlined"> electric_bolt</span> Process </a> </div>`;
                        } else {
                            $htmlEl = '<div class="d-flex align-items-center justify-content-center" style="gap: 5px">';
                            $htmlEl += `<a href="/panel/work-order-processes/${row.work_order_id}/${row.id}/info" class="btn btn-info btn-sm d-flex align-items-center w-fit"><span class="material-symbols-outlined"> description </span> Detail</a>`;
                            $htmlEl += `<a href="/panel/work-order-processes/${row.work_order_id}/${row.id}/print" target="_blank" class="btn btn-dark btn-sm d-flex align-items-center w-fit"><span class="material-symbols-outlined"> print </span> Print</a> `;
                            $htmlEl += '</div>';

                            return $htmlEl;
                        }
                    }
                },
            ],
        });
    </script>
@endpush
