<!DOCTYPE html>
<html>

<head>
    <title>Equipment History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>


<body>
    <table style="line-height: 16px; font-size:12px">
        <tr>
            <td style="width: 120px; margin-top:0px">
                <img src="../public/storage/uploads/logos/{{ $hospital->logo }}" style="width: 100%">
            </td>
            <td>
                <br>
                <center>
                    <h3>{{ $hospital->name }}</h3>
                    <span>{{ $hospital->address }} <br> Phone : {{ $hospital->phone }} - Email :
                        {{ $hospital->email }} </span>
                </center>
            </td>
        </tr>
    </table>
    <hr
        style="position: relative;
                    border: none;
                    height: 1px;
                    background: black;">
    <div>
        <img style="position: absolute;right: 40px;margin-top: 40px;border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 5px;
                    width:250px;"
            src="../public/storage/img/equipment/{{ $equipment->photo }}">
        <h6 style="margin-left: 10px">I. Detail Equipment {{ $equipment->sparepart_name }}</h6>
        <table class="table table-borderless table-sm" style="margin-left: 25px; font-size:12px">
            <tr>
                <td style="width: 150px">Barcode</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->barcode }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Manufacturer</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->manufacturer }}</td>
            </tr>
            <tr>
                <td>Type</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->type }}</td>
            </tr>
            <tr>
                <td>Condition</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->condition }}</td>
            </tr>
            <tr>
                <td>Risk Level</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->risk_level }}</td>
            </tr>
            <tr>
                <td>Location</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->equipment_location->location_name }}</td>
            </tr>
            <tr>
                <td>Category</td>
                <td style="width: 2px">:</td>
                <td>{{ $equipment->equipment_category->category_name }}</td>
            </tr>
            <tr>
                <td>QR</td>
                <td style="width: 2px">:</td>
                <td> <img style="width:70px;" src="data:image/png;base64, {!! base64_encode(QrCode::generate($equipment->barcode)) !!} ">
                </td>
            </tr>
        </table>


        <h6 style="margin-left: 10px">II. Depreciation Table</h5>
            <table style="margin-left: 25px; font-size:12px" class="table table-bordered table-sm">
                <thead>
                    <th>{{ trans('inventory/equipment/index.period') }}</th>
                    <th>{{ trans('inventory/equipment/index.accu_depreciation') }}</th>
                    <th>{{ trans('inventory/equipment/index.book_value') }}</th>
                </thead>
                <tbody>
                    @if ($equipment->metode == 'Garis Lurus')
                        @php
                            $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($equipment->tgl_pembelian)));
                            $penambahan = '+' . $equipment->masa_manfaat . ' year';
                            $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($equipment->tgl_pembelian)));
                            $x = ($equipment->nilai_perolehan - $equipment->nilai_residu) / $equipment->masa_manfaat;
                            $i = 0;
                        @endphp
                        @while ($tgl_awal <= $end_tgl)
                            <tr>
                                <td>{{ $tgl_awal }}</td>
                                <td>{{ rupiah(round(($i / 12) * $x, 3)) }}</td>
                                <td>{{ rupiah($equipment->nilai_perolehan - round(($i / 12) * $x, 3)) }} </td>
                            </tr>
                            @php
                                $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                                $i++;
                            @endphp
                        @endwhile
                    @else
                        @php
                            $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($equipment->tgl_pembelian)));
                            $penambahan = '+' . $equipment->masa_manfaat . ' year';
                            $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($equipment->tgl_pembelian)));
                            $PersentasePenyusutan = (2 * (100 / $equipment->masa_manfaat)) / 100; // 0.5
                            $awalPenyusutan = ($PersentasePenyusutan * $equipment->nilai_perolehan) / 12;
                            $totalPenyusutan = 0;
                            $perolehan = $equipment->nilai_perolehan;
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


</body>

</html>
