<!DOCTYPE html>
<html>

<head>
    <title>Stock History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <table style="line-height: 18px">
        <tr>
            <td style="width: 120px; margin-top:0px">
                <img src="../public/storage/uploads/logos/{{ $hospital->logo }}" style="width: 100%">
            </td>
            <td>
                <br>
                <center>
                    <h2>{{ $hospital->name }}</h2>
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
        <h5 style="margin-left: 10px">I. Detail Sparepart {{ $sparepart->sparepart_name }}</h5>
        <table class="table table-sm table-borderless" style="line-height: 14px; margin-left: 25px">
            <tr>
                <td style="width: 150px">Barcode</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->barcode }}</td>
            </tr>
            <tr>
                <td>Sparepart Name</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->barcode }}</td>
            </tr>
            <tr>
                <td>Merk</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->sparepart_name }}</td>
            </tr>
            <tr>
                <td>Sparepart Type</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->merk }}</td>
            </tr>
            <tr>
                <td>Perkiraan Harga</td>
                <td style="width: 2px">:</td>
                <td>{{ rupiah($sparepart->estimated_price) }}</td>
            </tr>
            <tr>
                <td>Stock Opname</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->opname }}</td>
            </tr>
            <tr>
                <td>Stock</td>
                <td style="width: 2px">:</td>
                <td>{{ $sparepart->stock }}</td>
            </tr>
        </table>
        <h5 style="margin-left: 10px">II. Stock History {{ $sparepart->sparepart_name }}</h5>
        <table class="table table-bordered" style="line-height: 14px; margin-left: 25px;margin-left: 5px">
            @php
                $sparepart_trace = DB::table('sparepart_trace')
                    ->where('sparepart_id', '=', $sparepart->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            @endphp

            <thead>
                <tr>
                    <th>No Referensi</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Note</th>
                    <th>Date</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
