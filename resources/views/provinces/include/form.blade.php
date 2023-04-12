<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="provinsi">{{ __('Provinsi') }}</label>
            <input type="text" name="provinsi" id="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ isset($province) ? $province->provinsi : old('provinsi') }}" placeholder="{{ __('Provinsi') }}" required />
            @error('provinsi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="ibukotum">{{ __('Ibukota') }}</label>
            <input type="text" name="ibukota" id="ibukotum" class="form-control @error('ibukota') is-invalid @enderror" value="{{ isset($province) ? $province->ibukota : old('ibukota') }}" placeholder="{{ __('Ibukota') }}" required />
            @error('ibukota')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="p-bsni">{{ __('P Bsni') }}</label>
            <input type="text" name="p_bsni" id="p-bsni" class="form-control @error('p_bsni') is-invalid @enderror" value="{{ isset($province) ? $province->p_bsni : old('p_bsni') }}" placeholder="{{ __('P Bsni') }}" required />
            @error('p_bsni')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>