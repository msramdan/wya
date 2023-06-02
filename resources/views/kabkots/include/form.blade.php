<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="provinsi-id">{{ trans('region-data/kabkot/form.province') }}</label>
        <select class="form-control js-example-basic-multiple @error('provinsi_id') is-invalid @enderror"
            name="provinsi_id" id="provinsi-id" required>
            <option value="" selected disabled>-- {{ trans('region-data/kabkot/form.select_province') }} --</option>

            @foreach ($provinces as $province)
                <option value="{{ $province->id }}"
                    {{ isset($kabkot) && $kabkot->provinsi_id == $province->id ? 'selected' : (old('provinsi_id') == $province->id ? 'selected' : '') }}>
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
        <label for="kabupaten-kotum">{{ trans('region-data/kabkot/form.city_district') }}</label>
        <input type="text" name="kabupaten_kota" id="kabupaten-kotum"
            class="form-control @error('kabupaten_kota') is-invalid @enderror"
            value="{{ isset($kabkot) ? $kabkot->kabupaten_kota : old('kabupaten_kota') }}"
            placeholder="{{ trans('region-data/kabkot/form.city_district') }}" required />
        @error('kabupaten_kota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="ibukotum">{{ trans('region-data/kabkot/form.capital') }}</label>
        <input type="text" name="ibukota" id="ibukotum" class="form-control @error('ibukota') is-invalid @enderror"
            value="{{ isset($kabkot) ? $kabkot->ibukota : old('ibukota') }}" placeholder="{{ trans('region-data/kabkot/form.capital') }}"
            required />
        @error('ibukota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="k-bsni">{{ trans('region-data/kabkot/form.kbsni') }}</label>
        <input type="text" name="k_bsni" id="k-bsni" class="form-control @error('k_bsni') is-invalid @enderror"
            value="{{ isset($kabkot) ? $kabkot->k_bsni : old('k_bsni') }}" placeholder="{{ trans('region-data/kabkot/form.kbsni') }}"
            required />
        @error('k_bsni')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
