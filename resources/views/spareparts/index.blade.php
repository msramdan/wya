@extends('layouts.app')

@section('title', __('Spareparts'))

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('inventory/sparepart/index.import_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('action-import-sparepart') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_sparepart" name="import_sparepart"
                                aria-describedby="import_sparepart" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download"
                                        aria-hidden="true"></i> {{ trans('inventory/sparepart/index.download_format') }}</a>
                            </div>
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
                        <h4 class="mb-sm-0">Sparepart</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sparepart</li>
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
                            @can('sparepart create')
                                <a href="{{ route('spareparts.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> Tambah</a>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ trans('inventory/sparepart/index.export') }}
                            </button>

                            @if (session('sessionHospital'))
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                    {{ __('Import') }}
                                </button>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    {{ trans('inventory/sparepart/index.total') }} : <h4><span id="hitungAsset"></span>
                                    </h4>
                                </div>
                            </div>

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('inventory/sparepart/index.barcode') }}</th>
                                            <th>Nama Sparepart</th>
                                            <th>{{ trans('inventory/sparepart/index.merk') }}</th>
                                            <th>Jenis Sparepart</th>
                                            <th>{{ trans('inventory/sparepart/index.estimated_price') }}</th>
                                            <th>{{ trans('inventory/sparepart/index.opname') }}</th>
                                            <th>{{ trans('inventory/sparepart/index.stock') }}</th>
                                            <th>Unit Item</th>
                                            <th>{{ trans('inventory/sparepart/index.action') }}</th>
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
            var cek = {{ session('sessionHospital') }}
            var url = '../panel/totalAssetPart';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    id: cek,
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
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'barcode',
                name: 'barcode',
            },
            {
                data: 'sparepart_name',
                name: 'sparepart_name',
            },
            {
                data: 'merk',
                name: 'merk',
            },
            {
                data: 'sparepart_type',
                name: 'sparepart_type',
            },

            {
                data: 'estimated_price',
                name: 'estimated_price',
            },
            {
                data: 'opname',
                name: 'opname',
            },
            {
                data: 'stock',
                name: 'stock',
            },
            {
                data: 'unit_item',
                name: 'unit_item.code_unit'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('spareparts.index') }}",
                data: function(s) {
                    s.hospital_id = $('select[name=hospital_id] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        $('#hospital_id').change(function() {
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
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                () => {},
                (dismiss) => {
                    if (dismiss === 'timer') {
                        // console.log('closed by timer!!!!');
                        swal({
                            title: 'Finished!',
                            type: 'success',
                            timer: 10000,
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
            var url = '../panel/export-data-spareparts';
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
                    var nameFile = 'Daftar-Sparepart.xlsx'
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
            var url = '../panel/download-format-sparepart';
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
                    var nameFile = 'import_sparepart.xlsx'
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
