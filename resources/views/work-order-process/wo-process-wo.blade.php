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
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
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
                        <form action="{{ route('work-order-processes.update', $workOrderProcesess->id) }}" method="POST"
                            enctype="multipart/form-data">
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

                            @include('work-order-process.includes.form-catatan')

                            @include('work-order-process.includes.form-status')

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        @if (!$readonly)
                                            <input type="submit" class="w-100 btn btn-primary" name="status"
                                                value="Doing"> <br>
                                            <input type="submit" class="w-100 mt-3 btn btn-success" name="status"
                                                value="Finish"><br>
                                        @endif
                                        <a href="{{ url('/panel/work-order-processes/' . $workOrder->id) }}"><button
                                                type="button" class="btn mt-4 btn-warning"><i class="fa fa-arrow-left"></i>
                                                Back To List WO</button></a>
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
                $('#work_executor_vendor_id').parent().hasClass('d-none') ? $('#work_executor_vendor_id').parent()
                    .removeClass('d-none') : '';
                !$('#work_executor_technician_id').parent().hasClass('d-none') ? $('#work_executor_technician_id')
                    .parent().addClass('d-none') : '';
            } else if ($('#executor').select2('val') == 'technician') {
                $('#work_executor_technician_id').parent().hasClass('d-none') ? $('#work_executor_technician_id')
                    .parent().removeClass('d-none') : '';
                !$('#work_executor_vendor_id').parent().hasClass('d-none') ? $('#work_executor_vendor_id').parent()
                    .addClass('d-none') : '';
            }
        });

        function addRowPerformanceCalibration(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

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
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

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
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

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
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

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
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

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
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);
            let existsNotSelectedRow = false;
            let selectedSpareparts = Array.from(document.querySelectorAll('#col-replacement-of-parts select')).map((e) => {
                if (!e.value) {
                    alert('Please choose sparepart before adding new row');
                    throw 'exit';
                }

                return e.value;
            });

            makeUniqueSelectSparepart();

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeWoProcWo(this)"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <select onchange="loadStockSparepart(this)" name="replacement_sparepart_id[${lastRowIndex + 1}]" class="form-control" id="replacement_sparepart_id_${lastRowIndex + 1}" onchange="getSparepartInfo(${lastRowIndex + 1})">
                                <option value="">--Choose Sparepart--</option>
                                @foreach ($spareparts as $sparepart)
                                    ${
                                        !selectedSpareparts.includes('{{ $sparepart->id }}') ?
                                            '<option data-unit="{{ $sparepart->unit_item->code_unit }}" data-price="{{ $sparepart->estimated_price }}" data-stock="{{ $sparepart->stock }}" value="{{ $sparepart->id }}">{{ $sparepart->sparepart_name }}</option>'
                                        :   ''
                                    }
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="number" step="any" name="replacement_price[${lastRowIndex + 1}]" placeholder="Price" class="form-control text-right" readonly id="replacement_price${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="number" name="replacement_stock[${lastRowIndex + 1}]" placeholder="Stock" class="form-control text-right" id="replacement_stock${lastRowIndex + 1}" readonly="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="text" name="unit_stock[${lastRowIndex + 1}]" placeholder="Unit" class="form-control text-right" id="unit_stock${lastRowIndex + 1}" readonly="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" onkeyup="generateAmountReplacementOfPart(this)" type="number" name="replacement_qty[${lastRowIndex + 1}]" placeholder="Qty" class="form-control text-right" id="replacement_qty${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input autocomplete="off" type="number" name="replacement_amount[${lastRowIndex + 1}]" placeholder="Amount" class="form-control text-right" id="replacement_amount${lastRowIndex + 1}" readonly>
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function generateAmountReplacementOfPart(qtyElement) {
            const amountElement = qtyElement.parentElement.parentElement.nextElementSibling.querySelector('input');
            const priceElement = qtyElement.parentElement.parentElement.previousElementSibling.previousElementSibling
                .previousElementSibling.querySelector('input');

            if (qtyElement.value && priceElement.value) {
                amountElement.value = parseInt(priceElement.value) * parseInt(qtyElement.value);
            }
        }

        function makeUniqueSelectSparepart() {
            Array.from(document.querySelectorAll('#col-replacement-of-parts select')).forEach((currentSelectEl, index) => {
                if (index != 0) {
                    Array.from(currentSelectEl.children).forEach((optionCurrentSelectEl) => {
                        Array.from(document.querySelectorAll('#col-replacement-of-parts select')).forEach((
                            conditionalSelectEl) => {
                            if (optionCurrentSelectEl.getAttribute('value') == conditionalSelectEl
                                .value && optionCurrentSelectEl.getAttribute('value') !=
                                currentSelectEl.value) {
                                optionCurrentSelectEl.remove();
                            }
                        });
                    });
                }
            });
        }

        function addRowWoDocument(currentRowHtml) {
            let lastRowIndex = parseInt(currentRowHtml.parentElement.children[currentRowHtml.parentElement.children.length -
                1].dataset.index);

            currentRowHtml.parentElement.insertAdjacentHTML('beforeend',
                `
                <tr data-index="${lastRowIndex + 1}">
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <div class="form-group">
                            <input placeholder="Document Name" type="text" name="wo_doc_document_name[${lastRowIndex + 1}]" class="form-control" id="document_name_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input placeholder="Description" type="text" name="wo_doc_description[${lastRowIndex + 1}]" class="form-control" id="description_${lastRowIndex + 1}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="file" name="wo_doc_file[${lastRowIndex + 1}]" class="form-control" id="file_${lastRowIndex + 1}">
                        </div>
                    </td>
                </tr>
                `
            );
        }

        function loadStockSparepart(selectElement) {
            makeUniqueSelectSparepart();

            if (selectElement.value) {
                const stock = selectElement.children[selectElement.selectedIndex].dataset.stock;
                const price = selectElement.children[selectElement.selectedIndex].dataset.price;
                const unit = selectElement.children[selectElement.selectedIndex].dataset.unit;

                selectElement.parentElement.parentElement.nextElementSibling.querySelector('input').value = price;
                selectElement.parentElement.parentElement.nextElementSibling.nextElementSibling.querySelector('input')
                    .value = stock;
                selectElement.parentElement.parentElement.nextElementSibling.nextElementSibling.nextElementSibling
                    .querySelector('input').value = unit;
            } else {
                selectElement.parentElement.parentElement.nextElementSibling.querySelector('input').value = null;
                selectElement.parentElement.parentElement.nextElementSibling.nextElementSibling.querySelector('input')
                    .value = null;
                selectElement.parentElement.parentElement.nextElementSibling.nextElementSibling.nextElementSibling
                    .querySelector('input').value = null;
            }

            generateAmountReplacementOfPart(selectElement.parentElement.parentElement.nextElementSibling.nextElementSibling
                .nextElementSibling.nextElementSibling.querySelector('input'));
        }

        function removeWoProcWo(el) {
            el.parentElement.parentElement.remove();
        }
    </script>
@endpush
