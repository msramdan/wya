@extends('layouts.app')

@section('title', __('Create Equipments'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('inventory/equipment/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('equipment.index') }}">{{ trans('inventory/equipment/index.head') }}</a>
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
                            <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                @include('equipments.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('Kembali') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Simpan') }}</button>
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
                getEquipmentCategory(cek);
                getVendor(cek);
                getEquipmentLocation(cek);
            }
        });

        const _temp = '<option value="" selected disabled>-- Select --</option>';
        $('#hospital_id').change(function() {
            $('#vendor-id, #equipment-category-id, #equipment-location-id').html(_temp);
            if ($(this).val() != "") {
                getEquipmentCategory($(this).val());
                getVendor($(this).val());
                getEquipmentLocation($(this).val());
            }
        })

        function getEquipmentCategory(hospitalId) {
            let url = '{{ route('api.getEquipmentCategory', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#equipment-category-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.category_name}</option>`
                    });
                    $('#equipment-category-id').html(_temp + options)
                    $('#equipment-category-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#equipment-category-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getVendor(hospitalId) {
            let url = '{{ route('api.getVendor', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#vendor-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.name_vendor}</option>`
                    });
                    $('#vendor-id').html(_temp + options)
                    $('#vendor-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#vendor-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getEquipmentLocation(hospitalId) {
            let url = '{{ route('api.getEquipmentLocation', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#equipment-location-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.location_name}</option>`
                    });
                    $('#equipment-location-id').html(_temp + options)
                    $('#equipment-location-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#equipment-location-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>

    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input required type="text" name="name_fittings[]" placeholder="" class="form-control " /></td><td><input required style="" type="number" name="qty[]" placeholder="" class="form-control " /></td><td><input required style="" type="file" name="equipment_fittings[]" placeholder="" class="form-control " /></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>'
                );
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
            $(document).on('click', '.btn_remove_data', function() {
                var bid = this.id;
                var trid = $(this).closest('tr').attr('id');
                $('#' + trid + '').remove();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas2').click(function() {
                i++;
                $('#dynamic_field2').append('<tr id="row2' + i +
                    '"><td><input required type="text" name="name_file[]" placeholder="" class="form-control " /></td><td><input type="file" name="file[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove2"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>'
                );
            });

            $(document).on('click', '.btn_remove2', function() {
                var button_id = $(this).attr("id");
                $('#row2' + button_id + '').remove();
            });

            $(document).on('click', '.btn_remove2', function() {
                var bid = this.id;
                var trid = $(this).closest('tr').attr('id');
                $('#' + trid + '').remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas3').click(function() {
                i++;
                $('#dynamic_field3').append('<tr id="row3' + i +
                    '"><td><input required type="text" name="name_photo[]" placeholder="" class="form-control " /></td><td><input type="file" name="file_photo_eq[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
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
