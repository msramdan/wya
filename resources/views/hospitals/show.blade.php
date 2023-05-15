@extends('layouts.app')

@section('title', __('Detail of Work Orders'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Work Orders') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('work-orders.index') }}">{{ __('Work Orders') }}</a>
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
                                        <td class="fw-bold">{{ __('Equipment') }}</td>
                                        <td>{{ $workOrder->equipment ? $workOrder->equipment->id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Type Wo') }}</td>
                                        <td>{{ $workOrder->type_wo == 1 ? 'True' : 'False' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Filed Date') }}</td>
                                            <td>{{ isset($workOrder->filed_date) ? $workOrder->filed_date->format('d/m/Y') : ''  }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Category Wo') }}</td>
                                        <td>{{ $workOrder->category_wo == 1 ? 'True' : 'False' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Schedule Date') }}</td>
                                            <td>{{ isset($workOrder->schedule_date) ? $workOrder->schedule_date->format('d/m/Y') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Note') }}</td>
                                            <td>{{ $workOrder->note }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $workOrder->user ? $workOrder->user->name : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Status Wo') }}</td>
                                        <td>{{ $workOrder->status_wo == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $workOrder->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $workOrder->updated_at->format('d/m/Y H:i') }}</td>
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
