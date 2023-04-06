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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Work Order Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="wo_type">WO Type</label>
                                                <input type="text" name="wo_type" id="wo_type" class="form-control" value="Service" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="executor">Executor</label>
                                                <select name="executor" class="form-control js-example-basic-multiple" id="executor">
                                                    <option value="" disabled>-- Choose Executor --</option>
                                                    <option value="vendor_or_supplier">Vendor/Supplier</option>
                                                    <option value="Teknisi">Teknisi</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="work_executor">Work Executor</label>
                                                <select name="work_executor" class="form-control js-example-basic-multiple" id="work_executor">
                                                    <option value="" disabled>-- Choose Work Executor --</option>
                                                    <option value="demo">Demo</option>
                                                    <option value="marju">Marju</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="vendor">Vendor</label>
                                                <input type="text" name="vendor" id="vendor" class="form-control" value="Enesers" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="propose">Propose</label>
                                                <input type="text" name="propose" id="propose" class="form-control" value="Test Demo" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="propose_date">Propose Date</label>
                                                <input type="text" name="propose_date" id="propose_date" class="form-control" value="2023-04-04" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="date_propose_approved">Date Proposes Approved</label>
                                                <input type="text" name="date_propose_approved" id="date_propose_approved" class="form-control" value="2023-04-04" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="propose_approved_by">Proposes Approved By</label>
                                                <ul>
                                                    <li>
                                                        <input type="text" name="propose_approved_by" value="Tomy Wibowo" class="form-control" readonly>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="work_date">Work Date</label>
                                                <input type="text" name="work_date" id="work_date" class="form-control" value="2023-04-04">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Equipment</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="equipment">Equipment</label>
                                        <input type="text" name="equipment" id="equipment" value="INFRA RED LAMP" class="form-control" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">Category</label>
                                        <input type="text" name="category" id="category" value="Alat Kesehatan" class="form-control" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="manufacturer">Manufacturer</label>
                                        <input type="text" name="manufacturer" id="manufacturer" value="Riester" readonly class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="serial_number">Serial Number</label>
                                        <input type="text" name="serial_number" id="serial_number" readonly value="IRL09435" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="type">Type</label>
                                        <input type="text" name="type" id="type" value="IRL" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Location</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" id="location" value="Emergency" class="form-control" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="initial_temperature">Initial Iemperature (℃)</label>
                                        <input type="text" name="initial_temperature" id="initial_temperature" value="0" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="initial_humidity">Initial Humidity (℃)</label>
                                        <input type="text" name="initial_humidity" id="initial_humidity" value="0" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="final_temperature">Final Iemperature (℃)</label>
                                        <input type="text" name="final_temperature" id="final_temperature" value="0" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="final_humidity">Final Humidity (℃)</label>
                                        <input type="text" name="final_humidity" id="final_humidity" value="0" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Electrical Safety</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="mesh_voltage">Mesh Voltage (VAC)</label>
                                                <input type="text" name="mesh_voltage" value="0" class="form-control" id="mesh_voltage">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="ups">UPS (VAC)</label>
                                                <input type="text" name="ups" value="0" class="form-control" id="ups">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="grounding">Grounding (OHM)</label>
                                                <input type="text" name="grounding" value="0" class="form-control" id="grounding">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="leakage_electric">Leakage Electric (uA)</label>
                                                <input type="text" name="leakage_electric" value="0" class="form-control" id="leakage_electric">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="note">Note</label>
                                                <textarea name="note" class="form-control" placeholder="Note" style="height: 80px" id="note" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Calibration Performance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-kalibrasi">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tool Performance Check</th>
                                                    <th>Setting</th>
                                                    <th>Measurable</th>
                                                    <th>Reference Value</th>
                                                    <th class="text-center">Good</th>
                                                    <th class="text-center">Not Good</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_kalibrasi">
                                                <tr class="item_kalibrasi">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_kalibrasi btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Tool Performance Check" name="kalibrasi_keterangan[0]" class="form-control" id="kalibrasi_keterangan" value="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Setting" name="kalibrasi_setting[0]" class="form-control" id="kalibrasi_setting">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Measurable" name="kalibrasi_terukur[0]" class="form-control" id="price">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Reference Value" name="kalibrasi_nilai[0]" class="form-control" id="kalibrasi_nilai_0">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="equip_id" class="control-label">Performance Check Results</label>
                                                <div class="form-check">
                                                    <input type="radio" id="feasible_to_use" class="form-check-input" value="1" name="hasil_kalibrasi" checked="">
                                                    <label class="form-check-label" for="feasible_to_use">
                                                        Feasible to Use
                                                    </label>
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input type="radio" id="not_worth_to_use" class="form-check-input" value="0" name="hasil_kalibrasi" checked="">
                                                    <label class="form-check-label" for="not_worth_to_use">
                                                        Not Worth to Use
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="calibration_price" class="control-label">Calibration Price</label>
                                                <input type="text" name="calibration_price" class="form-control" id="calibration_price" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Function Check</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-fungsi">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Information</th>
                                                    <th class="text-center">Yes</th>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">NA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_fungsi">
                                                <tr class="item_fungsi">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_fungsi btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="fungsi_keterangan[0]" class="form-control" placeholder="Information" id="fungsi_keterangan_0">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Equipment Inspection</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-fungsi">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Information</th>
                                                    <th class="text-center">Yes</th>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">NA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_fungsi">
                                                <tr class="item_fungsi">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_fungsi btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="fungsi_keterangan[0]" class="form-control" placeholder="Information" id="fungsi_keterangan_0">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Tool Maintenance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-fungsi">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Information</th>
                                                    <th class="text-center">Yes</th>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">NA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_fungsi">
                                                <tr class="item_fungsi">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_fungsi btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="fungsi_keterangan[0]" class="form-control" placeholder="Information" id="fungsi_keterangan_0">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <input type="radio" name="kalibrasi_status[0]" class="form-check" value="1">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Replacement of Parts/Consumables</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-sparepart">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Part / Consumable</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_sparepart">
                                                <tr class="item_sparepart">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_sparepart btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select name="sparepart_item[0]" class="form-control" id="sparepart_item0" onchange="getSparepartInfo(0)">
                                                                <option value="">--Choose Sparepart--</option>
                                                                <option value="48">Kabel ECG</option>
                                                                <option value="50">Kertas ECG</option>
                                                                <option value="49">Mainboard ECG</option>
                                                                <option value="51">ECG Electroda</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="sparepart_item_price[0]" placeholder="Price" class="form-control text-right" id="sparepart_item_price0">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="sparepart_stock[0]" placeholder="Stock" class="form-control text-right" id="sparepart_stock0" readonly="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="sparepart_item_qty[0]" placeholder="Amount" class="form-control text-right" id="sparepart_item_qty0">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="location" class="control-label">Service Price</label>
                                                <input type="number" name="harga_service" class="form-control" placeholder="Service Price" id="harga_service" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Work Order Document</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table" id="table-dokumen">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Description</th>
                                                    <th>File</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper_dokumen">
                                                <tr class="item_dokumen">
                                                    <td>
                                                        <a href="javascript:void(0);" class="add_button_dokumen btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input placeholder="Document Name" type="text" name="document_name[0]" class="form-control" id="document_name">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group">
                                                            <input placeholder="Description" type="text" name="document_description[0]" class="form-control" id="document_description">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group">
                                                            <input type="file" name="document_link[0]" class="form-control" id="document_link">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            -
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Inspection Recommendations</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_1" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_1">
                                                <label class="form-check-label" for="wo_rekomendasi_1">
                                                    Alat Dapat Dipergunakan Dengan Baik
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_2" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_2">
                                                <label class="form-check-label" for="wo_rekomendasi_2" style="color: red">
                                                    Alat Tidak Dapat Digunakan
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_3" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_3">
                                                <label class="form-check-label" for="wo_rekomendasi_3" style="color: red">
                                                    Alat Perlu Perbaikan
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_4" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_4">
                                                <label class="form-check-label" for="wo_rekomendasi_4">
                                                    Alat Dapat Dipergunakan Perlu Pergantian Asesoris
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_5" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_5">
                                                <label class="form-check-label" for="wo_rekomendasi_5" style="color: red">
                                                    Alat Perlu Kalibrasi
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input name="wo_rekomendasi_6" class="form-check-input" type="checkbox" value="1" id="wo_rekomendasi_6">
                                                <label class="form-check-label" for="wo_rekomendasi_6" style="color: red">
                                                    Alat Perlu Pemutihan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Status : On Progress</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <input type="submit" class="w-100 btn btn-primary" name="submit" value="Doing"> <br>
                                    <input type="submit" class="w-100 mt-3 btn btn-success" name="submit" value="Finish"><br>
                                    <a href="https://www.marsweb.id/admin/wo/process"><button type="button" class="btn mt-4 btn-warning"><i class="fa fa-arrow-left"></i> Back To List WO</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
