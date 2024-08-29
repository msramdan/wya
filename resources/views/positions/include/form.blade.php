<div class="row mb-2">
    @if (!session('sessionHospital'))
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ trans('employee/position/show.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ trans('employee/position/show.select_hospital') }} --
                </option>
                @if (isset($position))
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ $position->hospital_id == $hispotal->id ? 'selected' : '' }}
                            {{ $position->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                            {{ $hispotal->name }}
                        </option>
                    @endforeach
                @else
                    @foreach ($hispotals as $hispotal)
                        <option value="{{ $hispotal->id }}"
                            {{ isset($position) && $position->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
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
        <label for="code-position">{{ trans('employee/position/show.code') }}</label>
        <input type="text" name="code_position" id="code-position"
            class="form-control @error('code_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->code_position : old('code_position') }}"
            placeholder="{{ trans('employee/position/show.code') }}" required />
        @error('code_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name-position">{{ trans('employee/position/show.name') }}</label>
        <input type="text" name="name_position" id="name-position"
            class="form-control @error('name_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->name_position : old('name_position') }}"
            placeholder="{{ trans('employee/position/show.name') }}" required />
        @error('name_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
