<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="code-location">{{ __('Code Location') }}</label>
            <input type="text" name="code_location" id="code-location" class="form-control @error('code_location') is-invalid @enderror" value="{{ isset($equipmentLocation) ? $equipmentLocation->code_location : old('code_location') }}" placeholder="{{ __('Code Location') }}" required />
            @error('code_location')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="location-name">{{ __('Location Name') }}</label>
            <input type="text" name="location_name" id="location-name" class="form-control @error('location_name') is-invalid @enderror" value="{{ isset($equipmentLocation) ? $equipmentLocation->location_name : old('location_name') }}" placeholder="{{ __('Location Name') }}" required />
            @error('location_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>