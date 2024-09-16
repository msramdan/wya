<style>
    @page {
        margin: 37.5px;
    }

    body {
        margin: 0px;
    }

    * {
        font-family: DejaVu Sans !important;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        line-height: 12px
    }

    td {
        border: 1px solid #000;
        height: 15px;
        font-size: .7rem;
        padding-left: 6px;
        padding-right: 6px;
        padding-top: 4px;
        padding-bottom: 4px;
    }

    td.cell-head {
        height: 30px;
        color: #FFF;
        text-align: center;
        font-size: .8rem;
    }

    .bg-primary {
        background: #84A3CF;
    }

    .bold {
        font-weight: bold;
    }

    .check {
        font-size: 1rem;
        margin-left: 2px;
        color: #000 !important;
    }
</style>

<table>
    <tr>
        <td style="max-width: 25%" colspan="3" rowspan="4">Nomor WO : <br>
            <b>{{ $workOrder->wo_number }}</b>
        </td>
        <td class="bold" style="max-width: 25%;" colspan="3">Inspection Preventive Maintenance

            @if ($workOrder->type_wo == 'Inspection and Preventive Maintenance')
                <span class="check">&#10004;</span>
            @endif
        </td>
        <td style="max-width: 25%" colspan="3" rowspan="4">{{ $equipment->name_nomenklatur }} |
            {{ $workOrder->equipment->manufacturer }} | {{ $workOrder->equipment->type }}</td>
        <td style="max-width: 25%" colspan="3">Tanggal: {{ $workOrderProcesess->work_date }}</td>
    </tr>
    <tr>
        <td class="bold" colspan="3">Kalibrasi

            @if ($workOrder->type_wo == 'Calibration')
                <span class="check">&#10004;</span>
            @endif

        </td>
        <td colspan="3" rowspan="3">
            <center>
                @if ($logo == null)
                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" width="200" height="150">
                @else
                    <img src="../public/storage/uploads/logos/{{ $logo }}" style="width: 95%">
                @endif
            </center>
        </td>
    </tr>
    <tr>
        <td class="bold" colspan="3">Service & Repair

            @if ($workOrder->type_wo == 'Service')
                <span class="check">&#10004;</span>
            @endif

        </td>
    </tr>
    <tr>
        <td class="bold" colspan="3">Training

            @if ($workOrder->type_wo == 'Training')
                <span class="check">&#10004;</span>
            @endif

        </td>
    </tr>
    <tr>
        {{-- <td colspan="6">Nama Institusi :
            @if ($workOrderProcesess->executor == 'technician')
                {{ $workOrderProcesess->workExecutorTechnician->name }}
            @else
                {{ $workOrderProcesess->workExecutorVendor->name_vendor }}
            @endif
        </td> --}}
        <td colspan="6">Nama Institusi :
            {{$hospital}}
        </td>
        <td colspan="6">Merk : {{ $workOrder->equipment->manufacturer }}</td>
    </tr>
    <tr>
        <td colspan="6">Lokasi Peralatan : {{ $workOrder->equipment->equipment_location->location_name }}</td>
        <td colspan="6">Type : {{ $workOrder->equipment->type }}</td>
    </tr>
    <tr>
        <td colspan="6">Merk/Type : {{ $workOrder->equipment->manufacturer }}/{{ $workOrder->equipment->type }}
        </td>
        <td colspan="6">SN Peralatan : {{ $workOrder->equipment->serial_number }}</td>
    </tr>
    <tr>
        <td colspan="6">No. Inventory : {{ $equipment->financing_code }}</td>
        <td colspan="6">Barcode : {{ $workOrder->equipment->barcode }}</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="12">Keluhan</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 75px; vertical-align: text-top">{{ $workOrder->note }}</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="6">Kondisi Lingkungan</td>
        <td class="cell-head bg-primary" colspan="6">Kondisi Kelistrikan</td>
    </tr>
    <tr>
        <td colspan="6">Suhu Ruangan : {{ $workOrderProcesess->final_temperature }} °C</td>
        <td colspan="6">Tegangan Jala-Jala : {{ $workOrderProcesess->mesh_voltage }} V</td>
    </tr>
    <tr>
        <td colspan="6">Kelembaban : {{ $workOrderProcesess->final_humidity }} %</td>
        <td colspan="6">UPS : {{ $workOrderProcesess->ups }} V</td>
    </tr>
    <tr>
        <td colspan="6">Lain-Lain :</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="6">Pemeriksaan Keamanan Listrik</td>
        <td class="cell-head bg-primary" colspan="6">Pemeriksaan Keamanan Lain</td>
    </tr>
    <tr>
        <td colspan="6">Grounding Resistence : {{ $workOrderProcesess->grounding }} Ω </td>
        <td colspan="6">Penempatan Alat :</td>
    </tr>
    <tr>
        <td colspan="6">Arus Bocor : {{ $workOrderProcesess->leakage_electric }} uA </td>
        <td colspan="6">Kondisi Roda/Trolly :</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="4">Pemeriksaan Kinerja Alat</td>
        <td class="cell-head bg-primary" colspan="2">Setting</td>
        <td class="cell-head bg-primary" colspan="3">Terukur</td>
        <td class="cell-head bg-primary" colspan="1">Nilai Acuan</td>
        <td class="cell-head bg-primary" colspan="1">Baik</td>
        <td class="cell-head bg-primary" colspan="1">Tidak</td>
    </tr>
    @forelse ($workOrderProcesess->calibrationPerformance as $calibrationPerformance)
        <tr>
            <td colspan="4">{{ $calibrationPerformance->tool_performance_check }}</td>
            <td colspan="2">{{ $calibrationPerformance->setting }}</td>
            <td colspan="3">{{ $calibrationPerformance->measurable }}</td>
            <td colspan="1">{{ $calibrationPerformance->reference_value }}</td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if ($calibrationPerformance->is_good)
                    <span class="check">&#10004;</span>
                @endif
            </td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if (!$calibrationPerformance->is_good)
                    <span class="check">&#10004;</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4"></td>
            <td colspan="2"></td>
            <td colspan="3"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
        </tr>
    @endforelse
    <tr>
        <td class="cell-head bg-primary" colspan="6">Hasil Pemeriksaan Kinerja :</td>
        <td class="cell-head bg-primary" colspan="4">Layak Pakai</td>
        <td class="cell-head bg-primary" colspan="2">Tidak Layak Pakai</td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td colspan="4" style="vertical-align: middle; text-align: center">
            @if ($workOrderProcesess->calibration_performance_is_feasible_to_use)
                <span class="check">&#10004;</span>
            @endif
        </td>
        <td colspan="2" style="vertical-align: middle; text-align: center">
            @if (!$workOrderProcesess->calibration_performance_is_feasible_to_use)
                <span class="check">&#10004;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" style="text-align: right" colspan="6">Harga Kalibrasi</td>
        <td class="cell-head bg-primary" style="text-align: right" colspan="6">Harga Service</td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: right">
            {{ number_format($workOrderProcesess->calibration_performance_calibration_price, 0, '.', '.') }}</td>
        <td colspan="6" style="text-align: right">
            {{ number_format($workOrderProcesess->replacement_of_part_service_price, 0, '.', '.') }}</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="8">Pemeriksaan Fisik</td>
        <td class="cell-head bg-primary" colspan="4">Kebersihan</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="5"></td>
        <td class="cell-head bg-primary" colspan="1">Baik</td>
        <td class="cell-head bg-primary" colspan="3">Rusak Ringan</td>
        <td class="cell-head bg-primary" colspan="1">Rusak Berat</td>
        <td class="cell-head bg-primary" colspan="1">Bersih</td>
        <td class="cell-head bg-primary" colspan="1">Kotor</td>
    </tr>

    @forelse ($workOrderProcesess->physicalChecks as $physicalCheck)
        <tr>
            <td colspan="5">{{ $physicalCheck->physical_check }}</td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if ($physicalCheck->physical_health == 'good')
                    <span class="check">&#10004;</span>
                @endif
            </td>
            <td colspan="3" style="vertical-align: middle; text-align: center">
                @if ($physicalCheck->physical_health == 'minor damage')
                    <span class="check">&#10004;</span>
                @endif
            </td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if ($physicalCheck->physical_health == 'major damage')
                    <span class="check">&#10004;</span>
                @endif
            </td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if ($physicalCheck->physical_cleanliness == 'clean')
                    <span class="check">&#10004;</span>
                @endif
            </td>
            <td colspan="1" style="vertical-align: middle; text-align: center">
                @if ($physicalCheck->physical_cleanliness == 'dirty')
                    <span class="check">&#10004;</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5"></td>
            <td colspan="1"></td>
            <td colspan="3"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
        </tr>
    @endforelse
    <tr>
        <td class="cell-head bg-primary" colspan="6">Pemeriksaan Fungsi Alat</td>
        <td class="cell-head bg-primary" colspan="6">Pemeriksaan Kelengkapan Alat</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="3"></td>
        <td class="cell-head bg-primary" colspan="1">Baik</td>
        <td class="cell-head bg-primary" colspan="1">Tidak</td>
        <td class="cell-head bg-primary" colspan="1">N/A</td>
        <td class="cell-head bg-primary" colspan="3"></td>
        <td class="cell-head bg-primary" colspan="1">Baik</td>
        <td class="cell-head bg-primary" colspan="1">Tidak</td>
        <td class="cell-head bg-primary" colspan="1">N/A</td>
    </tr>

    @if (count($workOrderProcesess->functionChecks) > count($workOrderProcesess->equipmentInspectionChecks))
        @forelse ($workOrderProcesess->functionChecks as $indexFuncCheck => $functionCheck)
            <tr>
                <td colspan="3">{{ $functionCheck->information }}</td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($functionCheck->status == 'Yes')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($functionCheck->status == 'No')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($functionCheck->status == 'NA')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="3">
                    @if (isset($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]))
                        {{ $workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]->information }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]))
                        @if ($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]->status == 'Yes')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]))
                        @if ($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]->status == 'No')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]))
                        @if ($workOrderProcesess->equipmentInspectionChecks[$indexFuncCheck]->status == 'NA')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
            </tr>
        @endforelse
    @else
        @forelse ($workOrderProcesess->equipmentInspectionChecks as $indexEquipmentCheck => $equipmentCheck)
            <tr>
                <td colspan="3">
                    @if (isset($workOrderProcesess->functionChecks[$indexEquipmentCheck]))
                        {{ $workOrderProcesess->functionChecks[$indexEquipmentCheck]->information }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->functionChecks[$indexEquipmentCheck]))
                        @if ($workOrderProcesess->functionChecks[$indexEquipmentCheck]->status == 'Yes')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->functionChecks[$indexEquipmentCheck]))
                        @if ($workOrderProcesess->functionChecks[$indexEquipmentCheck]->status == 'No')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->functionChecks[$indexEquipmentCheck]))
                        @if ($workOrderProcesess->functionChecks[$indexEquipmentCheck]->status == 'NA')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="3">{{ $equipmentCheck->information }}</td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($equipmentCheck->status == 'Yes')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($equipmentCheck->status == 'No')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($equipmentCheck->status == 'NA')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
            </tr>
        @endforelse
    @endif


    <tr>
        <td class="cell-head bg-primary" colspan="6">Alat yang digunaka untuk pemeliharaan</td>
        <td class="cell-head bg-primary" colspan="6">Pergantian Sparepart & Konsumable</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="3"></td>
        <td class="cell-head bg-primary" colspan="1">Baik</td>
        <td class="cell-head bg-primary" colspan="1">Tidak</td>
        <td class="cell-head bg-primary" colspan="1">NA</td>
        <td class="cell-head bg-primary" colspan="3"></td>
        <td class="cell-head bg-primary" colspan="1">Qty</td>
        <td class="cell-head bg-primary" colspan="1">Harga</td>
        <td class="cell-head bg-primary" colspan="1">Total</td>
    </tr>

    @if (count($workOrderProcesess->toolMaintenances) > count($workOrderProcesess->replacementOfParts))
        @forelse ($workOrderProcesess->toolMaintenances as $indexToolMaintenance => $toolMaintenance)
            <tr>
                <td colspan="3">{{ $toolMaintenance->information }}</td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($toolMaintenance->status == 'Yes')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($toolMaintenance->status == 'No')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if ($toolMaintenance->status == 'NA')
                        <span class="check">&#10004;</span>
                    @endif
                </td>
                <td colspan="3">
                    @if (isset($workOrderProcesess->replacementOfParts[$indexToolMaintenance]))
                        {{ $workOrderProcesess->replacementOfParts[$indexToolMaintenance]->sparepart->sparepart_name }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->replacementOfParts[$indexToolMaintenance]))
                        {{ number_format($workOrderProcesess->replacementOfParts[$indexToolMaintenance]->qty, 0, '.', '.') }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->replacementOfParts[$indexToolMaintenance]))
                        {{ number_format($workOrderProcesess->replacementOfParts[$indexToolMaintenance]->price, 0, '.', '.') }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->replacementOfParts[$indexToolMaintenance]))
                        {{ number_format($workOrderProcesess->replacementOfParts[$indexToolMaintenance]->amount, 0, '.', '.') }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
            </tr>
        @endforelse
    @else
        @forelse ($workOrderProcesess->replacementOfParts as $indexReplacementOfPart => $replacementOfPart)
            <tr>
                <td colspan="3">
                    @if (isset($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]))
                        {{ $workOrderProcesess->toolMaintenances[$indexReplacementOfPart]->information }}
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]))
                        @if ($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]->status == 'Yes')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]))
                        @if ($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]->status == 'No')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    @if (isset($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]))
                        @if ($workOrderProcesess->toolMaintenances[$indexReplacementOfPart]->status == 'NA')
                            <span class="check">&#10004;</span>
                        @endif
                    @endif
                </td>
                <td colspan="3">{{ $replacementOfPart->sparepart->sparepart_name }}</td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    {{ number_format($replacementOfPart->qty, 0, '.', '.') }}
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    {{ number_format($replacementOfPart->price, 0, '.', '.') }}
                </td>
                <td colspan="1" style="vertical-align: middle; text-align: center">
                    {{ number_format($replacementOfPart->amount, 0, '.', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
                <td colspan="1"></td>
            </tr>
        @endforelse
    @endif
    <tr>
        <td class="cell-head bg-primary" rowspan="3" colspan="4">Rekomendasi Hasil Pekerjaan</td>
        <td colspan="5">Alat Dapat Dipergunakan Dengan Baik
            @if ($workOrderProcesess->tools_can_be_used_well)
                <span class="check">&#10004;</span>
            @endif
        </td>
        <td colspan="3" style="color: red">Alat Tidak Dapat Digunakan

            @if ($workOrderProcesess->tool_cannot_be_used)
                <span class="check">&#10004;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="5" style="color: red">Alat Perlu Perbaikan
            @if ($workOrderProcesess->tool_need_repair)
                <span class="check">&#10004;</span>
            @endif
        </td>
        <td colspan="3">Alat Dapat Dipergunakan Perlu Pergantian Asesoris
            @if ($workOrderProcesess->tool_can_be_used_need_replacement_accessories)
                <span class="check">&#10004;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="5" style="color: red">Alat Perlu Kalibrasi
            @if ($workOrderProcesess->tool_need_calibration)
                <span class="check">&#10004;</span>
            @endif
        </td>
        <td colspan="3" style="color: red">Alat Perlu Pemutihan
            @if ($workOrderProcesess->tool_need_bleaching)
                <span class="check">&#10004;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="12" style="height: 100px; vertical-align: text-top">Catatan : <br>
            {{ $workOrderProcesess->electrical_safety_note }}</td>
    </tr>
    <tr>
        <td class="cell-head bg-primary" colspan="4">Pembuat Wo</td>
        <td class="cell-head bg-primary" colspan="4">Pelaksana Wo</td>
        <td class="cell-head bg-primary" colspan="4">User Approval</td>
    </tr>
    <tr>
        <td colspan="4" style="height: 100px; vertical-align: text-top">
            <center>
                <img style="width: 120px;margin-top:5px" src="data:image/png;base64, {!! base64_encode(QrCode::generate(getUser($workOrder->created_by))) !!} ">
                <p>{{ getUser($workOrder->created_by) }}</p>
            </center>
        </td>
        <td colspan="4" style="height: 100px; vertical-align: text-top">
            <center>

                @if ($workOrderProcesess->executor == 'technician')
                    <img style="width: 120px;margin-top:5px" src="data:image/png;base64, {!! base64_encode(QrCode::generate(getTeknisi($workOrderProcesess->work_executor_technician_id))) !!} ">
                    <p>{{ getTeknisi($workOrderProcesess->work_executor_technician_id) }}</p>
                @else
                    <img style="width: 120px;margin-top:5px" src="data:image/png;base64, {!! base64_encode(QrCode::generate(getVendor($workOrderProcesess->work_executor_vendor_id))) !!} ">
                    <p>{{ getVendor($workOrderProcesess->work_executor_vendor_id) }}</p>
                @endif

            </center>
        </td>
        <td colspan="4" style="height: 100px; vertical-align: text-top">
            <center>
                @if ($user_approved != '')
                    <img style="width: 120px;margin-top:5px" src="data:image/png;base64, {!! base64_encode(QrCode::generate(getUser($user_approved))) !!} ">
                    <p>{{ getUser($user_approved) }}</p>
                @else
                @endif
            </center>
        </td>
    </tr>
</table>
