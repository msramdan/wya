<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-information"></i> {{ trans('vendor/create.general') }}</b>
                </div>
                <hr>

                <div class="row">
                    @if (!Auth::user()->roles->first()->hospital_id)
                        <div class="col-md-12 mb-2">
                            <label for="hospital_id">{{ trans('vendor/create.hospital') }}</label>
                            <select
                                class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                                name="hospital_id" id="hospital_id" required>
                                <option value="" selected disabled>-- {{ trans('vendor/create.filter_hospital') }}
                                    --</option>

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
                    @endif
                    <div class="col-md-6 mb-2">
                        <label for="code-vendor">{{ trans('vendor/create.vendor_code') }}</label>
                        <input type="text" name="code_vendor" id="code-vendor"
                            class="form-control @error('code_vendor') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->code_vendor : old('code_vendor') }}"
                            placeholder="{{ trans('vendor/create.vendor_code') }}" required />
                        @error('code_vendor')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="name-vendor">{{ trans('vendor/create.vendor_name') }}</label>
                        <input type="text" name="name_vendor" id="name-vendor"
                            class="form-control @error('name_vendor') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->name_vendor : old('name_vendor') }}"
                            placeholder="{{ trans('vendor/create.vendor_name') }}" required />
                        @error('name_vendor')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="category-vendor-id">{{ trans('vendor/create.vendor_category') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('category_vendor_id') is-invalid @enderror"
                            name="category_vendor_id" id="category-vendor-id" required>
                            <option value="" selected disabled>-- {{ trans('vendor/create.filter_category') }} --
                            </option>
                        </select>
                        @error('category_vendor_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="email">{{ trans('vendor/create.email') }}</label>
                        <input type="text" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->email : old('email') }}"
                            placeholder="{{ trans('vendor/create.email') }}" required />
                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="provinsi-id">{{ trans('vendor/create.province') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('provinsi_id') is-invalid @enderror"
                            name="provinsi_id" id="provinsi-id" required>
                            <option value="" selected disabled>-- {{ trans('vendor/create.filter_province') }} --
                            </option>

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
                        <label for="kecamatan-id">{{ trans('vendor/create.subdistrict') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kecamatan_id') is-invalid @enderror"
                            name="kecamatan_id" id="kecamatan-id" required>
                            <option value="" selected disabled>-- {{ trans('vendor/create.filter_subdistrict') }}
                                --</option>
                        </select>
                        @error('kecamatan_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="kelurahan-id">{{ trans('vendor/create.ward') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kelurahan_id') is-invalid @enderror"
                            name="kelurahan_id" id="kelurahan-id" required>
                            <option value="" selected disabled>-- {{ trans('vendor/create.filter_ward') }} --
                            </option>
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
                        <label for="zip-kode">{{ trans('vendor/create.zip_code') }}</label>
                        <input readonly type="text" name="zip_kode" id="zip-kode"
                            class="form-control @error('zip_kode') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->zip_kode : old('zip_kode') }}"
                            placeholder="{{ trans('vendor/create.zip_code') }}" required />
                        @error('zip_kode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">{{ trans('vendor/create.address') }}</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="{{ trans('vendor/create.address') }}" required>{{ isset($employee) ? $employee->address : old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="longitude">{{ trans('vendor/create.longitude') }}</label>
                        <input type="text" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->longitude : old('longitude') }}"
                            placeholder="{{ trans('vendor/create.longitude') }}" required />
                        @error('longitude')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="latitude">{{ trans('vendor/create.latitude') }}</label>
                        <input type="text" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ isset($vendor) ? $vendor->latitude : old('latitude') }}"
                            placeholder="{{ trans('vendor/create.latitude') }}" required />
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
                            name="place" id="search_place" placeholder="{{ trans('vendor/create.location') }}"
                            value="{{ old('place') }}" autocomplete="off">
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
                    <b> <i class="mdi mdi-phone-classic"></i> {{ trans('vendor/create.title') }}</b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>
                            {{ trans('vendor/create.add_contact') }}</button>
                        <table class="table table-bordered " id="dynamic_field">
                            <thead>
                                <tr>
                                    <th>{{ trans('vendor/create.name') }}</th>
                                    <th>{{ trans('vendor/create.phone') }}</th>
                                    <th>{{ trans('vendor/create.email') }}</th>
                                    <th>{{ trans('vendor/create.remark') }}</th>
                                    <th>{{ trans('vendor/create.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="mdi mdi-file"></i> {{ trans('vendor/create.title_file') }} <span
                            style="color:red; font-size:11px">( {{ trans('vendor/create.des') }} )</span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas2" id="add_berkas2"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>
                            {{ trans('vendor/create.add_file') }}</button>
                        <table class="table table-bordered" id="dynamic_field2">
                            <thead>
                                <tr>
                                    <th>{{ trans('vendor/create.file_name') }}</th>
                                    <th>{{ trans('vendor/create.file') }}</th>
                                    <th>{{ trans('vendor/create.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
