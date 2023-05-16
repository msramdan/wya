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
        <label for="code-location">{{ __('Code Location') }}</label>
        <input type="text" name="code_location" id="code-location"
            class="form-control @error('code_location') is-invalid @enderror"
            value="{{ isset($equipmentLocation) ? $equipmentLocation->code_location : old('code_location') }}"
            placeholder="{{ __('Code Location') }}" required />
        @error('code_location')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="location-name">{{ __('Location Name') }}</label>
        <input type="text" name="location_name" id="location-name"
            class="form-control @error('location_name') is-invalid @enderror"
            value="{{ isset($equipmentLocation) ? $equipmentLocation->location_name : old('location_name') }}"
            placeholder="{{ __('Location Name') }}" required />
        @error('location_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
