@extends('layouts.app')

@section('title', __('Detail of Hospitals'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('hospital/index.head') }}<</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('hospitals.index') }}">{{ trans('hospital/index.head') }}<</a>
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
                                        <td>{{ $hospital->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Phone') }}</td>
                                        <td>{{ $hospital->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $hospital->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Address') }}</td>
                                        <td>{{ $hospital->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Logo') }}</td>
                                        <td>
                                            @if ($hospital->logo == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Logo" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/logos/' . $hospital->logo) }}"
                                                    alt="Logo" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Notif Wa') }}</td>
                                        <td>{{ $hospital->notif_wa == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Url Wa Gateway') }}</td>
                                        <td>{{ $hospital->url_wa_gateway }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Api Key Wa Gateway') }}</td>
                                        <td>{{ $hospital->api_key_wa_gateway }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Paper Qr Code') }}</td>
                                        <td>{{ $hospital->paper_qr_code == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bot Telegram') }}</td>
                                        <td>{{ $hospital->bot_telegram == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Work Order Has Access Approval Users Id') }}</td>
                                        <td>{{ $hospital->work_order_has_access_approval_users_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $hospital->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $hospital->updated_at->format('d/m/Y H:i') }}</td>
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
