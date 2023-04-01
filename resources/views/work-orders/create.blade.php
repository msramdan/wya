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

                                <div class="d-flex justify-content-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2"><i class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>
                                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> {{ __('Save') }}</button>
                                </div>
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
            eventChangeLocationId();
        });

        /**
         * Event When Equipment is changed
         * 
         */
        $('#equipment-id').on('select2:select', function(e) {
            eventChangeEquipmentId();
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

            if (value == 'Non Rutin') {
                !$('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().addClass('d-none') : '';
                !$('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().addClass('d-none') : '';
                !$('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().addClass('d-none') : '';
                $('#schedule-date').parent().hasClass('d-none') ? $('#schedule-date').parent().removeClass('d-none') : '';
            } else if (value == 'Rutin') {
                !$('#schedule-date').parent().hasClass('d-none') ? $('#schedule-date').parent().addClass('d-none') : '';
                $('#end-date').parent().hasClass('d-none') ? $('#end-date').parent().removeClass('d-none') : '';
                $('#start-date').parent().hasClass('d-none') ? $('#start-date').parent().removeClass('d-none') : '';
                $('#schedule-wo').parent().hasClass('d-none') ? $('#schedule-wo').parent().removeClass('d-none') : '';
            }
        })

        /**
         * Checking if location id value is not empty
         *  
         */
        if ($('#location_id').val() != null) {
            eventChangeLocationId(() => {
                eventChangeEquipmentId();
            });
        }

        /**
         * Function event on change location id
         * 
         */
        function eventChangeLocationId(cb = null) {
            const equipmentLocationId = $('#location_id').val();
            const valueEquipmentId = '{{ old('equipment_id') }}';

            fetch(`{{ route('api.equipment.index') }}?equipment_location_id=${equipmentLocationId}`)
                .then((res) => res.json())
                .then((response) => {
                    $('#equipment-id').select2('destroy');
                    $("#equipment-id").html('<option value="" selected disabled>-- Select equipment --</option>');

                    response.data.forEach((equipment) => {
                        $("#equipment-id").append(`<option value="${equipment.id}" ${valueEquipmentId == equipment.id ? 'selected' : ''}>${equipment.serial_number}</option>`);
                    });
                    $('#equipment-id').select2();
                    !$('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').addClass('d-none') : '';

                    if (cb != null) {
                        cb();
                    }
                });
        }

        /**
         * Function event on change equipment id
         * 
         */
        function eventChangeEquipmentId() {
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
        }
    </script>
@endpush
