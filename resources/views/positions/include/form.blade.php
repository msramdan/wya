<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="code-position">{{ __('Code Position') }}</label>
        <input type="text" name="code_position" id="code-position"
            class="form-control @error('code_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->code_position : old('code_position') }}"
            placeholder="{{ __('Code Position') }}" required />
        @error('code_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="name-position">{{ __('Name Position') }}</label>
        <input type="text" name="name_position" id="name-position"
            class="form-control @error('name_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->name_position : old('name_position') }}"
            placeholder="{{ __('Name Position') }}" required />
        @error('name_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="is-active">{{ __('Is Active') }}</label>
        <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is-active" required>
            <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
            <option value="1"
                {{ isset($position) && $position->is_active == '1' ? 'selected' : (old('is_active') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($position) && $position->is_active == '0' ? 'selected' : (old('is_active') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('is_active')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
