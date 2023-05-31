<div class="row mb-2">
    @if (!Auth::user()->roles->first()->hospital_id)
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ trans('main-data/equipment/category/form.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ trans('main-data/equipment/category/form.select_hospital') }} --</option>

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
