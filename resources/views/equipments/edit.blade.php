@extends('layouts.app')

@section('title', __('Edit Equipments'))

@section('content')


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Equipments') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('equipment.index') }}">{{ __('Equipments') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
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
                            <form action="{{ route('equipment.update', $equipment->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('equipments.include.form_edit')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Update') }}</button>
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

    <script type="text/javascript">
        $(document).on('click', '#view_photo_alat', function() {
            var photo = $(this).data('photo');
            $('#modalPhotoAlat #photo_alat').attr("src", "../../../storage/img/equipment/" + photo);
            console.log(photo);
        })
    </script>

    <script type="text/javascript">
        $(document).on('click', '#view_gambar', function() {
            var file = $(this).data('file');
            var name_file = $(this).data('name_file');
            $('#largeModal #file_vendor').attr("src", "../../../storage/img/file_equipment/" + file);
            $('#largeModal #name_file').text(name_file);
            // console.log(name_file);
        })
    </script>

    <script type="text/javascript">
        $(document).on('click', '#view_photo', function() {
            var photo = $(this).data('photo');
            var name_fittings = $(this).data('name_fittings');
            $('#largeModalFittings #photo_fitting').attr("src", "../../../storage/img/equipment_fittings/" + photo);
            $('#largeModalFittings #name_fittings').text(name_fittings);
            // console.log(name_fittings);
        })
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input type="hidden" name="id_asal_fittings[]" value="" class="form-control " /><input required type="text" name="name_fittings[]" placeholder="" class="form-control " /></td><td><input required style="" type="number" name="qty[]" placeholder="" class="form-control " /></td><td><input required type="file" name="equipment_fittings[]" placeholder="" class="form-control " /></td><td><button type="button" name="remove" id="' +
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
                    '"><td><input type="hidden" name="id_asal_file[]" value="" class="form-control " /><input required type="text" name="name_file[]" placeholder="" class="form-control " /></td><td><input type="file" name="file[]" class="form-control" required="" /></td><td><button type="button" name="remove" id="' +
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
@endpush
