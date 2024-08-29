<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-information"></i> {{ trans('inventory/equipment/form.general_information') }}</b>
                </div>
                <hr>

                @if (!session('sessionHospital'))
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="role">{{ trans('inventory/equipment/form.hospital') }}</label>
                                <select name="hospital_id" id="hospital_id"
                                    class="form-control js-example-basic-multiple">
                                    <option value="">-- {{ trans('inventory/equipment/form.select_hispotal') }} --</option>
                                    @if (isset($equipment))
                                    @foreach ($hispotals as $hispotal)
                                        <option value="{{ $hispotal->id }}"
                                            {{ $equipment->hospital_id == $hispotal->id ? 'selected' : '' }}
                                            {{ $equipment->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                                            {{ $hispotal->name }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($hispotals as $hispotal)
                                        <option value="{{ $hispotal->id }}"
                                            {{ isset($equipment) && $equipment->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                            {{ $hispotal->name }}
                                        </option>
                                    @endforeach
                                @endif


                                </select>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="hospital_id" value="{{ session('sessionHospital') }}"
                        readonly id="hospital_id">
                @endif

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="barcode">{{ trans('inventory/equipment/form.barcode') }}</label>
                        <input type="text" name="barcode" id="barcode"
                            class="form-control @error('barcode') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->barcode : old('barcode') }}"
                            placeholder="{{ trans('inventory/equipment/form.barcode') }}" required />
                        @error('barcode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nomenklatur-id"> {{ trans('inventory/equipment/form.nomenklatur') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('nomenklatur_id') is-invalid @enderror"
                            name="nomenklatur_id" id="nomenklatur-id" required>
                            <option value="" selected disabled>--  {{ trans('inventory/equipment/form.select_nomenklatur') }} --</option>

                            @foreach ($nomenklaturs as $nomenklatur)
                                <option value="{{ $nomenklatur->id }}"
                                    {{ isset($equipment) && $equipment->nomenklatur_id == $nomenklatur->id ? 'selected' : (old('nomenklatur_id') == $nomenklatur->id ? 'selected' : '') }}>
                                    {{ $nomenklatur->name_nomenklatur }}
                                </option>
                            @endforeach
                        </select>
                        @error('nomenklatur_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="equipment-category-id">{{ trans('inventory/equipment/form.category') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('equipment_category_id') is-invalid @enderror"
                            name="equipment_category_id" id="equipment-category-id" required>
                            <option value="" selected disabled>-- {{ trans('inventory/equipment/form.select_category') }} --
                            </option>

                            @foreach ($equipmentCategories as $equipmentCategory)
                                <option value="{{ $equipmentCategory->id }}"
                                    {{ isset($equipment) && $equipment->equipment_category_id == $equipmentCategory->id ? 'selected' : (old('equipment_category_id') == $equipmentCategory->id ? 'selected' : '') }}>
                                    {{ $equipmentCategory->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_category_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="manufacturer">{{ trans('inventory/equipment/form.manufacture') }}</label>
                        <input type="text" name="manufacturer" id="manufacturer"
                            class="form-control @error('manufacturer') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->manufacturer : old('manufacturer') }}"
                            placeholder="{{ trans('inventory/equipment/form.manufacture') }}" required />
                        @error('manufacturer')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="type">{{ trans('inventory/equipment/form.type') }}</label>
                        <input type="text" name="type" id="type"
                            class="form-control @error('type') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->type : old('type') }}"
                            placeholder="{{ trans('inventory/equipment/form.type') }}" required />
                        @error('type')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="serial-number">{{ trans('inventory/equipment/form.serial_number') }}</label>
                        <input type="text" name="serial_number" id="serial-number"
                            class="form-control @error('serial_number') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->serial_number : old('serial_number') }}"
                            placeholder="{{ trans('inventory/equipment/form.serial_number') }}" required />
                        @error('serial_number')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="vendor-id">{{ trans('inventory/equipment/form.vendor') }}</label>
                        <select class="form-control js-example-basic-multiple @error('vendor_id') is-invalid @enderror"
                            name="vendor_id" id="vendor-id" required>
                            <option value="" selected disabled>-- {{ trans('inventory/equipment/form.select_vendor') }} --</option>

                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                    {{ isset($equipment) && $equipment->vendor_id == $vendor->id ? 'selected' : (old('vendor_id') == $vendor->id ? 'selected' : '') }}>
                                    {{ $vendor->name_vendor }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="condition">{{ trans('inventory/equipment/form.condition') }}</label>
                        <select class="form-control js-example-basic-multiple @error('condition') is-invalid @enderror"
                            name="condition" id="condition" required>
                            <option value="" selected disabled>-- {{ trans('inventory/equipment/form.select_condition') }} --</option>
                            <option value="Baik"
                                {{ isset($equipment) && $equipment->condition == 'Baik' ? 'selected' : (old('condition') == 'Baik' ? 'selected' : '') }}>
                                {{ __('Baik') }}</option>
                            <option value="Tidak Baik"
                                {{ isset($equipment) && $equipment->condition == 'Tidak Baik' ? 'selected' : (old('condition') == 'Tidak Baik' ? 'selected' : '') }}>
                                {{ __('Tidak Baik') }}</option>
                        </select>
                        @error('condition')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="risk-level">{{ trans('inventory/equipment/form.risk_level') }}</label>
                        <select class="form-control js-example-basic-multiple @error('risk_level') is-invalid @enderror"
                            name="risk_level" id="risk-level" required>
                            <option value="" selected disabled>-- {{ trans('inventory/equipment/form.select_risk_level') }} --</option>
                            <option value="Resiko Rendah"
                                {{ isset($equipment) && $equipment->risk_level == 'Resiko Rendah' ? 'selected' : (old('risk_level') == 'Resiko Rendah' ? 'selected' : '') }}>
                                {{ __('Resiko Rendah') }}</option>
                            <option value="Resiko Rendah - Sedang"
                                {{ isset($equipment) && $equipment->risk_level == 'Resiko Rendah - Sedang' ? 'selected' : (old('risk_level') == 'Resiko Rendah - Sedang' ? 'selected' : '') }}>
                                {{ __('Resiko Rendah - Sedang') }}</option>

                            <option value="Resiko Sedang - Tinggi"
                                {{ isset($equipment) && $equipment->risk_level == 'Resiko Sedang - Tinggi' ? 'selected' : (old('risk_level') == 'Resiko Sedang - Tinggi' ? 'selected' : '') }}>
                                {{ __('Resiko Sedang - Tinggi') }}</option>

                            <option value="Resiko Tinggi"
                                {{ isset($equipment) && $equipment->risk_level == 'Resiko Tinggi' ? 'selected' : (old('risk_level') == 'Resiko Tinggi' ? 'selected' : '') }}>
                                {{ __('Resiko Tinggi') }}</option>
                        </select>
                        @error('risk_level')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="equipment-location-id">{{ trans('inventory/equipment/form.location') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('equipment_location_id') is-invalid @enderror"
                            name="equipment_location_id" id="equipment-location-id" required>
                            <option value="" selected disabled>-- {{ trans('inventory/equipment/form.select_location') }}--
                            </option>

                            @foreach ($equipmentLocations as $equipmentLocation)
                                <option value="{{ $equipmentLocation->id }}"
                                    {{ isset($equipment) && $equipment->equipment_location_id == $equipmentLocation->id ? 'selected' : (old('equipment_location_id') == $equipmentLocation->id ? 'selected' : '') }}>
                                    {{ $equipmentLocation->location_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_location_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="financing-code">{{ trans('inventory/equipment/form.financing_code') }}</label>
                        <input type="text" name="financing_code" id="financing-code"
                            class="form-control @error('financing_code') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->financing_code : old('financing_code') }}"
                            placeholder="{{ trans('inventory/equipment/form.financing_code') }}" required />
                        @error('financing_code')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="photo">{{ trans('inventory/equipment/form.photo') }}</label>
                        <div class="input-group">
                            <input type="file" name="photo" id="photo"
                                class="form-control @error('photo') is-invalid @enderror"
                                value="{{ isset($employee) ? $employee->photo : old('photo') }}"
                                placeholder="{{ trans('inventory/equipment/form.photo') }}" />
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" id="view_photo_alat"
                                data-photo="{{ $equipment->photo }}" data-bs-target="#modalPhotoAlat"
                                title="View Photo"><i class="mdi mdi-image" aria-hidden="true"></i>
                            </a>
                        </div>
                        <p style="color: red">* Choose a photo if you want to change it</p>
                        @error('photo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa-solid fa-money-bill"></i> {{ trans('inventory/equipment/form.price_reduction') }}</b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tgl_pembelian">{{ trans('inventory/equipment/form.purchase_date') }}</label>
                        <input type="date" name="tgl_pembelian" id="tgl_pembelian"
                            class="form-control @error('tgl_pembelian') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->tgl_pembelian : old('tgl_pembelian') }}"
                            placeholder="{{ trans('inventory/equipment/form.purchase_date') }}" required />
                        @error('tgl_pembelian')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="metode">{{ trans('inventory/equipment/form.method') }}</label>
                        <select class="form-control js-example-basic-multiple @error('metode') is-invalid @enderror"
                            name="metode" id="metode" required>
                            <option value="" selected disabled>--  {{ trans('inventory/equipment/form.select_method') }} --</option>
                            <option value="Garis Lurus"
                                {{ isset($equipment) && $equipment->metode == 'Garis Lurus' ? 'selected' : (old('metode') == 'Garis Lurus' ? 'selected' : '') }}>
                                {{ __('Garis Lurus') }}</option>
                            <option value="Saldo Menurun"
                                {{ isset($equipment) && $equipment->metode == 'Saldo Menurun' ? 'selected' : (old('metode') == 'Saldo Menurun' ? 'selected' : '') }}>
                                {{ __('Saldo Menurun') }}</option>
                        </select>
                        @error('metode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nilai_perolehan">{{ trans('inventory/equipment/form.acquisition_value') }}</label>
                        <input type="number" name="nilai_perolehan" id="nilai_perolehan"
                            class="form-control @error('nilai_perolehan') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->nilai_perolehan : old('nilai_perolehan') }}"
                            placeholder="{{ trans('inventory/equipment/form.acquisition_value') }}" required />
                        @error('nilai_perolehan')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nilai_residu">{{ trans('inventory/equipment/form.residual_value') }}</label>
                        <input type="number" name="nilai_residu" id="nilai_residu"
                            class="form-control @error('nilai_residu') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->nilai_residu : old('nilai_residu') }}"
                            placeholder="{{ trans('inventory/equipment/form.residual_value') }}" required />
                        @error('nilai_residu')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="masa_manfaat">{{ trans('inventory/equipment/form.useful') }}</label>
                        <input type="number" name="masa_manfaat" id="masa_manfaat"
                            class="form-control @error('masa_manfaat') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->masa_manfaat : old('masa_manfaat') }}"
                            placeholder="{{ trans('inventory/equipment/form.useful') }}" required />
                        @error('masa_manfaat')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-list"></i> {{ trans('inventory/equipment/form.eq_fitting') }} <span style="color:red; font-size:11px">(
                        {{ trans('inventory/equipment/form.eq_desc') }} )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('inventory/equipment/form.add_fiting') }}</button>
                        <table class="table table-bordered " id="dynamic_field">
                            <thead>
                                <tr>
                                    <th>{{ trans('inventory/equipment/form.fitting_name') }} </th>
                                    <th>Qty</th>
                                    <th>{{ trans('inventory/equipment/form.photo') }}</th>
                                    <th>{{ trans('inventory/equipment/form.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fittings as $row)
                                    <tr id="detail_fittings<?= $row->id ?>">
                                        <td>
                                            <input type="hidden" name="id_asal_fittings[]"
                                                value="{{ $row->id }}" class="form-control " />
                                            <input style="" required type="text" name="name_fittings[]"
                                                value="{{ $row->name_fittings }}" placeholder=""
                                                class="form-control" />
                                        </td>

                                        <td>
                                            <input style="" required type="number" name="qty[]"
                                                value="{{ $row->qty }}" placeholder="" class="form-control" />
                                        </td>
                                        <td style="width: 200px">
                                            <center>
                                                {{-- equipment_fittings --}}
                                                <a href="#" style="width: 160px" class="btn btn-primary"
                                                    data-bs-toggle="modal" id="view_photo"
                                                    data-id="{{ $row->id }}" data-photo="{{ $row->photo }}"
                                                    data-name_fittings="{{ $row->name_fittings }}"
                                                    data-bs-target="#largeModalFittings" title="View Photo"><i
                                                        class="mdi mdi-image"></i> View Photo
                                                </a>
                                            </center>
                                        </td>
                                        <td><button type="button" name="" id=""
                                                class="btn btn-danger btn_remove_data"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-file" aria-hidden="true"></i>
                        {{ trans('inventory/equipment/form.eq_document') }} <span style="color:red; font-size:11px">( {{ trans('inventory/equipment/form.eqdoc_desc') }} )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas2" id="add_berkas2"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('inventory/equipment/form.add_doc') }}</button>
                        <table class="table table-bordered" id="dynamic_field2">
                            <thead>
                                <tr>
                                    <th>{{ trans('inventory/equipment/form.file_name') }}</th>
                                    <th>{{ trans('inventory/equipment/form.file') }}</th>
                                    <th>{{ trans('inventory/equipment/form.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($file as $row)
                                    <tr id="detail_file<?= $row->id ?>">
                                        <td>
                                            <input type="hidden" name="id_asal_file[]" value="{{ $row->id }}"
                                                class="form-control " />
                                            <input required type="text" name="name_file[]"
                                                value="{{ $row->name_file }}" placeholder="" class="form-control"
                                                readonly />
                                        </td>
                                        <td style="width: 200px">
                                            <center>
                                                <a href="#" style="width: 160px" class="btn btn-primary"
                                                    data-bs-toggle="modal" id="view_gambar"
                                                    data-id="{{ $row->id }}" data-file="{{ $row->file }}"
                                                    data-name_file="{{ $row->name_file }}"
                                                    data-bs-target="#largeModal" title="View Gambar"><i
                                                        class="mdi mdi-file"></i> View File
                                                </a>

                                            </center>
                                        </td>
                                        <td><button type="button" name="" id=""
                                                class="btn btn-danger btn_remove_data"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        {{-- photo --}}

        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-file" aria-hidden="true"></i>
                        {{ trans('inventory/equipment/form.eq_photo') }} <span style="color:red; font-size:11px">( {{ trans('inventory/equipment/form.eqphoto_desc') }} )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas3" id="add_berkas3"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('inventory/equipment/form.add_photo') }}</button>
                        <table class="table table-bordered" id="dynamic_field3">
                            <thead>
                                <tr>
                                    <th>{{ trans('inventory/equipment/form.desc') }}</th>
                                    <th>{{ trans('inventory/equipment/form.file') }}</th>
                                    <th>{{ trans('inventory/equipment/form.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($photo as $row)
                                    <tr id="detail_photo<?= $row->id ?>">
                                        <td>
                                            <input type="hidden" name="id_asal_photo[]" value="{{ $row->id }}"
                                                class="form-control " />
                                            <input required type="text"
                                                value="{{ $row->name_photo }}" placeholder="" class="form-control"
                                                readonly />
                                        </td>
                                        <td style="width: 200px">
                                            <center>
                                                <a href="#" style="width: 160px" class="btn btn-primary"
                                                    data-bs-toggle="modal" id="view_photo_eq"
                                                    data-id="{{ $row->id }}"
                                                    data-photo_eq="{{ $row->photo }}"
                                                    data-name_photo="{{ $row->name_photo }}"
                                                    data-bs-target="#largeModalPhoto" title="View Gambar"><i
                                                        class="mdi mdi-file"></i> View File
                                                </a>

                                            </center>
                                        </td>
                                        <td><button type="button" name="" id=""
                                                class="btn btn-danger btn_remove3"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </div>


</div>

<div class="modal fade" id="largeModalPhoto" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Name Photo : <span id="name_photo"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <hr>
            </div>
            <div class="modal-body">
                <center><img src="" id="photo_eq" style="width: 100%;margin:0px" />
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Vendor : <span id="name_file"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <hr>
            </div>
            <div class="modal-body">
                <center><embed src="" id="file_vendor" style="width: 700px;height:500px; margin:0px" />
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="largeModalFittings" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo Fitting : <span id="name_fittings"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <hr>
            </div>
            <div class="modal-body">
                <center><img src="" id="photo_fitting" style="width: 100%;margin:0px" />
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPhotoAlat" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo Equipment </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <hr>
            </div>
            <div class="modal-body">
                <center><img src="" id="photo_alat" style="width: 100%;margin:0px" />
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
