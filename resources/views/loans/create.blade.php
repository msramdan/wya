@extends('layouts.app')

@section('title', __('Create Loans'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Loans') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('loans.index') }}">{{ __('Loans') }}</a>
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
                            <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                @include('loans.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script>
        $(document).ready(function() {
            var cek = $('#hospital_id').val()
            console.log(cek)
            if (cek != '' || cek != null) {
                getEquipmentLocation(cek);
                getEquipment(cek);
                getPic(cek);
            }
        });

        const _temp = '<option value="" selected disabled>-- Select --</option>';
        $('#hospital_id').change(function() {
            $('#lokasi-peminjam-id, #lokasi-asal-id').html(_temp);
            if ($(this).val() != "") {
                getEquipmentLocation($(this).val());
                getEquipment($(this).val());
                getPic($(this).val());
            }
        })

        function getEquipmentLocation(hospitalId) {
            let url = '{{ route('api.getEquipmentLocation', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#lokasi-asal-id').prop('disabled', true);
                    $('#lokasi-peminjam-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.location_name}</option>`
                    });
                    $('#lokasi-asal-id').html(_temp + options)
                    $('#lokasi-asal-id').prop('disabled', false);

                    $('#lokasi-peminjam-id').html(_temp + options)
                    $('#lokasi-peminjam-id').prop('disabled', false);

                },
                error: function(err) {
                    $('#lokasi-asal-id').prop('disabled', false);
                    $('#lokasi-peminjam-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getEquipment(hospitalId) {
            let url = '{{ route('api.getEquipment', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#equipment-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.barcode}</option>`
                    });
                    $('#equipment-id').html(_temp + options)
                    $('#equipment-id').prop('disabled', false);

                },
                error: function(err) {
                    $('#equipment-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getPic(hospitalId) {
            let url = '{{ route('api.getPic', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#pic-penanggungjawab').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.nid_employee} - ${value.name}</option>`
                    });
                    $('#pic-penanggungjawab').html(_temp + options)
                    $('#pic-penanggungjawab').prop('disabled', false);

                },
                error: function(err) {
                    $('#pic-penanggungjawab').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>
@endpush