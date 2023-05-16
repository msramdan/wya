<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="hospital_id">{{ __('Hispotal') }}</label>
        <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
            name="hospital_id" id="hospital_id" required>
            <option value="" selected disabled>-- {{ __('Select hispotal') }} --</option>

            @foreach ($hispotals as $hispotal)
                <option value="{{ $hispotal->id }}"
                    {{ isset($equipmentCategory) && $equipmentCategory->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
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
    <div class="col-md-6 mb-2">
        <label for="code-categoty">{{ __('Code Categoty') }}</label>
        <input type="text" name="code_categoty" id="code-categoty"
            class="form-control @error('code_categoty') is-invalid @enderror"
            value="{{ isset($equipmentCategory) ? $equipmentCategory->code_categoty : old('code_categoty') }}"
            placeholder="{{ __('Code Categoty') }}" required />
        @error('code_categoty')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="category-name">{{ __('Category Name') }}</label>
        <input type="text" name="category_name" id="category-name"
            class="form-control @error('category_name') is-invalid @enderror"
            value="{{ isset($equipmentCategory) ? $equipmentCategory->category_name : old('category_name') }}"
            placeholder="{{ __('Category Name') }}" required />
        @error('category_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
