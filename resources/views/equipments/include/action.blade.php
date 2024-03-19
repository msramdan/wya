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
                                <td style="text-align: center;">
                                    <b>SN : {{ $model->serial_number }}</b> <br>
                                    <b>{{ $model->equipment_location->location_name }}</b>
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
                <a href="{{ route('print_qr_equipment', $model->id) }}" target="_blank" class="btn btn-danger ">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Print</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('inventory/equipment/index.depreciation_tabel') }} {{ $model->metode }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm dataTables-example">
                    <thead>
                        <th>{{ trans('inventory/equipment/index.period') }}</th>
                        <th>{{ trans('inventory/equipment/index.accu_depreciation') }}</th>
                        <th>{{ trans('inventory/equipment/index.book_value') }}</th>
                    </thead>
                    <tbody>
                        @if ($model->metode == 'Garis Lurus')
                            @php
                                $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($model->tgl_pembelian)));
                                $penambahan = '+' . $model->masa_manfaat . ' year';
                                $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($model->tgl_pembelian)));
                                $x = ($model->nilai_perolehan - $model->nilai_residu) / $model->masa_manfaat;
                                $i = 0;
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
                        @else
                            @php
                                $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($model->tgl_pembelian)));
                                $penambahan = '+' . $model->masa_manfaat . ' year';
                                $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($model->tgl_pembelian)));
                                $PersentasePenyusutan = (2 * (100 / $model->masa_manfaat)) / 100; // 0.5
                                $awalPenyusutan = ($PersentasePenyusutan * $model->nilai_perolehan) / 12;
                                $totalPenyusutan = 0;
                                $perolehan = $model->nilai_perolehan;
                                $nilaiBukuSekarang = $perolehan;
                                $i = substr($tgl_awal, 5, 2) - 1;

                            @endphp
                            @while ($tgl_awal <= $end_tgl)
                                <tr>
                                    <td>{{ $tgl_awal }}</td>
                                    <td>{{ rupiah(round($totalPenyusutan, 3)) }}</td>
                                    <td>{{ rupiah(round($nilaiBukuSekarang, 3)) }} </td>
                                </tr>
                                @php
                                    $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                                    $i++;
                                    if ($i > 12) {
                                        $awalPenyusutan = ($PersentasePenyusutan * $nilaiBukuSekarang) / 12;
                                        $nilaiBukuSekarang = $nilaiBukuSekarang - $awalPenyusutan;
                                        $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                                        $i = 1;
                                    } else {
                                        $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                                        $nilaiBukuSekarang = $perolehan - $totalPenyusutan;
                                    }
                                @endphp
                            @endwhile
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" id="download" href="{{ route('print_penyusutan', $model->id) }}"
                    target="_blank"><i class="ace-icon fa fa-print"></i>
                    Print</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal History WO -->
<div class="modal fade" id="table-history{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('inventory/equipment/index.title_history') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm dataTables-example">
                    <thead>
                        <th>{{ trans('inventory/equipment/index.wo_number') }}</th>
                        <th>{{ trans('inventory/equipment/index.type') }}</th>
                        <th>{{ trans('inventory/equipment/index.category') }}</th>
                        <th>{{ trans('inventory/equipment/index.filed_date') }}</th>
                        <th>{{ trans('inventory/equipment/index.schedule_date') }}</th>
                        <th>{{ trans('inventory/equipment/index.work_date') }}</th>
                        <th>{{ trans('inventory/equipment/index.executor') }}</th>
                    </thead>
                    @php
                        $data = DB::table('work_order_processes')
                            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                            ->where('work_orders.equipment_id', $model->id)
                            ->where('work_order_processes.status', 'finished')
                            ->select(
                                'work_order_processes.executor',
                                'work_order_processes.schedule_date',
                                'work_order_processes.work_date',
                                'work_orders.filed_date',
                                'work_orders.wo_number',
                                'work_orders.type_wo',
                                'work_orders.category_wo',
                            )
                            ->get();
                    @endphp
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->wo_number }}</td>
                                <td>{{ $row->type_wo }}</td>
                                <td>{{ $row->category_wo }}</td>
                                <td>{{ $row->filed_date }}</td>
                                <td>{{ $row->schedule_date }}</td>
                                <td>{{ $row->work_date }}</td>
                                @if ($row->executor == 'technician')
                                    <td>Teknisi</td>
                                @else
                                    <td>Vendor</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('print_history_equipment', $model->id) }}" type="button" class="btn btn-danger"
                    target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal History LOAN -->
<div class="modal fade" id="table-loan{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('inventory/equipment/index.title_loan') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm dataTables-example2">
                    <thead>
                        <th>{{ trans('inventory/equipment/index.no_peminjaman') }}</th>
                        <th>{{ trans('inventory/equipment/index.lokasi_asal') }}</th>
                        <th>{{ trans('inventory/equipment/index.lokasi_tujuan') }}</th>
                        <th>{{ trans('inventory/equipment/index.waktu') }}</th>
                        <th>{{ trans('inventory/equipment/index.status') }}</th>
                        <th>{{ trans('inventory/equipment/index.penangung_jawab') }}</th>
                        <th style="width: 5%">Detail</th>
                    </thead>
                    @php
                        $data = DB::table('loans')
                            ->select(
                                'loans.*',
                                'equipment.barcode',
                                'hospitals.name as hospital_name',
                                'el1.code_location as resource_location',
                                'el2.code_location as destination_location',
                                'uc.name as user_created_name',
                                'uu.name as user_updated_name',
                            )
                            ->leftJoin('equipment', 'loans.equipment_id', '=', 'equipment.id')
                            ->leftJoin('hospitals', 'loans.hospital_id', '=', 'hospitals.id')
                            ->leftJoin('equipment_locations as el1', 'loans.lokasi_asal_id', '=', 'el1.id')
                            ->leftJoin('equipment_locations as el2', 'loans.lokasi_peminjam_id', '=', 'el2.id')
                            ->leftJoin('users as uc', 'loans.user_created', '=', 'uc.id')
                            ->leftJoin('users as uu', 'loans.user_updated', '=', 'uu.id')
                            ->where('loans.equipment_id', $model->id)
                            ->get();
                    @endphp
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->no_peminjaman }}</td>
                                <td>{{ $row->resource_location }}</td>
                                <td>{{ $row->destination_location }}</td>
                                <td>{{ $row->waktu_pinjam }}</td>
                                <td>
                                    @if ($row->status_peminjaman == 'Sudah dikembalikan')
                                        <button class="btn btn-success  btn-sm">{{ __('Sudah dikembalikan') }}</button>
                                    @elseif($row->status_peminjaman == 'Belum dikembalikan')
                                        <button class="btn btn-danger btn-sm">{{ __('Belum dikembalikan') }}</button>
                                    @endif
                                </td>
                                <td>{{ $row->pic_penanggungjawab }}</td>
                                <td> <a href="{{ route('loans.show', $row->id) }}" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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
                    data-bs-target="#detailEquipment{{ $model->id }}" id="view_gambar"
                    data-photo="{{ $model->photo }}" data-id="{{ $model->id }}">
                    Detail
                </a>
            </li>
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#qrcode-equipment{{ $model->id }}">
                    QR Code
                </a>
            </li>
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#table-history{{ $model->id }}">
                    History WO Peralatan
                </a>
            </li>
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#table-loan{{ $model->id }}">
                    History Peminjaman
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th style="width: 200px">{{ trans('inventory/equipment/index.barcode') }}</th>
                        <td>{{ $model->barcode }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.nomenklatur') }}</th>
                        <td>{{ $model->nomenklatur->name_nomenklatur }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.category') }}</th>
                        <td>{{ $model->equipment_category->category_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.manufacture') }}</th>
                        <td>{{ $model->manufacturer }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.type') }}</th>
                        <td>{{ $model->type }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.serial_number') }}</th>
                        <td>{{ $model->serial_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.vendor') }}</th>
                        <td>{{ $model->vendor->name_vendor }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.condition') }}</th>
                        <td>{{ $model->condition }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.risk_level') }}</th>
                        <td>{{ $model->risk_level }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.location') }}</th>
                        <td>{{ $model->equipment_location->location_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.financing_code') }}</th>
                        <td>{{ $model->financing_code }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.purchase_date') }}</th>
                        <td>{{ $model->tgl_pembelian }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.method') }}</th>
                        <td>{{ $model->metode }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.aq_value') }}</th>
                        <td>{{ rupiah($model->nilai_perolehan) }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.rsd_value') }}</th>
                        <td>{{ rupiah($model->nilai_residu) }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('inventory/equipment/index.useful') }}</th>
                        <td>{{ $model->masa_manfaat }} Tahun</td>
                    </tr>

                    <tr>
                        <th>{{ trans('inventory/equipment/form.photo') }}</th>
                        <td><img class="img-thumbnail" src="" id="photo_alat_modal{{ $model->id }}"
                                style="width: 100%;margin:0px" /></td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('print_history_equipment', $model->id) }}" type="button" class="btn btn-danger"
                    target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    $('.dataTables-example').DataTable();
    $('.dataTables-example2').DataTable();
</script>
