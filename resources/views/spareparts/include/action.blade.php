<td>
    @can('sparepart edit')
        <a href="{{ route('spareparts.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('sparepart delete')
        <form action="{{ route('spareparts.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
    @canany(['download qr', 'sparepart stock in', 'sparepart stock out', 'sparepart history'])
        <div class="btn-group">
            <button class="btn btn-md btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-cog"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @can('download qr')
                    <li>
                        <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#exampleModalStockQr{{ $model->id }}">
                            QR Code
                        </a>
                    </li>
                @endcan
                @can('sparepart stock in')
                    <li>
                        <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#exampleModalStockIn{{ $model->id }}">
                            Stock In
                        </a>
                    </li>
                @endcan
                @can('sparepart stock out')
                    <li>
                        <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#exampleModalStockOut{{ $model->id }}">
                            Stock Out
                        </a>
                    </li>
                @endcan
                @can('sparepart history')
                    <li>
                        <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#exampleModalStockHistory{{ $model->id }}">
                            Stock History
                        </a>

                    </li>
                @endcan
            </ul>
        </div>
    @endcanany

    {{-- download qr --}}
    <div class="modal fade" id="exampleModalStockQr{{ $model->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $sparepart = DB::table('spareparts')
                            ->where('id', '=', $model->id)
                            ->first();
                    @endphp
                    <center>
                        <table style="padding: 5px">
                            <thead>
                                <tr>
                                    <td style="padding: 5px">{!! QrCode::size(150)->generate($model->barcode) !!}</td>
                                </tr>
                            </thead>
                        </table>
                        @if (setting_web()->logo != null)
                            <img style="width: 30%"
                                src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                alt="">
                        @endif
                    </center>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('print_qr', $model->barcode) }}" target="_blank" class="btn btn-danger "> <i
                            class="fa fa-print" aria-hidden="true"></i>
                        Print</a>
                </div>
            </div>
        </div>
    </div>

    {{-- modal stok in  --}}
    <div class="modal fade" id="exampleModalStockIn{{ $model->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Stock In : {{ $sparepart->sparepart_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stok_in') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="qty" class="form-label">Qty Stok In</label>
                            <input type="number" name="qty" class="form-control" id="qty" required>
                            <input type="hidden" name="sparepart_id" value="{{ $model->id }}" class="form-control"
                                id="" required>
                        </div>
                        <div class="mb-2">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" name="note" id="note" cols="4" rows="3" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="mdi mdi-arrow-left-thin"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                            Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal stok out --}}
    <div class="modal fade" id="exampleModalStockOut{{ $model->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Stock Out : {{ $sparepart->sparepart_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stok_out') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="qty" class="form-label">Qty Stok Out</label>
                            <input type="number" name="qty" class="form-control" id="qty" required>
                            <input type="hidden" name="sparepart_id" value="{{ $model->id }}"
                                class="form-control" id="sparepart_id" required>
                        </div>
                        <div class="mb-2">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" name="note" id="note" cols="4" rows="3" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="mdi mdi-arrow-left-thin"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                            Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal history --}}
    <div class="modal fade" id="exampleModalStockHistory{{ $model->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Stock History : {{ $sparepart->sparepart_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $sparepart_trace = DB::table('sparepart_trace')
                            ->where('sparepart_id', '=', $model->id)
                            ->orderBy('id', 'DESC')
                            ->get();
                    @endphp
                    <table class="table table-hover table-bordered table-sm dataTables-example">
                        <thead>
                            <tr>
                                <th>No Referensi</th>
                                <th>Type</th>
                                <th>Qty</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sparepart_trace as $row)
                                <tr>
                                    <th>{{ $row->no_referensi }}</th>
                                    <td>{{ $row->type }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->note }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <form action="{{ route('delete_history', $row->id) }}" method="post"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure to delete this record?')">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="mdi mdi-arrow-left-thin"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
</td>

{{-- <script>
    $('.dataTables-example').DataTable();
</script> --}}
