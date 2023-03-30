@extends('layouts.app')

@section('title', __('Create Work Orders'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Work Orders') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('work-orders.index') }}">{{ __('Work Orders') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Create') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('work-orders.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('work-orders.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> {{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-scripts')
    <script>
        /**
         * Event When Equipment Location is changed
         *  
         */
        $('#location_id').on("select2:select", function(e) {
            const equipmentLocationId = $('#location_id').val();

            fetch(`{{ route('api.equipment.index') }}?equipment_location_id=${equipmentLocationId}`)
                .then((res) => res.json())
                .then((response) => {
                    $('#equipment-id').select2('destroy');
                    $("#equipment-id").html('<option value="" selected disabled>-- Select equipment --</option>');

                    response.data.forEach((equipment) => {
                        $("#equipment-id").append(`<option value="${equipment.id}">${equipment.serial_number}</option>`);
                    });
                    $('#equipment-id').select2();
                    !$('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').addClass('d-none') : '';
                });
        });

        /**
         * Event When Equipment is changed
         * 
         */
        $('#equipment-id').on('select2:select', function(e) {
            const value = $('#equipment-id').val();

            fetch(`{{ route('api.equipment.index') }}/${value}`)
                .then((res) => res.json())
                .then((response) => {
                    let data = response.data;
                    $('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').removeClass('d-none') : '';

                    $('#container-equipment-detail #equipment-detail-content').html(
                        `<div class="row">
                            <div class="col-lg-4">
                                <img src="/storage/img/equipment/${data.photo}" class="img-thumbnail" alt="">
                            </div>
                            <div class="col-lg-8">
                                <table class="table">
                                    <tr>
                                        <th>Barcode</th>
                                        <th>:</th>
                                        <td>${data.barcode}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Category</th>
                                        <th>:</th>
                                        <td>${data.equipment_category.category_name}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>:</th>
                                        <td>${data.vendor.name_vendor}</td>
                                    </tr>
                                    <tr>
                                        <th>Risk Level</th>
                                        <th>:</th>
                                        <td>${data.risk_level}</td>
                                    </tr>
                                    <tr>
                                        <th>Financing Code</th>
                                        <th>:</th>
                                        <td>${data.financing_code}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomenklatur</th>
                                        <th>:</th>
                                        <td>${data.nomenklatur.name_nomenklatur}</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>:</th>
                                        <td>${data.manufacturer}</td>
                                    </tr>
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>:</th>
                                        <td>${data.serial_number}</td>
                                    </tr>
                                    <tr>
                                        <th>Condition</th>
                                        <th>:</th>
                                        <td>${data.condition}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Location</th>
                                        <th>:</th>
                                        <td>${data.equipment_location.location_name}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>`
                    );
                });
        });

        /**
         * Event When Category WO Changed
         * 
         */
        $('#category-wo').on('change', function() {
            const value = $('#category-wo').val();

            if (value != '') {
                $('#schedule-information-container').hasClass('d-none') ? $('#schedule-information-container').removeClass('d-none') : '';
            }

            if (value == 'Rutin') {
                !$('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().addClass('d-none') : '';
                !$('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().addClass('d-none') : '';
                !$('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().addClass('d-none') : '';
            } else if (value == 'Non Rutin') {
                $('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().removeClass('d-none') : '';
                $('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().removeClass('d-none') : '';
                $('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().removeClass('d-none') : '';
            }
        })
    </script>
@endpush
