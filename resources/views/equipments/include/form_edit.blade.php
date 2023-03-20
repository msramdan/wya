<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-information"></i> General Information</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="barcode">{{ __('Barcode') }}</label>
                        <input type="text" name="barcode" id="barcode"
                            class="form-control @error('barcode') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->barcode : old('barcode') }}"
                            placeholder="{{ __('Barcode') }}" required />
                        @error('barcode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nomenklatur-id">{{ __('Nomenklatur') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('nomenklatur_id') is-invalid @enderror"
                            name="nomenklatur_id" id="nomenklatur-id" required>
                            <option value="" selected disabled>-- {{ __('Select nomenklatur') }} --</option>

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
                        <label for="equipment-category-id">{{ __('Equipment Category') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('equipment_category_id') is-invalid @enderror"
                            name="equipment_category_id" id="equipment-category-id" required>
                            <option value="" selected disabled>-- {{ __('Select equipment category') }} --
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
                        <label for="manufacturer">{{ __('Manufacturer') }}</label>
                        <input type="text" name="manufacturer" id="manufacturer"
                            class="form-control @error('manufacturer') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->manufacturer : old('manufacturer') }}"
                            placeholder="{{ __('Manufacturer') }}" required />
                        @error('manufacturer')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="type">{{ __('Type') }}</label>
                        <input type="text" name="type" id="type"
                            class="form-control @error('type') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->type : old('type') }}"
                            placeholder="{{ __('Type') }}" required />
                        @error('type')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="serial-number">{{ __('Serial Number') }}</label>
                        <input type="text" name="serial_number" id="serial-number"
                            class="form-control @error('serial_number') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->serial_number : old('serial_number') }}"
                            placeholder="{{ __('Serial Number') }}" required />
                        @error('serial_number')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="vendor-id">{{ __('Vendor') }}</label>
                        <select class="form-control js-example-basic-multiple @error('vendor_id') is-invalid @enderror"
                            name="vendor_id" id="vendor-id" required>
                            <option value="" selected disabled>-- {{ __('Select vendor') }} --</option>

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
                        <label for="condition">{{ __('Condition') }}</label>
                        <select class="form-control js-example-basic-multiple @error('condition') is-invalid @enderror"
                            name="condition" id="condition" required>
                            <option value="" selected disabled>-- {{ __('Select condition') }} --</option>
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
                        <label for="risk-level">{{ __('Risk Level') }}</label>
                        <select class="form-control js-example-basic-multiple @error('risk_level') is-invalid @enderror"
                            name="risk_level" id="risk-level" required>
                            <option value="" selected disabled>-- {{ __('Select risk level') }} --</option>
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
                        <label for="equipment-location-id">{{ __('Equipment Location') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('equipment_location_id') is-invalid @enderror"
                            name="equipment_location_id" id="equipment-location-id" required>
                            <option value="" selected disabled>-- {{ __('Select equipment location') }} --
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
                        <label for="financing-code">{{ __('Financing Code') }}</label>
                        <input type="text" name="financing_code" id="financing-code"
                            class="form-control @error('financing_code') is-invalid @enderror"
                            value="{{ isset($equipment) ? $equipment->financing_code : old('financing_code') }}"
                            placeholder="{{ __('Financing Code') }}" required />
                        @error('financing_code')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="photo">{{ __('Photo') }}</label>
                        <div class="input-group">
                            <input type="file" name="photo" id="photo"
                                class="form-control @error('photo') is-invalid @enderror"
                                value="{{ isset($employee) ? $employee->photo : old('photo') }}"
                                placeholder="{{ __('Photo') }}" />
                            <button class="btn btn-primary" type="button"><i class="mdi mdi-image"
                                    aria-hidden="true"></i></button>
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
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa-solid fa-money-bill"></i> Price Reduction</b>
                </div>
                <hr>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-list"></i> Equipment Fittings <span style="color:red; font-size:11px">(
                            Recommended
                            format photo is jpg/png )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add
                            Fittings</button>
                        <table class="table table-bordered " id="dynamic_field">
                            <thead>
                                <tr>
                                    <th>Name Fittings </th>
                                    <th>Qty</th>
                                    <th>Photo</th>
                                    <th>Action</th>
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
                        Equipment Document <span style="color:red; font-size:11px">( Recommended
                            format document is pdf )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas2" id="add_berkas2"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add
                            Document</button>
                        <table class="table table-bordered" id="dynamic_field2">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File</th>
                                    <th>Action</th>
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
