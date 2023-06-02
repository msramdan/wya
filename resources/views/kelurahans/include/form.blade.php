<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="kecamatan-id">{{ trans('region-data/kelurahan/form.subdistrict') }}</label>
        <select class="form-control js-example-basic-multiple @error('kecamatan_id') is-invalid @enderror"
            name="kecamatan_id" id="kecamatan-id" required>
            <option value="" selected disabled>-- {{ trans('region-data/kelurahan/form.select_subdistrict') }} --</option>

            @foreach ($kecamatans as $kecamatan)
                <option value="{{ $kecamatan->id }}"
                    {{ isset($kelurahan) && $kelurahan->kecamatan_id == $kecamatan->id ? 'selected' : (old('kecamatan_id') == $kecamatan->id ? 'selected' : '') }}>
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
        <label for="kelurahan">{{ trans('region-data/kelurahan/form.ward') }}</label>
        <input type="text" name="kelurahan" id="kelurahan"
            class="form-control @error('kelurahan') is-invalid @enderror"
            value="{{ isset($kelurahan) ? $kelurahan->kelurahan : old('kelurahan') }}"
            placeholder="{{ trans('region-data/kelurahan/form.ward') }}" required />
        @error('kelurahan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="kd-po">{{ trans('region-data/kelurahan/form.zip_code') }}</label>
        <input type="text" name="kd_pos" id="kd-po" class="form-control @error('kd_pos') is-invalid @enderror"
            value="{{ isset($kelurahan) ? $kelurahan->kd_pos : old('kd_pos') }}" placeholder="{{ trans('region-data/kelurahan/form.zip_code') }}"
            required />
        @error('kd_pos')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
