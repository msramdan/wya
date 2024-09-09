@extends('layouts.app')

@section('title', __('Detail of Equipments'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ trans('inventory/equipment/index.head') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('equipments.index') }}">{{ trans('inventory/equipment/index.head') }}</a>
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
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.barcode') }}</td>
                                        <td>{{ $equipment->barcode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.nomenklatur') }}</td>
                                        <td>{{ $equipment->nomenklatur ? $equipment->nomenklatur->code_nomenklatur : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.eq_category') }}</td>
                                        <td>{{ $equipment->equipment_category ? $equipment->equipment_category->code_categoty : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.manufacturer') }}</td>
                                        <td>{{ $equipment->manufacturer }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.Type') }}</td>
                                        <td>{{ $equipment->type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.serial_number') }}</td>
                                        <td>{{ $equipment->serial_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.vendor') }}</td>
                                        <td>{{ $equipment->vendor ? $equipment->vendor->code_vendor : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.condition') }}</td>
                                        <td>{{ $equipment->condition == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.risk_level') }}</td>
                                        <td>{{ $equipment->risk_level == 1 ? 'True' : 'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.eq_location') }}</td>
                                        <td>{{ $equipment->equipment_location ? $equipment->equipment_location->code_location : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.financing_code') }}</td>
                                        <td>{{ $equipment->financing_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.photo') }}</td>
                                        <td>{{ $equipment->photo }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.created_at') }}</td>
                                        <td>{{ $equipment->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/equipment/show.updated_at') }}</td>
                                        <td>{{ $equipment->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
