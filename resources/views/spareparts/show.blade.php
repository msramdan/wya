@extends('layouts.app')

@section('title', __('Detail of Spareparts'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Spareparts') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('spareparts.index') }}">{{ __('Spareparts') }}</a>
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
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.barcode') }}</td>
                                        <td>{{ $sparepart->barcode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.sparepart_name') }}</td>
                                        <td>{{ $sparepart->sparepart_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.merk') }}</td>
                                        <td>{{ $sparepart->merk }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.sparepart_type') }}</td>
                                        <td>{{ $sparepart->sparepart_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.unit_item') }}</td>
                                        <td>{{ $sparepart->unit_item ? $sparepart->unit_item->code_unit : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.estimated_price') }}</td>
                                        <td>{{ $sparepart->estimated_price }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.stock') }}</td>
                                        <td>{{ $sparepart->stock }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.created_at') }}</td>
                                        <td>{{ $sparepart->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ trans('inventory/sparepart/show.updated_at') }}</td>
                                        <td>{{ $sparepart->updated_at->format('d/m/Y H:i') }}</td>
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
