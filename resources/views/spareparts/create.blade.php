@extends('layouts.app')

@section('title', __('Create Spareparts'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Spareparts') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('spareparts.index') }}">{{ __('Spareparts') }}</a>
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
                            <form action="{{ route('spareparts.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('spareparts.include.form')

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
            if (cek != '' || cek != null) {
                getDataUnit(cek);
            }
        });

        const options_temp = '<option value="" selected disabled>-- Select unit item --</option>';
        $('#hospital_id').change(function() {
            $('#unit-id').html(options_temp);
            if ($(this).val() != "") {
                getDataUnit($(this).val());
            }
        })

        function getDataUnit(hospitalId) {
            let url = '{{ route('api.getUnit', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#unit-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.unit_name}</option>`
                    });
                    $('#unit-id').html(options_temp + options)
                    $('#unit-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#unit-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>
@endpush
