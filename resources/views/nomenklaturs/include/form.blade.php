<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="code-nomenklatur">{{ __('Code Nomenklatur') }}</label>
            <input type="text" name="code_nomenklatur" id="code-nomenklatur" class="form-control @error('code_nomenklatur') is-invalid @enderror" value="{{ isset($nomenklatur) ? $nomenklatur->code_nomenklatur : old('code_nomenklatur') }}" placeholder="{{ __('Code Nomenklatur') }}" required />
            @error('code_nomenklatur')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="name-nomenklatur">{{ __('Name Nomenklatur') }}</label>
            <input type="text" name="name_nomenklatur" id="name-nomenklatur" class="form-control @error('name_nomenklatur') is-invalid @enderror" value="{{ isset($nomenklatur) ? $nomenklatur->name_nomenklatur : old('name_nomenklatur') }}" placeholder="{{ __('Name Nomenklatur') }}" required />
            @error('name_nomenklatur')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>