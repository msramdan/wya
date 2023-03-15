@extends('layouts.app')

@section('title', __('Create Equipments'))

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
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input required type="text" name="name_fittings[]" placeholder="" class="form-control " /></td><td><input required style="" type="text" name="qty[]" placeholder="" class="form-control " /></td><td><input required style="" type="file" name="photo[]" placeholder="" class="form-control " /></td><td><button type="button" name="remove" id="' +
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
@endpush
