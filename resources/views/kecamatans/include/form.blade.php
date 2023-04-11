<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="kabkot-id">{{ __('Kabkot') }}</label>
        <select class="form-control js-example-basic-multiple @error('kabkot_id') is-invalid @enderror" name="kabkot_id"
            id="kabkot-id" required>
            <option value="" selected disabled>-- {{ __('Select kabkot') }} --</option>

            @foreach ($kabkots as $kabkot)
                <option value="{{ $kabkot->id }}"
                    {{ isset($kecamatan) && $kecamatan->kabkot_id == $kabkot->id ? 'selected' : (old('kabkot_id') == $kabkot->id ? 'selected' : '') }}>
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

    <div class="col-md-6 mb-2">
        <label for="kecamatan">{{ __('Kecamatan') }}</label>
        <input type="text" name="kecamatan" id="kecamatan"
            class="form-control @error('kecamatan') is-invalid @enderror"
            value="{{ isset($kecamatan) ? $kecamatan->kecamatan : old('kecamatan') }}"
            placeholder="{{ __('Kecamatan') }}" required />
        @error('kecamatan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
