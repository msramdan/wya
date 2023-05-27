@extends('layouts.app')

@section('title', __('Equipments'))

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('action-import-equipment') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" accept=".xlsx" class="form-control" id="import_equipment"
                                name="import_equipment" aria-describedby="import_equipment" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download Format</a> </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Equipments') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Equipments') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('equipment create')
                                <a href="{{ route('equipment.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new equipment') }}</a>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('Export') }}
                            </button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                {{ __('Import') }}
                            </button>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                @if (!Auth::user()->roles->first()->hospital_id)
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-control js-example-basic-multiple">
                                                <option value="">-- Filter Hospital --</option>
                                                @foreach ($hispotals as $hispotal)
                                                    <option value="{{ $hispotal->id }}"
                                                        {{ isset($equipments) && $equipments->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                                        {{ $hispotal->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3 mb-2">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <select
                                            class="form-control js-example-basic-multiple @error('equipment_location_id') is-invalid @enderror"
                                            name="equipment_location_id" id="equipment_location_id" required>
                                            <option value="" selected>-- {{ __('Select location') }} --
                                            </option>
                                            {{-- @foreach ($equipmentLocations as $equipmentLocation)
                                                <option value="{{ $equipmentLocation->id }}"
                                                    {{ isset($equipment) && $equipment->equipment_location_id == $equipmentLocation->id ? 'selected' : (old('equipment_location_id') == $equipmentLocation->id ? 'selected' : '') }}>
                                                    {{ $equipmentLocation->location_name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    Total Nilai Buku Bulan Berjalan : <h4><span id="hitungAsset"></span></h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Hospital') }}</th>
                                            <th>{{ __('Barcode') }}</th>
                                            <th>{{ __('Nomenklatur') }}</th>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('Manufacturer') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Niali Buku') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
            hitungAsset()
        });

        function hitungAsset() {
            var cek = $('#hospital_id').val()
            var equipment_location_id = $('#equipment_location_id').val()
            var url = '../panel/totalAsset';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    id: cek,
                    equipment_location_id: equipment_location_id,
                },
                success: function(data) {
                    $('#hitungAsset').text(data)
                },
                error: function(data) {
                    console.log('ada error kaka')
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            var cek = $('#hospital_id').val()
            console.log(cek)
            if (typeof cek === "undefined") {
                getEquipmentLocation({{ Auth::user()->roles->first()->hospital_id }});
            }
        });

        const _temp = '<option value="" selected>-- Select location --</option>';
        $('#hospital_id').change(function() {
            $('#equipment_location_id').html(_temp);
            if ($(this).val() != "") {
                getEquipmentLocation($(this).val());
            }
        })

        function getEquipmentLocation(hospitalId) {
            let url = '{{ route('api.getEquipmentLocation', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#equipment_location_id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.location_name}</option>`
                    });
                    $('#equipment_location_id').html(_temp + options)
                    $('#equipment_location_id').prop('disabled', false);
                },
                error: function(err) {
                    $('#equipment_location_id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'hospital',
                name: 'hospital',
            },
            {
                data: 'barcode',
                name: 'barcode',
            },
            {
                data: 'nomenklatur',
                name: 'nomenklatur.code_nomenklatur'
            },
            {
                data: 'serial_number',
                name: 'serial_number',
            },
            {
                data: 'equipment_category',
                name: 'equipment_category.code_categoty'
            },
            {
                data: 'manufacturer',
                name: 'manufacturer',
            },
            {
                data: 'type',
                name: 'type',
            },
            {
                data: 'equipment_location',
                name: 'equipment_location.code_location'
            },
            {
                data: 'nilai_buku',
                name: 'nilai_buku'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('equipment.index') }}",
                data: function(s) {
                    s.hospital_id = $('select[name=hospital_id] option').filter(':selected').val()
                    s.equipment_location_id = $('select[name=equipment_location_id] option').filter(':selected')
                        .val()
                }
            },
            columns: columns
        })
        $('#hospital_id').change(function() {
            table.draw();
            hitungAsset()
        })

        $('#equipment_location_id').change(function() {
            table.draw();
            hitungAsset()
        })
    </script>
    <script>
        const showLoading = function() {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                () => {},
                (dismiss) => {
                    if (dismiss === 'timer') {
                        console.log('closed by timer!!!!');
                        swal({
                            title: 'Finished!',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                }
            )
        };

        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();

        });
        var exportData = function() {
            var url = '../panel/export-data-equipment';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan proses export data', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'Daftar-Equipment.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Data export failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
    <script>
        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();

        });

        var downloadFormat = function() {
            var url = '../panel/download-format-equipment';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan download format import',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'import_equipment.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Download Format Import failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
