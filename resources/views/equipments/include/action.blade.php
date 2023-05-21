<td>
    @can('equipment edit')
        <a href="{{ route('equipment.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('equipment delete')
        <form action="{{ route('equipment.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan

    {{-- @canany(['download qr', 'sparepart stock in', 'sparepart stock out', 'sparepart history']) --}}
    <div class="btn-group">
        <button class="btn btn-md btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-cog"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#detailEquipment{{ $model->id }}">
                    Detail
                </a>
            </li>
            {{-- <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#detailEquipment{{ $model->id }}">
                    Cetak
                </a>
            </li> --}}
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#qrcode-equipment{{ $model->id }}">
                    QR Code
                </a>
            </li>
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#table-penyusutan{{ $model->id }}">
                    Tabel Penyusutan
                </a>
            </li>
        </ul>
    </div>
    {{-- @endcanany --}}


</td>

<!-- Modal Detail -->
<div class="modal fade" id="detailEquipment{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Barcode</th>
                        <td>{{ $model->barcode }}</td>
                    </tr>
                    <tr>
                        <th>Nomenklatur</th>
                        <td>{{ $model->nomenklatur->name_nomenklatur }}
                        </td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $model->equipment_category->category_name }}</td>
                    </tr>
                    <tr>
                        <th>Manufacturer</th>
                        <td>{{ $model->manufacturer }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ $model->type }}</td>
                    </tr>
                    <tr>
                        <th>Serial Number</th>
                        <td>{{ $model->serial_number }}</td>
                    </tr>
                    <tr>
                        <th>Vendor</th>
                        <td>{{ $model->vendor->name_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Condition</th>
                        <td>{{ $model->condition }}</td>
                    </tr>
                    <tr>
                        <th>Risk Level</th>
                        <td>{{ $model->risk_level }}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{ $model->equipment_location->location_name }}</td>
                    </tr>
                    <tr>
                        <th>Financing Code</th>
                        <td>{{ $model->financing_code }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pembelian</th>
                        <td>{{ $model->tgl_pembelian }}</td>
                    </tr>
                    <tr>
                        <th>Metode</th>
                        <td>{{ $model->metode }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Perolehan</th>
                        <td>{{ rupiah($model->nilai_perolehan) }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Residu</th>
                        <td>{{ rupiah($model->nilai_residu) }}</td>
                    </tr>
                    <tr>
                        <th>Masa Manfaat (Tahun)</th>
                        <td>{{ $model->masa_manfaat }} Tahun</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="qrcode-equipment{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <table style="padding: 5px">
                        <thead>
                            <tr>
                                <td style="padding: 5px">{!! QrCode::size(150)->generate($model->barcode) !!}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"> <b>{{ $model->equipment_location->location_name }}</b>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    @if (setting_web()->logo != null)
                        <img style="width: 30%"
                            src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}" alt="">
                    @endif
                </center>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('print_qr_equipment', $model->id) }}" target="_blank" class="btn btn-danger ">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Print</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penyusutan -->
<div class="modal fade" id="table-penyusutan{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Table Penyusutan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm dataTables-example">
                    <thead>
                        <th>Periode</th>
                        <th>Akumulasi Penyusutan</th>
                        <th>Nilai Buku</th>
                    </thead>
                    <tbody>
                        @php
                            $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($model->tgl_pembelian)));
                            $penambahan = '+' . $model->masa_manfaat . ' year';
                            $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($model->tgl_pembelian)));
                            $x = ($model->nilai_perolehan - $model->nilai_residu) / $model->masa_manfaat;
                            $i = 1;
                        @endphp
                        @while ($tgl_awal <= $end_tgl)
                            <tr>
                                <td>{{ $tgl_awal }}</td>
                                <td>{{ rupiah(round(($i / 12) * $x, 3)) }}</td>
                                <td>{{ rupiah($model->nilai_perolehan - round(($i / 12) * $x, 3)) }} </td>
                            </tr>
                            @php
                                $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                                $i++;
                            @endphp
                        @endwhile
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.dataTables-example').DataTable();
</script>
