<div class="row mb-2">
    @if (!session('sessionHospital'))
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ trans('employee/type/form.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ trans('employee/type/form.select_hospital') }} --</option>
                @if (isset($employeeType))
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ $employeeType->hospital_id == $hispotal->id ? 'selected' : '' }}
                            {{ $employeeType->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                            {{ $hispotal->name }}
                        </option>
                    @endforeach
                @else
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ isset($employeeType) && $employeeType->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                            {{ $hispotal->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('hospital_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    @else
        <input type="hidden" readonly value="{{ session('sessionHospital') }}" id="hospital_id"
            name="hospital_id">
    @endif
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
