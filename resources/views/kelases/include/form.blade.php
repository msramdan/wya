<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kela">{{ __('Kelas') }}</label>
            <input type="text" name="kelas" id="kela" class="form-control @error('kelas') is-invalid @enderror" value="{{ isset($kelase) ? $kelase->kelas : old('kelas') }}" placeholder="{{ __('Kelas') }}" required />
            @error('kelas')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>