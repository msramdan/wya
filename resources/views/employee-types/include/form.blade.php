<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="name-employee-type">{{ trans('employee/type/index.name') }}</label>
        <input type="text" name="name_employee_type" id="name-employee-type"
            class="form-control @error('name_employee_type') is-invalid @enderror"
            value="{{ isset($employeeType) ? $employeeType->name_employee_type : old('name_employee_type') }}"
            placeholder="{{ trans('employee/type/index.name') }}" required />
        @error('name_employee_type')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
