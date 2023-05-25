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
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
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

    <div class="modal fade" id="modalHistoryWoProcess" tabindex="-1" aria-labelledby="modalHistoryWoProcessLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoryWoProcessLabel">History Wo Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status WO</th>
                                <th>Updated By</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyHistoryProcess">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-libs')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
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
                            $htmlEl =
                                '<div class="d-flex align-items-center justify-content-center" style="gap: 5px">';
                            $htmlEl +=
                                `<div class="d-flex align-items-center justify-content-center"><a href="/panel/work-order-processes/${row.work_order_id}/${row.id}" class="btn btn-sm btn-primary d-flex align-items-center" style="width: fit-content"><span class="material-symbols-outlined"> electric_bolt</span> Process </a> </div>`;
                            $htmlEl +=
                                `<a href="#" onclick="showModalHistory(${row.id})" class="btn btn-sm btn-secondary d-flex align-items-center w-fit"><span class="material-symbols-outlined">view_timeline</span> History</a>`;
                            $htmlEl += '</div>';

                            return $htmlEl;
                        } else {
                            $htmlEl =
                                '<div class="d-flex align-items-center justify-content-center" style="gap: 5px">';
                            $htmlEl +=
                                `<a href="/panel/work-order-processes/${row.work_order_id}/${row.id}/info" class="btn btn-info btn-sm d-flex align-items-center w-fit"><span class="material-symbols-outlined"> description </span> Detail</a>`;
                            $htmlEl +=
                                `<a href="/panel/work-order-processes/${row.work_order_id}/${row.id}/print" target="_blank" class="btn btn-dark btn-sm d-flex align-items-center w-fit"><span class="material-symbols-outlined"> print </span> Print</a> `;
                            $htmlEl +=
                                `<a href="#" onclick="showModalHistory(${row.id})" class="btn btn-sm btn-secondary d-flex align-items-center w-fit"><span class="material-symbols-outlined">view_timeline</span> History</a>`;
                            $htmlEl += '</div>';

                            return $htmlEl;
                        }
                    }
                },
            ],
        });
    </script>
    <script>
        function showModalHistory(woProcessId) {
            const modalHistory = new bootstrap.Modal(document.getElementById('modalHistoryWoProcess'));
            modalHistory.show();

            fetch(`/api/wo-process/${woProcessId}/history`)
                .then((res) => res.json())
                .then((response) => {
                    const tbodyHistoryProcessElement = document.getElementById('tbodyHistoryProcess');
                    tbodyHistoryProcessElement.innerHTML = '';

                    if (response.data.length > 0) {
                        response.data.forEach((data) => {
                            tbodyHistoryProcessElement.insertAdjacentHTML('beforeend',
                                `
                                    <tr>
                                        <td><span class="badge bg-${data.status_wo_process == 'finished' ? 'success' : 'info'}">${data.status_wo_process}</span></td>
                                        <td>${data.updated_by.name}</td>
                                        <td>${data.date_time}</td>
                                    </tr>
                                `
                            );
                        });
                    } else {
                        tbodyHistoryProcessElement.insertAdjacentHTML('beforeend',
                            `
                                <tr>
                                    <td colspan="3" style="text-align: center">No Data</td>
                                </tr>
                            `
                        );
                    }
                });
        }
    </script>
@endpush
