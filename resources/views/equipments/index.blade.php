@extends('layouts.app')

@section('title', __('Equipments'))

@push('css')
@endpush
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('inventory/equipment/index.import') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('action-import-equipment') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" accept=".xlsx" class="form-control" id="import_equipment"
                                name="import_equipment" aria-describedby="import_equipment" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download"
                                        aria-hidden="true"></i> {{ trans('inventory/equipment/index.download') }}</a> </div>
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
                        <h4 class="mb-sm-0">{{ trans('inventory/equipment/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ trans('inventory/equipment/index.head') }}</li>
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
                                        class="mdi mdi-plus"></i> {{ trans('inventory/equipment/index.create') }}</a>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('Export') }}
                            </button>
                            @if (Auth::user()->roles->first()->hospital_id)
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                    {{ trans('inventory/equipment/index.import') }}
                                </button>
                            @endif
                        </div>

                        <div class="card-body">

                            <div class="row">
                                @if (!Auth::user()->roles->first()->hospital_id)
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-control js-example-basic-multiple">
                                                <option value="">--
                                                    {{ trans('inventory/equipment/index.filter_hospital') }} --</option>
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
                                            <option value="" selected>--
                                                {{ trans('inventory/equipment/index.filter_location') }} --
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input readonly name="equipment_id" value="{{ $equipment_id }}"
                                                    id="equipment_id" type="text" class="form-control"
                                                    placeholder="Search Equipment by QR"
                                                    aria-label="Recipient's username">
                                                <button onclick="showQrScanner()" class="btn btn-primary"
                                                    type="submit"><i class="fa fa-qrcode"></i></button> &nbsp;

                                                @if ($equipment_id != null || $equipment_id != '')
                                                    <a href="/panel/equipment" class="btn btn-warning" type="submit">
                                                        Clear</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    {{ trans('inventory/equipment/index.total') }} : <h4><span id="hitungAsset"></span>
                                    </h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @if (!Auth::user()->roles->first()->hospital_id)
                                                <th>{{ trans('inventory/equipment/index.hospital') }}</th>
                                            @endif
                                            <th>{{ trans('inventory/equipment/index.barcode') }}</th>
                                            <th>{{ trans('inventory/equipment/index.nomenklatur') }}</th>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ trans('inventory/equipment/index.category') }}</th>
                                            <th>{{ trans('inventory/equipment/index.manufacture') }}</th>
                                            <th>{{ trans('inventory/equipment/index.type') }}</th>
                                            <th>{{ trans('inventory/equipment/index.location') }}</th>
                                            <th>{{ trans('inventory/equipment/index.book_value') }}</th>
                                            <th>{{ trans('inventory/equipment/index.action') }}</th>
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

@push('css-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.css"
        integrity="sha512-b6CPl1eORfMoZgwWGEYWNxYv79KG0dALXfVu4uReZJOXAfkINSK4UhA0ELwGcBBY7VJN7sykwrCGQnbS8qTKhQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"
        integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script type="text/javascript">
        $(document).on('click', '#view_gambar', function() {
            var id = $(this).data('id');
            var photo = $(this).data('photo');
            $('#photo_alat_modal' + id).attr("src", "../../../storage/img/equipment/" + photo);
        })
    </script>

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
            @if (!Auth::user()->roles->first()->hospital_id)
                {
                    data: 'hospital',
                    name: 'hospital.name',
                },
            @endif {
                data: 'barcode',
                name: 'barcode',
            },
            {
                data: 'nomenklatur',
                name: 'nomenklatur.name_nomenklatur'
            },
            {
                data: 'serial_number',
                name: 'serial_number',
            },
            {
                data: 'equipment_category',
                name: 'equipment_category.category_name'
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
                    s.equipment_id = $('#equipment_id').val()
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

    <script>
        function showQrScanner() {
            const modalScanner = new bootstrap.Modal(document.getElementById('modalScanner'));
            modalScanner.show()

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "camera-scanner", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render((decodedText, decodedResult) => {
                fetch('{{ url('/') }}/api/equipments/' + decodedText + '/barcode')
                    .then((res) => res.json())
                    .then((response) => {
                        const data = response.data;
                        modalScanner.hide();
                        html5QrcodeScanner.clear();
                        top.location.href = '../panel/equipment?id=' + data.id;
                    });
            });
        }
    </script>
@endpush
