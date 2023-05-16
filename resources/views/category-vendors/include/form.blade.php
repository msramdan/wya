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
        <label for="name-category-vendor">{{ __('Name Category Vendors') }}</label>
        <input type="text" name="name_category_vendors" id="name-category-vendor"
            class="form-control @error('name_category_vendors') is-invalid @enderror"
            value="{{ isset($categoryVendor) ? $categoryVendor->name_category_vendors : old('name_category_vendors') }}"
            placeholder="{{ __('Name Category Vendors') }}" required />
        @error('name_category_vendors')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
