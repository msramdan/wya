<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="code-unit">{{ trans('main-data/unit-item/form.unit_code') }}</label>
        <input type="text" name="code_unit" id="code-unit"
            class="form-control @error('code_unit') is-invalid @enderror"
            value="{{ isset($unitItem) ? $unitItem->code_unit : old('code_unit') }}"
            placeholder="{{ trans('main-data/unit-item/form.unit_code') }}" required />
        @error('code_unit')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="unit-name">{{ trans('main-data/unit-item/form.unit_name') }}</label>
        <input type="text" name="unit_name" id="unit-name"
            class="form-control @error('unit_name') is-invalid @enderror"
            value="{{ isset($unitItem) ? $unitItem->unit_name : old('unit_name') }}"
            placeholder="{{ trans('main-data/unit-item/form.unit_name') }}" required />
        @error('unit_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
