<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="code-categoty">{{ trans('main-data/equipment/category/form.category_code') }} </label>
        <input type="text" name="code_categoty" id="code-categoty"
            class="form-control @error('code_categoty') is-invalid @enderror"
            value="{{ isset($equipmentCategory) ? $equipmentCategory->code_categoty : old('code_categoty') }}"
            placeholder="{{ trans('main-data/equipment/category/form.category_code') }} " required />
        @error('code_categoty')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="category-name">{{ trans('main-data/equipment/category/form.category_name') }} </label>
        <input type="text" name="category_name" id="category-name"
            class="form-control @error('category_name') is-invalid @enderror"
            value="{{ isset($equipmentCategory) ? $equipmentCategory->category_name : old('category_name') }}"
            placeholder="{{ trans('main-data/equipment/category/form.category_name') }} " required />
        @error('category_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
