<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <label for="code-department">{{ __('Code Department') }}</label>
        <input type="text" name="code_department" id="code-department"
            class="form-control @error('code_department') is-invalid @enderror"
            value="{{ isset($department) ? $department->code_department : old('code_department') }}"
            placeholder="{{ __('Code Department') }}" required />
        @error('code_department')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name-department">{{ __('Name Department') }}</label>
        <input type="text" name="name_department" id="name-department"
            class="form-control @error('name_department') is-invalid @enderror"
            value="{{ isset($department) ? $department->name_department : old('name_department') }}"
            placeholder="{{ __('Name Department') }}" required />
        @error('name_department')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="is-active">{{ __('Is Active') }}</label>
        <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is-active" required>
            <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
            <option value="1"
                {{ isset($department) && $department->is_active == '1' ? 'selected' : (old('is_active') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($department) && $department->is_active == '0' ? 'selected' : (old('is_active') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('is_active')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
