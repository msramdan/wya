<!DOCTYPE html>
<html>

<head>
    <title>Equipment History</title>
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
        <h5 style="margin-left: 10px">I. Detail Equipment {{ $equipment->sparepart_name }}</h5>
        <table class="table table-sm table-borderless" style="line-height: 14px; margin-left: 25px">
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
        </table>
        <h5 style="margin-left: 10px">II. Equipment History {{ $equipment->sparepart_name }}</h5>
        <table class="table table-bordered" style="line-height: 14px; margin-left: 25px;margin-left: 5px">
            <thead>
                <th>WO Number</th>
                <th>Type</th>
                <th>Category</th>
                <th>Filed Date</th>
                <th>Schedule Date</th>
                <th>Work Date</th>
                <th>Executor</th>
            </thead>
            @php
                $data = DB::table('work_order_processes')
                    ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                    ->where('work_orders.equipment_id', $equipment->id)
                    ->where('work_order_processes.status', 'finished')
                    ->select('work_order_processes.executor', 'work_order_processes.schedule_date', 'work_order_processes.work_date', 'work_orders.filed_date', 'work_orders.wo_number', 'work_orders.type_wo', 'work_orders.category_wo')
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


</body>

</html>
