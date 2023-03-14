<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="barcode">{{ __('Barcode') }}</label>
        <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->barcode : old('barcode') }}" placeholder="{{ __('Barcode') }}"
            required />
        @error('barcode')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="nomenklatur-id">{{ __('Nomenklatur') }}</label>
        <select class="form-control @error('nomenklatur_id') is-invalid @enderror" name="nomenklatur_id"
            id="nomenklatur-id" required>
            <option value="" selected disabled>-- {{ __('Select nomenklatur') }} --</option>

            @foreach ($nomenklaturs as $nomenklatur)
                <option value="{{ $nomenklatur->id }}"
                    {{ isset($equipment) && $equipment->nomenklatur_id == $nomenklatur->id ? 'selected' : (old('nomenklatur_id') == $nomenklatur->id ? 'selected' : '') }}>
                    {{ $nomenklatur->code_nomenklatur }}
                </option>
            @endforeach
        </select>
        @error('nomenklatur_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="equipment-category-id">{{ __('Equipment Category') }}</label>
        <select class="form-control @error('equipment_category_id') is-invalid @enderror" name="equipment_category_id"
            id="equipment-category-id" required>
            <option value="" selected disabled>-- {{ __('Select equipment category') }} --</option>

            @foreach ($equipmentCategories as $equipmentCategory)
                <option value="{{ $equipmentCategory->id }}"
                    {{ isset($equipment) && $equipment->equipment_category_id == $equipmentCategory->id ? 'selected' : (old('equipment_category_id') == $equipmentCategory->id ? 'selected' : '') }}>
                    {{ $equipmentCategory->code_categoty }}
                </option>
            @endforeach
        </select>
        @error('equipment_category_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="manufacturer">{{ __('Manufacturer') }}</label>
        <input type="text" name="manufacturer" id="manufacturer"
            class="form-control @error('manufacturer') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->manufacturer : old('manufacturer') }}"
            placeholder="{{ __('Manufacturer') }}" required />
        @error('manufacturer')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="type">{{ __('Type') }}</label>
        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->type : old('type') }}" placeholder="{{ __('Type') }}"
            required />
        @error('type')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="serial-number">{{ __('Serial Number') }}</label>
        <input type="text" name="serial_number" id="serial-number"
            class="form-control @error('serial_number') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->serial_number : old('serial_number') }}"
            placeholder="{{ __('Serial Number') }}" required />
        @error('serial_number')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="vendor-id">{{ __('Vendor') }}</label>
        <select class="form-control @error('vendor_id') is-invalid @enderror" name="vendor_id" id="vendor-id" required>
            <option value="" selected disabled>-- {{ __('Select vendor') }} --</option>

            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}"
                    {{ isset($equipment) && $equipment->vendor_id == $vendor->id ? 'selected' : (old('vendor_id') == $vendor->id ? 'selected' : '') }}>
                    {{ $vendor->code_vendor }}
                </option>
            @endforeach
        </select>
        @error('vendor_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="condition">{{ __('Condition') }}</label>
        <select class="form-control @error('condition') is-invalid @enderror" name="condition" id="condition" required>
            <option value="" selected disabled>-- {{ __('Select condition') }} --</option>
            <option value="1"
                {{ isset($equipment) && $equipment->condition == '1' ? 'selected' : (old('condition') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($equipment) && $equipment->condition == '0' ? 'selected' : (old('condition') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('condition')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="risk-level">{{ __('Risk Level') }}</label>
        <select class="form-control @error('risk_level') is-invalid @enderror" name="risk_level" id="risk-level"
            required>
            <option value="" selected disabled>-- {{ __('Select risk level') }} --</option>
            <option value="1"
                {{ isset($equipment) && $equipment->risk_level == '1' ? 'selected' : (old('risk_level') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($equipment) && $equipment->risk_level == '0' ? 'selected' : (old('risk_level') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('risk_level')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="equipment-location-id">{{ __('Equipment Location') }}</label>
        <select class="form-control @error('equipment_location_id') is-invalid @enderror" name="equipment_location_id"
            id="equipment-location-id" required>
            <option value="" selected disabled>-- {{ __('Select equipment location') }} --</option>

            @foreach ($equipmentLocations as $equipmentLocation)
                <option value="{{ $equipmentLocation->id }}"
                    {{ isset($equipment) && $equipment->equipment_location_id == $equipmentLocation->id ? 'selected' : (old('equipment_location_id') == $equipmentLocation->id ? 'selected' : '') }}>
                    {{ $equipmentLocation->code_location }}
                </option>
            @endforeach
        </select>
        @error('equipment_location_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="financing-code">{{ __('Financing Code') }}</label>
        <input type="text" name="financing_code" id="financing-code"
            class="form-control @error('financing_code') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->financing_code : old('financing_code') }}"
            placeholder="{{ __('Financing Code') }}" required />
        @error('financing_code')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="photo">{{ __('Photo') }}</label>
        <input type="text" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror"
            value="{{ isset($equipment) ? $equipment->photo : old('photo') }}" placeholder="{{ __('Photo') }}"
            required />
        @error('photo')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
