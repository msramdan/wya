<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="name-category-vendor">{{ __('Name Category Vendors') }}</label>
            <input type="text" name="name_category_vendors" id="name-category-vendor" class="form-control @error('name_category_vendors') is-invalid @enderror" value="{{ isset($categoryVendor) ? $categoryVendor->name_category_vendors : old('name_category_vendors') }}" placeholder="{{ __('Name Category Vendors') }}" required />
            @error('name_category_vendors')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>