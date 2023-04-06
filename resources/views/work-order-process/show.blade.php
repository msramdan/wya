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
                                            <th style="white-space: nowrap">{{ __('Start Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('End Date') }}</th>
                                            <th style="white-space: nowrap">{{ __('Schedule Wo') }}</th>
                                            <th style="white-space: nowrap">{{ __('Status') }}</th>
                                            <th style="white-space: nowrap">{{ __('Created At') }}</th>
                                            <th style="white-space: nowrap">{{ __('Updated At') }}</th>
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
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'status',
                    render: function(datum, type, row) {
                        return `<a href="/panel/work-order-processes/${row.work_order_id}/${row.id}" class="btn btn-sm btn-primary d-flex align-items-center" style="width: fit-content"><span class="material-symbols-outlined"> electric_bolt</span> Process </a>`;

                        // if (row.status != 'finished') {
                        //     return `
                    //     <div class="d-flex" style="gap: 6px">
                    //         ${row.status == 'ready-to-start' ?
                    //     `<form method="POST" action="{{ route('work-order-processes.index') }}/${row.id}" onsubmit="return confirm('Are you sure to on-progress schedule')">
                        //                                             @csrf
                        //                                             @method('PUT')
                        //                                             <input type="hidden" name="status" value="on-progress"></input>
                        //                                             <button type="submit" class="btn btn-sm btn-primary">
                        //                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11q1.65 0 2.825-1.175T16 7V4H8v3q0 1.65 1.175 2.825T12 11ZM4 22v-2h2v-3q0-1.525.713-2.863T8.7 12q-1.275-.8-1.987-2.138T6 7V4H4V2h16v2h-2v3q0 1.525-.713 2.863T15.3 12q1.275.8 1.988 2.138T18 17v3h2v2H4Z"/></svg>
                        //                                             </button>    
                        //                                         </form>`: ''
                    //     }
                    //     <form method="POST" action="{{ route('work-order-processes.index') }}/${row.id}" onsubmit="return confirm('Are you sure to finished schedule')">
                    //         @csrf
                    //         @method('PUT')
                    //         <input type="hidden" name="status" value="finished"></input>
                    //         <button type="submit" class="btn btn-sm btn-success">
                    //             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M1024 0q141 0 272 36t244 104t207 160t161 207t103 245t37 272q0 141-36 272t-104 244t-160 207t-207 161t-245 103t-272 37q-141 0-272-36t-244-104t-207-160t-161-207t-103-245t-37-272q0-141 36-272t104-244t160-207t207-161T752 37t272-37zm603 685l-136-136l-659 659l-275-275l-136 136l411 411l795-795z"/></svg>
                    //         </button>
                    //     </form>  
                    // </div>
                    // `;
                        // } else {
                        //     return '';
                        // }

                    }
                },
            ],
        });
    </script>
@endpush
