<div class="row mb-2">

    @if (!Auth::user()->roles->first()->hospital_id)
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ __('Hispotal') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ __('Select hispotal') }} --</option>

                @foreach ($hispotals as $hispotal)
                    <option value="{{ $hispotal->id }}"
                        {{ isset($unitItem) && $unitItem->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                        {{ $hispotal->name }}
                    </option>
                @endforeach
            </select>
            @error('hospital_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    @else
        <input type="hidden" readonly value="{{ Auth::user()->roles->first()->hospital_id }}" id="hospital_id"
            name="hospital_id">
    @endif


    <div class="col-md-6 mb-2">
        <label for="code-unit">{{ __('Code Unit') }}</label>
        <input type="text" name="code_unit" id="code-unit"
            class="form-control @error('code_unit') is-invalid @enderror"
            value="{{ isset($unitItem) ? $unitItem->code_unit : old('code_unit') }}" placeholder="{{ __('Code Unit') }}"
            required />
        @error('code_unit')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="unit-name">{{ __('Unit Name') }}</label>
        <input type="text" name="unit_name" id="unit-name"
            class="form-control @error('unit_name') is-invalid @enderror"
            value="{{ isset($unitItem) ? $unitItem->unit_name : old('unit_name') }}"
            placeholder="{{ __('Unit Name') }}" required />
        @error('unit_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
