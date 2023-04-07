@extends('layouts.app')

@section('title', __('Work Order Procesess'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Work Order Procesess') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Work Order Procesess') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="card">
                            <div class="card-header bg-danger">
                                <h3 class="text-white">Error Validation</h3>
                            </div>
                            <div class="card-body">
                                <ul style="list-style: circle;">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger" style="font-size: 1rem">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-12">
                    <div class="row">
                        <form action="{{ route('work-order-processes.update', $workOrderProcesess->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('work-order-process.includes.form-work-order-data')

                            <div class="col-12">
                                <div class="row">
                                    @include('work-order-process.includes.form-equipment')
                                    @include('work-order-process.includes.form-location')
                                </div>
                            </div>

                            @include('work-order-process.includes.form-electrical-safety')

                            @include('work-order-process.includes.form-calibration-performance')

                            @include('work-order-process.includes.form-physical-check')

                            @include('work-order-process.includes.form-function-check')

                            @include('work-order-process.includes.form-equipment-inspection-check')

                            @include('work-order-process.includes.form-tool-maintenance')

                            @include('work-order-process.includes.form-replacement-of-parts')

                            @include('work-order-process.includes.form-work-order-documents')

                            @include('work-order-process.includes.form-inspection-recommendations')

                            @include('work-order-process.includes.form-status')

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="submit" class="w-100 btn btn-primary" name="status" value="Doing"> <br>
                                        <input type="submit" class="w-100 mt-3 btn btn-success" name="status" value="Finish"><br>
                                        <a href="{{ url('/panel/work-order-processes/' . $workOrder->id) }}"><button type="button" class="btn mt-4 btn-warning"><i class="fa fa-arrow-left"></i> Back To List WO</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-scripts')
    <script>
        $('#executor').on("select2:select", function(e) {
            if ($('#executor').select2('val') == 'vendor_or_supplier') {
                $('#work_executor_vendor_id').parent().hasClass('d-none') ? $('#work_executor_vendor_id').parent().removeClass('d-none') : '';
                !$('#work_executor_technician_id').parent().hasClass('d-none') ? $('#work_executor_technician_id').parent().addClass('d-none') : '';
            } else if ($('#executor').select2('val') == 'technician') {
                $('#work_executor_technician_id').parent().hasClass('d-none') ? $('#work_executor_technician_id').parent().removeClass('d-none') : '';
                !$('#work_executor_vendor_id').parent().hasClass('d-none') ? $('#work_executor_vendor_id').parent().addClass('d-none') : '';
            }
        });

        function addRowPerformanceCalibration(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                            <div class="form-group">
                                <input autocomplete="off" type="text" autocomplete="off" placeholder="Tool Performance Check" name="calibration_performance_tool_performance_check[${lastRowIndex + 1}]" class="form-control" id="tool_performance_check_${lastRowIndex + 1}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input autocomplete="off" type="text" autocomplete="off" placeholder="Setting" name="calibration_performance_setting[${lastRowIndex + 1}]" class="form-control" id="setting_${lastRowIndex + 1}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input autocomplete="off" type="text" autocomplete="off" placeholder="Measurable" name="calibration_performance_measurable[${lastRowIndex + 1}]" class="form-control" id="measurable_${lastRowIndex + 1}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input autocomplete="off" type="text" autocomplete="off" placeholder="Reference Value" name="calibration_performance_reference_value[${lastRowIndex + 1}]" class="form-control" id="reference_value_${lastRowIndex + 1}">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <input type="radio" name="calibration_performance_is_good[${lastRowIndex + 1}]" class="form-check" value="1">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <input type="radio" name="calibration_performance_is_good[${lastRowIndex + 1}]" class="form-check" value="0">
                            </div>
                        </td>
                    </tr>
                `
            );
        }

        function addRowPhysicalCheck(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" placeholder="Physical Check" name="physical_check[${lastRowIndex + 1}]" class="form-control">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="physical_health[${lastRowIndex + 1}]" class="form-check" value="good">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="physical_health[${lastRowIndex + 1}]" class="form-check" value="minor damage">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="physical_health[${lastRowIndex + 1}]" class="form-check" value="major damage">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="physical_cleanliness[${lastRowIndex + 1}]" class="form-check" value="clean">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="physical_cleanliness[${lastRowIndex + 1}]" class="form-check" value="dirty">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function addRowFunctionCheck(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="function_check_information[${lastRowIndex + 1}]" class="form-control" placeholder="Information" id="information_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="function_check_status[${lastRowIndex + 1}]" class="form-check" value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="function_check_status[${lastRowIndex + 1}]" class="form-check" value="No">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="function_check_status[${lastRowIndex + 1}]" class="form-check" value="NA">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function addRowEquipmentInspectionCheck(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="equipment_inspect_information[${lastRowIndex + 1}]" class="form-control" placeholder="Information" id="equipment_inspect_information_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="equipment_inspect_status[${lastRowIndex + 1}]" class="form-check" value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="equipment_inspect_status[${lastRowIndex + 1}]" class="form-check" value="No">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="equipment_inspect_status[${lastRowIndex + 1}]" class="form-check" value="NA">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function addRowToolMaintenance(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="tool_maintenance_information[${lastRowIndex + 1}]" class="form-control" placeholder="Information" id="tool_maintenance_information_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="tool_maintenance_status[${lastRowIndex + 1}]" class="form-check" value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="tool_maintenance_status[${lastRowIndex + 1}]" class="form-check" value="No">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <input type="radio" name="tool_maintenance_status[${lastRowIndex + 1}]" class="form-check" value="NA">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function addRowReplacementOfPart(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="sparepart_id[${lastRowIndex + 1}]" class="form-control" id="sparepart_id_${lastRowIndex + 1}" onchange="getSparepartInfo(${lastRowIndex + 1})">
                                <option value="">--Choose Sparepart--</option>
                                @foreach ($spareparts as $sparepart)
                                    <option value="{{ $sparepart->id }}">{{ $sparepart->sparepart_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="price[${lastRowIndex + 1}]" placeholder="Price" class="form-control text-right" id="price${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="stock[${lastRowIndex + 1}]" placeholder="Stock" class="form-control text-right" id="stock${lastRowIndex + 1}" readonly="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="amount[${lastRowIndex + 1}]" placeholder="Amount" class="form-control text-right" id="amount${lastRowIndex + 1}">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function addRowWoDocument(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length - 1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input placeholder="Document Name" type="text" name="document_name[${lastRowIndex + 1}]" class="form-control" id="document_name_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input placeholder="Description" type="text" name="description[${lastRowIndex + 1}]" class="form-control" id="description_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="file" name="file[${lastRowIndex + 1}]" class="form-control" id="file_${lastRowIndex + 1}">
                        </div>
                    </td>
                </tr>
                `
            );
        }
    </script>
@endpush
