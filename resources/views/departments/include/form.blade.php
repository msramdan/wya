<div class="row mb-2">
    @if (!session('sessionHospital'))
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ trans('employee/departement/form.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ trans('employee/departement/form.select_hospital') }} --
                </option>
                @if (isset($department))
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ $department->hospital_id == $hispotal->id ? 'selected' : '' }}
                            {{ $department->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                            {{ $hispotal->name }}
                        </option>
                    @endforeach
                @else
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ isset($department) && $department->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
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
