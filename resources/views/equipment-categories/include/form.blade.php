<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="code-categoty">{{ __('Code Categoty') }}</label>
            <input type="text" name="code_categoty" id="code-categoty" class="form-control @error('code_categoty') is-invalid @enderror" value="{{ isset($equipmentCategory) ? $equipmentCategory->code_categoty : old('code_categoty') }}" placeholder="{{ __('Code Categoty') }}" required />
            @error('code_categoty')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="category-name">{{ __('Category Name') }}</label>
            <input type="text" name="category_name" id="category-name" class="form-control @error('category_name') is-invalid @enderror" value="{{ isset($equipmentCategory) ? $equipmentCategory->category_name : old('category_name') }}" placeholder="{{ __('Category Name') }}" required />
            @error('category_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>