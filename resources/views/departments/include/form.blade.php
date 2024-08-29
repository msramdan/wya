<div class="row mb-2">

    <div class="col-md-6 mb-3">
        <label for="code-department">{{ trans('employee/departement/form.code') }}</label>
        <input type="text" name="code_department" id="code-department"
            class="form-control @error('code_department') is-invalid @enderror"
            value="{{ isset($department) ? $department->code_department : old('code_department') }}"
            placeholder="{{ trans('employee/departement/form.code') }}" required />
        @error('code_department')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name-department">{{ trans('employee/departement/form.name') }}</label>
        <input type="text" name="name_department" id="name-department"
            class="form-control @error('name_department') is-invalid @enderror"
            value="{{ isset($department) ? $department->name_department : old('name_department') }}"
            placeholder="{{ trans('employee/departement/form.name') }}" required />
        @error('name_department')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
