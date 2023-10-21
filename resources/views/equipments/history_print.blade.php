<!DOCTYPE html>
<html>

<head>
    <title>Equipment History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    /* Container untuk kartu-kartu */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        /* Atur gaya lainnya sesuai kebutuhan */
        /* margin: 20px; */
    }

    /* Gaya untuk setiap kartu */
    .card {
        flex: 0 0 calc(33.33% - 10px);
        /* Tiga kartu per baris dengan margin */
        box-sizing: border-box;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        width: 100%
    }

    /* Gaya untuk header kartu */
    .card-header {
        background-color: #f1f1f1;
        text-align: center;
    }
    .card-content {
        height: 390px;
    }

    .page-break {
      page-break-before: always;
    }
</style>


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


        <h6 style="margin-left: 10px">II. Equipment Fittings</h5>
            <table class="table table-bordered"
                style="line-height: 4px;margin-left: 25px;margin-left: 5px; font-size:12px; width:100%">
                <thead>
                    <th style="width: 45%">Fitting Name</th>
                    <th>Qty</th>
                </thead>
                @php
                    $dataEquipment = DB::table('equipment_fittings')
                        ->where('equipment_id', $equipment->id)
                        ->get();
                @endphp
                <tbody>
                    @forelse ($dataEquipment as $row)
                        <tr>
                            <td>{{ $row->name_fittings }}</td>
                            <td>{{ $row->qty }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <h6 style="margin-left: 10px">III. Calibration History</h6>
            <table class="table table-bordered" style="line-height: 4px; margin-left: 5px;font-size:11px;width:100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;" rowspan="2">WO Number</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Category</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Work Date</th>
                        <th style="width: 55%;text-align: center;" colspan="3">Expense Cost</th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align: center;">Calibration</th>
                        <th style="width: 20%;text-align: center;">Services</th>
                        <th style="width: 20%;text-align: center;">Replacement</th>
                    </tr>
                </thead>
                @php
                    $Calibration = DB::table('work_order_processes')
                        ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                        ->where('work_orders.equipment_id', $equipment->id)
                        ->where('work_order_processes.status', 'finished')
                        ->where('work_orders.type_wo', 'Calibration')
                        ->select('work_order_processes.id as ids', 'work_order_processes.work_date', 'work_order_processes.calibration_performance_calibration_price', 'work_order_processes.replacement_of_part_service_price', 'work_orders.wo_number', 'work_orders.type_wo', 'work_orders.category_wo')
                        ->get();
                @endphp
                <tbody>
                    @forelse ($Calibration as $row)
                        <tr>
                            <td>{{ $row->wo_number }}</td>
                            <td>{{ $row->category_wo }}</td>
                            <td>{{ $row->work_date }}</td>
                            <td>{{ rupiah($row->calibration_performance_calibration_price) }}</td>
                            <td>{{ rupiah($row->replacement_of_part_service_price) }}</td>
                            <td>{{ rupiah(ExpenseTable($row->ids)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <h6 style="margin-left: 10px">IV. Services History </h6>
            <table class="table table-bordered" style="line-height: 4px; margin-left: 5px;font-size:11px;width:100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;" rowspan="2">WO Number</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Category</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Work Date</th>
                        <th style="width: 55%;text-align: center;" colspan="3">Expense Cost</th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align: center;">Calibration</th>
                        <th style="width: 20%;text-align: center;">Services</th>
                        <th style="width: 20%;text-align: center;">Replacement</th>
                    </tr>
                </thead>
                @php
                    $Service = DB::table('work_order_processes')
                        ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                        ->where('work_orders.equipment_id', $equipment->id)
                        ->where('work_order_processes.status', 'finished')
                        ->where('work_orders.type_wo', 'Service')
                        ->select('work_order_processes.id as ids', 'work_order_processes.work_date', 'work_order_processes.calibration_performance_calibration_price', 'work_order_processes.replacement_of_part_service_price', 'work_orders.wo_number', 'work_orders.type_wo', 'work_orders.category_wo')
                        ->get();
                @endphp
                <tbody>
                    @forelse ($Service as $row)
                        <tr>
                            <td>{{ $row->wo_number }}</td>
                            <td>{{ $row->category_wo }}</td>
                            <td>{{ $row->work_date }}</td>
                            <td>{{ rupiah($row->calibration_performance_calibration_price) }}</td>
                            <td>{{ rupiah($row->replacement_of_part_service_price) }}</td>
                            <td>{{ rupiah(ExpenseTable($row->ids)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h6 style="margin-left: 10px">V. Traning History</h6>
            <table class="table table-bordered" style="line-height: 4px; margin-left: 5px;font-size:11px;width:100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;" rowspan="2">WO Number</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Category</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Work Date</th>
                        <th style="width: 55%;text-align: center;" colspan="3">Expense Cost</th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align: center;">Calibration</th>
                        <th style="width: 20%;text-align: center;">Services</th>
                        <th style="width: 20%;text-align: center;">Replacement</th>
                    </tr>
                </thead>
                @php
                    $Training = DB::table('work_order_processes')
                        ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                        ->where('work_orders.equipment_id', $equipment->id)
                        ->where('work_order_processes.status', 'finished')
                        ->where('work_orders.type_wo', 'Training')
                        ->select('work_order_processes.id as ids', 'work_order_processes.work_date', 'work_order_processes.calibration_performance_calibration_price', 'work_order_processes.replacement_of_part_service_price', 'work_orders.wo_number', 'work_orders.type_wo', 'work_orders.category_wo')
                        ->get();
                @endphp
                <tbody>
                    @forelse ($Training as $row)
                        <tr>
                            <td>{{ $row->wo_number }}</td>
                            <td>{{ $row->category_wo }}</td>
                            <td>{{ $row->work_date }}</td>
                            <td>{{ rupiah($row->calibration_performance_calibration_price) }}</td>
                            <td>{{ rupiah($row->replacement_of_part_service_price) }}</td>
                            <td>{{ rupiah(ExpenseTable($row->ids)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h6 style="margin-left: 10px">VI. History Inspection & Preventive Maintenance
            </h6>
            <table class="table table-bordered" style="line-height: 4px; margin-left: 5px;font-size:11px;width:100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;" rowspan="2">WO Number</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Category</th>
                        <th style="width: 15%;text-align: center;" rowspan="2">Work Date</th>
                        <th style="width: 55%;text-align: center;" colspan="3">Expense Cost</th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align: center;">Calibration</th>
                        <th style="width: 20%;text-align: center;">Services</th>
                        <th style="width: 20%;text-align: center;">Replacement</th>
                    </tr>
                </thead>
                @php
                    $ipm = DB::table('work_order_processes')
                        ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                        ->where('work_orders.equipment_id', $equipment->id)
                        ->where('work_order_processes.status', 'finished')
                        ->where('work_orders.type_wo', 'Inspection and Preventive Maintenance')
                        ->select('work_order_processes.id as ids', 'work_order_processes.work_date', 'work_order_processes.calibration_performance_calibration_price', 'work_order_processes.replacement_of_part_service_price', 'work_orders.wo_number', 'work_orders.type_wo', 'work_orders.category_wo')
                        ->get();
                @endphp
                <tbody>
                    @forelse ($ipm as $row)
                        <tr>
                            <td>{{ $row->wo_number }}</td>
                            <td>{{ $row->category_wo }}</td>
                            <td>{{ $row->work_date }}</td>
                            <td>{{ rupiah($row->calibration_performance_calibration_price) }}</td>
                            <td>{{ rupiah($row->replacement_of_part_service_price) }}</td>
                            <td>{{ rupiah(ExpenseTable($row->ids)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
    <div class="page-break"></div>
    <center>
        <h3>Lampiran Lampiran</h3>
        <hr>
    </center>
    <div class="card-container" style="100%">
        @foreach ( $photo as $q )
        <div class="card">
            <div class="card-header">
                <span style="font-size: 18px"><b>{{ $q->name_photo }}</b></span>
            </div>
            <div class="card-content">
                <center>
                    <img style="border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 5px;
                    width:95%;
                    margin-top:10px;
                    height:90%;
                    "src="../public/storage/img/file_photo/{{ $q->photo }}">
                </center>

            </div>
        </div>
        @endforeach

    </div>
</body>

</html>
