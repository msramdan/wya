@extends('layouts.app')

@section('title', __('Hospitals'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Hospitals') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Hospitals') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                    <div class="card-header">
                            @can('hospital create')
                                <a href="{{ route('hospitals.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new hospital') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
											<th>{{ __('Phone') }}</th>
											<th>{{ __('Email') }}</th>
											<th>{{ __('Address') }}</th>
											<th>{{ __('Logo') }}</th>
											<th>{{ __('Notif Wa') }}</th>
											<th>{{ __('Url Wa Gateway') }}</th>
											<th>{{ __('Session Wa Gateway') }}</th>
											<th>{{ __('Paper Qr Code') }}</th>
											<th>{{ __('Bot Telegram') }}</th>
											<th>{{ __('Work Order Has Access Approval Users Id') }}</th>
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
            ajax: "{{ route('hospitals.index') }}",
            columns: [
                {
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
                    data: 'phone',
                    name: 'phone',
                },
				{
                    data: 'email',
                    name: 'email',
                },
				{
                    data: 'address',
                    name: 'address',
                },
				{
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Logo">
                        </div>`;
                        }
                    },
				{
                    data: 'notif_wa',
                    name: 'notif_wa',
                },
				{
                    data: 'url_wa_gateway',
                    name: 'url_wa_gateway',
                },
				{
                    data: 'session_wa_gateway',
                    name: 'session_wa_gateway',
                },
				{
                    data: 'paper_qr_code',
                    name: 'paper_qr_code',
                },
				{
                    data: 'bot_telegram',
                    name: 'bot_telegram',
                },
				{
                    data: 'work_order_has_access_approval_users_id',
                    name: 'work_order_has_access_approval_users_id',
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