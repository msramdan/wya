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
                        <label for="hospital_id">{{ __('Hispotal') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                            name="hospital_id" id="hospital_id" required>
                            <option value="" selected disabled>-- {{ __('Select hispotal') }} --</option>

                            @foreach ($hispotals as $hispotal)
                                <option value="{{ $hispotal->id }}"
                                    {{ isset($unitItem) && $unitItem->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                    {{ $hispotal->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('hospital_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="code-vendor">{{ __('Code Vendor') }}</label>
                        <input type="text" name="code_vendor" id="code-vendor"
                            class="form-control @error('code_vendor') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->code_vendor : old('code_vendor') }}"
                            placeholder="{{ __('Code Vendor') }}" required />
                        @error('code_vendor')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="name-vendor">{{ __('Name Vendor') }}</label>
                        <input type="text" name="name_vendor" id="name-vendor"
                            class="form-control @error('name_vendor') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->name_vendor : old('name_vendor') }}"
                            placeholder="{{ __('Name Vendor') }}" required />
                        @error('name_vendor')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="category-vendor-id">{{ __('Category Vendor') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('category_vendor_id') is-invalid @enderror"
                            name="category_vendor_id" id="category-vendor-id" required>
                            <option value="" selected disabled>-- {{ __('Select category vendor') }} --</option>

                            @foreach ($categoryVendors as $categoryVendor)
                                <option value="{{ $categoryVendor->id }}"
                                    {{ isset($vendor) && $vendor->category_vendor_id == $categoryVendor->id ? 'selected' : (old('category_vendor_id') == $categoryVendor->id ? 'selected' : '') }}>
                                    {{ $categoryVendor->name_category_vendors }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_vendor_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="text" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->email : old('email') }}"
                            placeholder="{{ __('Email') }}" required />
                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="provinsi-id">{{ __('Province') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('provinsi_id') is-invalid @enderror"
                            name="provinsi_id" id="provinsi-id" required>
                            <option value="" selected disabled>-- {{ __('Select province') }} --</option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ isset($vendor) && $vendor->provinsi_id == $province->id ? 'selected' : (old('provinsi_id') == $province->id ? 'selected' : '') }}>
                                    {{ $province->provinsi }}
                                </option>
                            @endforeach
                        </select>
                        @error('provinsi_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="kabkot-id">{{ __('Kabkot') }}</label>
                        <select class="form-control js-example-basic-multiple @error('kabkot_id') is-invalid @enderror"
                            name="kabkot_id" id="kabkot-id" required>
                            <option value="" selected disabled>-- {{ __('Select kabkot') }} --</option>
                            @foreach ($kabkot as $kabkot)
                                <option value="{{ $kabkot->id }}"
                                    {{ isset($vendor) && $vendor->kabkot_id == $kabkot->id ? 'selected' : (old('kabkot_id') == $kabkot->id ? 'selected' : '') }}>
                                    {{ $kabkot->kabupaten_kota }}
                                </option>
                            @endforeach
                        </select>
                        @error('kabkot_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="kecamatan-id">{{ __('Kecamatan') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kecamatan_id') is-invalid @enderror"
                            name="kecamatan_id" id="kecamatan-id" required>
                            <option value="" selected disabled>-- {{ __('Select kecamatan') }} --</option>
                            @foreach ($kecamatan as $kecamatan)
                                <option value="{{ $kecamatan->id }}"
                                    {{ isset($vendor) && $vendor->kecamatan_id == $kecamatan->id ? 'selected' : (old('kecamatan_id') == $kecamatan->id ? 'selected' : '') }}>
                                    {{ $kecamatan->kecamatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="kelurahan-id">{{ __('Kelurahan') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kelurahan_id') is-invalid @enderror"
                            name="kelurahan_id" id="kelurahan-id" required>
                            <option value="" selected disabled>-- {{ __('Select kelurahan') }} --</option>
                            @foreach ($kelurahan as $kelurahan)
                                <option value="{{ $kelurahan->id }}"
                                    {{ isset($vendor) && $vendor->kelurahan_id == $kelurahan->id ? 'selected' : (old('kelurahan_id') == $kelurahan->id ? 'selected' : '') }}>
                                    {{ $kelurahan->kelurahan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelurahan_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="zip-kode">{{ __('Zip Kode') }}</label>
                        <input readonly type="text" name="zip_kode" id="zip-kode"
                            class="form-control @error('zip_kode') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->zip_kode : old('zip_kode') }}"
                            placeholder="{{ __('Zip Kode') }}" required />
                        @error('zip_kode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">{{ __('Address') }}</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="{{ __('Address') }}" required>{{ isset($vendor) ? $vendor->address : old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="longitude">{{ __('Longitude') }}</label>
                        <input type="text" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->longitude : old('longitude') }}"
                            placeholder="{{ __('Longitude') }}" required />
                        @error('longitude')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="latitude">{{ __('Latitude') }}</label>
                        <input type="text" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->latitude : old('latitude') }}"
                            placeholder="{{ __('Latitude') }}" required />
                        @error('latitude')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-12 mb-2">
                    <div class="mb-3 search-box">
                        <input type="text" class="form-control @error('place') is-invalid @enderror"
                            name="place" id="search_place" placeholder="Cari Lokasi" value="{{ old('place') }}"
                            autocomplete="off">
                        <span class="d-none" style="color: red;" id="error-place"></span>
                        @error('place')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        <ul class="results">
                            <li style="text-align: center;padding: 50% 0; max-height: 25hv;">Masukan Pencarian</li>
                        </ul>
                    </div>
                    <div class="map-embed" id="map"></div>
                </div>




            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-phone-classic"></i> Contact Vendor</b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add
                            Contact</button>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dynamic_field">
                                <thead>
                                    <tr>
                                        <th>Name </th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pic as $row)
                                        <tr id="detail_pic<?= $row->id ?>">
                                            <td>
                                                <input type="hidden" name="id_asal[]" value="{{ $row->id }}"
                                                    class="form-control " />

                                                <input style="width: 120px" required type="text" name="name[]"
                                                    placeholder="" class="form-control "
                                                    value="{{ $row->name }}" />
                                            </td>
                                            <td><input style="width: 140px" required style="" type="text"
                                                    name="phone[]" value="{{ $row->phone }}" placeholder=""
                                                    class="form-control " />
                                            </td>
                                            <td> <input style="width: 200px" required type="email"
                                                    name="email_pic[]" value="{{ $row->email }}" placeholder=""
                                                    class="form-control " />
                                            </td>
                                            <td> <input style="width: 150px" required type="text" name="remark[]"
                                                    value="{{ $row->remark }}" placeholder=""
                                                    class="form-control " />
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


        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-file"></i> File Vendor <span style="color:red; font-size:11px">( Recommended
                            format is pdf )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas2" id="add_berkas2"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add
                            File</button>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field2">
                                <thead>
                                    <tr>
                                        <th style="width: 220px">File Name</th>
                                        <th style="width: 200px">File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($file as $row)
                                        <tr id="detail_file<?= $row->id ?>">
                                            <td>
                                                <input type="hidden" name="id_asal_file[]"
                                                    value="{{ $row->id }}" class="form-control " />
                                                <input style="width: 220px" required type="text"
                                                    name="name_file[]" value="{{ $row->name_file }}" placeholder=""
                                                    readonly class="form-control" />
                                            </td>
                                            <td style="width: 200px">
                                                <center>
                                                    <a href="#" style="width: 160px" class="btn btn-primary"
                                                        data-bs-toggle="modal" id="view_gambar"
                                                        data-id="{{ $row->id }}"
                                                        data-file="{{ $row->file }}"
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
