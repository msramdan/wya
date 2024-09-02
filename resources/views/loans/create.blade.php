@extends('layouts.app')

@section('title', __('Create Moving Equipment'))

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="modalScanner" tabindex="-1" aria-labelledby="modalScannerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScannerLabel">Modal Scanner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="camera-scanner"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Moving Equipment') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('loans.index') }}">{{ __('Moving Equipment') }}</a>
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
            var cek = {{ session('sessionHospital') }}
            console.log(cek)
            if (cek != '' || cek != null) {
                getEquipmentLocation(cek);
                getPic(cek);
            }
        });

        const _temp = '<option value="" selected disabled>-- Select --</option>';
        $('#hospital_id').change(function() {
            $('#lokasi-peminjam-id, #lokasi-asal-id').html(_temp);
            if ($(this).val() != "") {
                getEquipmentLocation($(this).val());
                getPic($(this).val());
            }
        })

        $('#lokasi-asal-id').change(function() {
            $('#equipment-id').html(_temp);
            if ($(this).val() != "") {
                getEquipment($(this).val());
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

        function getEquipment(locationId) {
            let url = '{{ route('api.getEquipment', ':id') }}';
            url = url.replace(':id', locationId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#equipment-id').prop('disabled', true);
                },
                success: function(res) {
                    console.log(res);
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.serial_number} | ${value.type} | ${value.manufacturer}</option>`
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

    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas3').click(function() {
                i++;
                $('#dynamic_field3').append('<tr id="row3' + i +
                    '"><td><input required type="text" name="name_photo[]" placeholder="" class="form-control " /></td><td><input type="file" name="file_photo_sparepart[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove3"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>'
                );
            });

            $(document).on('click', '.btn_remove3', function() {
                var button_id = $(this).attr("id");
                $('#row3' + button_id + '').remove();
            });

            $(document).on('click', '.btn_remove3', function() {
                var bid = this.id;
                var trid = $(this).closest('tr').attr('id');
                $('#' + trid + '').remove();
            });
        });
    </script>
@endpush
