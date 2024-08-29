<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b>{{ trans('employee/form.general_information') }}</b>
                </div>
                <hr>
                @if (!session('sessionHospital'))
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="hospital_id">{{ trans('employee/form.hospital') }}</label>
                                <select name="hospital_id" id="hospital_id"
                                    class="form-control js-example-basic-multiple">
                                    <option value="">-- {{ trans('employee/form.select_hospital') }} --</option>
                                    @if (isset($employee))
                                        @foreach ($hispotals as $hispotal)
                                            <option value="{{ $hispotal->id }}"
                                                {{ $employee->hospital_id == $hispotal->id ? 'selected' : '' }}
                                                {{ $employee->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                                                {{ $hispotal->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($hispotals as $hispotal)
                                            <option value="{{ $hispotal->id }}"
                                                {{ isset($employee) && $employee->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                                {{ $hispotal->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="hospital_id" value="{{ session('sessionHospital') }}">
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ trans('employee/form.name') }}</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->name : old('name') }}"
                            placeholder="{{ trans('employee/form.name') }}" required />
                        @error('name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nid-employee">{{ trans('employee/form.nid') }}</label>
                        <input type="text" name="nid_employee" id="nid-employee"
                            class="form-control @error('nid_employee') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->nid_employee : old('nid_employee') }}"
                            placeholder="{{ trans('employee/form.nid') }}" />
                        @error('nid_employee')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="employee-type-id">{{ trans('employee/form.type') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('employee_type_id') is-invalid @enderror"
                            name="employee_type_id" id="employee-type-id" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_type') }} --
                            </option>

                            @foreach ($employeeTypes as $employeeType)
                                <option value="{{ $employeeType->id }}"
                                    {{ isset($employee) && $employee->employee_type_id == $employeeType->id ? 'selected' : (old('employee_type_id') == $employeeType->id ? 'selected' : '') }}>
                                    {{ $employeeType->name_employee_type }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_type_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="employee-status">{{ trans('employee/form.status') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('employee_status') is-invalid @enderror"
                            name="employee_status" id="employee-status" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_status') }} --
                            </option>
                            <option value="1"
                                {{ isset($employee) && $employee->employee_status == '1' ? 'selected' : (old('employee_status') == '1' ? 'selected' : '') }}>
                                {{ __('Aktif') }}</option>
                            <option value="0"
                                {{ isset($employee) && $employee->employee_status == '0' ? 'selected' : (old('employee_status') == '0' ? 'selected' : '') }}>
                                {{ __('Non Aktif') }}</option>
                        </select>
                        @error('employee_status')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="departement-id">{{ trans('employee/form.departement') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('departement_id') is-invalid @enderror"
                            name="departement_id" id="departement-id" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_departement') }}
                                --</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ isset($employee) && $employee->departement_id == $department->id ? 'selected' : (old('departement_id') == $department->id ? 'selected' : '') }}>
                                    {{ $department->name_department }}
                                </option>
                            @endforeach
                        </select>
                        @error('departement_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="position-id">{{ trans('employee/form.position') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('position_id') is-invalid @enderror"
                            name="position_id" id="position-id" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_position') }} --
                            </option>

                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ isset($employee) && $employee->position_id == $position->id ? 'selected' : (old('position_id') == $position->id ? 'selected' : '') }}>
                                    {{ $position->name_position }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="email">{{ trans('employee/form.email') }}</label>
                        <input type="text" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->email : old('email') }}"
                            placeholder="{{ trans('employee/form.email') }}" required />
                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="phone">{{ trans('employee/form.phone') }}</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->phone : old('phone') }}"
                            placeholder="{{ trans('employee/form.phone') }}" required />
                        @error('phone')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="join-date">{{ trans('employee/form.join_date') }}</label>
                        <input type="date" name="join_date" id="join-date"
                            class="form-control @error('join_date') is-invalid @enderror"
                            value="{{ isset($employee) && $employee->join_date ? $employee->join_date->format('Y-m-d') : old('join_date') }}"
                            placeholder="{{ trans('employee/form.join_date') }}" required />
                        @error('join_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="avatar avatar-xl mb-3">
                            @if ($employee->photo != '' || $employee->photo != null)
                                <img src="{{ Storage::url('public/img/employee/') . $employee->photo }}"
                                    alt="Avatar" style="width: 150px">
                            @else
                            @endif

                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="photo"> {{ trans('employee/form.photo') }}</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" name="photo" onchange="previewImg()"
                                value="{{ $employee->photo }}">
                            <p style="color: red">* {{ trans('employee/form.change_photo') }}</p>
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
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> {{ trans('employee/form.address_information') }}</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="provinsi-id">{{ trans('employee/form.province') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('provinsi_id') is-invalid @enderror"
                            name="provinsi_id" id="provinsi-id" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_province') }}
                                --</option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ isset($employee) && $employee->provinsi_id == $province->id ? 'selected' : (old('provinsi_id') == $province->id ? 'selected' : '') }}>
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

                    <div class="col-md-6 mb-3">
                        <label for="kabkot-id">{{ __('Kabkot') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kabkot_id') is-invalid @enderror"
                            name="kabkot_id" id="kabkot-id" required>
                            <option value="" selected disabled>-- {{ __('Select kabkot') }} --</option>

                            @foreach ($kabkot as $kabkot)
                                <option value="{{ $kabkot->id }}"
                                    {{ isset($employee) && $employee->kabkot_id == $kabkot->id ? 'selected' : (old('kabkot_id') == $kabkot->id ? 'selected' : '') }}>
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
                    <div class="col-md-6 mb-3">
                        <label for="kecamatan-id">{{ trans('employee/form.subdistrict') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kecamatan_id') is-invalid @enderror"
                            name="kecamatan_id" id="kecamatan-id" required>
                            <option value="" selected disabled>--
                                {{ trans('employee/form.select_subdistrict') }} --</option>

                            @foreach ($kecamatan as $kecamatan)
                                <option value="{{ $kecamatan->id }}"
                                    {{ isset($employee) && $employee->kecamatan_id == $kecamatan->id ? 'selected' : (old('kecamatan_id') == $kecamatan->id ? 'selected' : '') }}>
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

                    <div class="col-md-6 mb-3">
                        <label for="kelurahan-id">{{ trans('employee/form.ward') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('kelurahan_id') is-invalid @enderror"
                            name="kelurahan_id" id="kelurahan-id" required>
                            <option value="" selected disabled>-- {{ trans('employee/form.select_ward') }} --
                            </option>

                            @foreach ($kelurahan as $kelurahan)
                                <option value="{{ $kelurahan->id }}"
                                    {{ isset($employee) && $employee->kelurahan_id == $kelurahan->id ? 'selected' : (old('kelurahan_id') == $kelurahan->id ? 'selected' : '') }}>
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
                    <div class="col-md-6 mb-3">
                        <label for="zip-kode">{{ trans('employee/form.zip_code') }}</label>
                        <input readonly type="text" name="zip_kode" id="zip-kode"
                            class="form-control @error('zip_kode') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->zip_kode : old('zip_kode') }}"
                            placeholder="{{ trans('employee/form.zip_code') }}" required />
                        @error('zip_kode')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">{{ trans('employee/form.address') }}</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                            placeholder="{{ trans('employee/form.address') }}" required>{{ isset($employee) ? $employee->address : old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>





                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="longitude">{{ trans('employee/form.longitude') }}</label>
                        <input type="text" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->longitude : old('longitude') }}"
                            placeholder="{{ trans('employee/form.longitude') }}" required />
                        @error('longitude')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="latitude">{{ trans('employee/form.latitude') }}</label>
                        <input type="text" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ isset($employee) ? $employee->latitude : old('latitude') }}"
                            placeholder="{{ trans('employee/form.latitude') }}" required />
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
                            name="place" id="search_place"
                            placeholder="{{ trans('employee/form.search_location') }}" value="{{ old('place') }}"
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
</div>
