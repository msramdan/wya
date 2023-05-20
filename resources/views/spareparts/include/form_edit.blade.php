<div class="row mb-2">
    @if (!Auth::user()->roles->first()->hospital_id)
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ __('Hispotal') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ __('Select hispotal') }} --</option>

                @foreach ($hispotals as $hispotal)
                    <option value="{{ $hispotal->id }}"
                        {{ isset($sparepart) && $sparepart->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
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
        <label for="barcode">{{ __('Barcode') }}</label>
        <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->barcode : old('barcode') }}" placeholder="{{ __('Barcode') }}"
            required />
        @error('barcode')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="sparepart-name">{{ __('Sparepart Name') }}</label>
        <input type="text" name="sparepart_name" id="sparepart-name"
            class="form-control @error('sparepart_name') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->sparepart_name : old('sparepart_name') }}"
            placeholder="{{ __('Sparepart Name') }}" required />
        @error('sparepart_name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="merk">{{ __('Merk') }}</label>
        <input type="text" name="merk" id="merk" class="form-control @error('merk') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->merk : old('merk') }}" placeholder="{{ __('Merk') }}"
            required />
        @error('merk')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="sparepart-type">{{ __('Sparepart Type') }}</label>
        <input type="text" name="sparepart_type" id="sparepart-type"
            class="form-control @error('sparepart_type') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->sparepart_type : old('sparepart_type') }}"
            placeholder="{{ __('Sparepart Type') }}" required />
        @error('sparepart_type')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="unit-id">{{ __('Unit Item') }}</label>
        <select class="form-control js-example-basic-multiple @error('unit_id') is-invalid @enderror" name="unit_id"
            id="unit-id" required>
            <option value="" selected disabled>-- {{ __('Select unit item') }} --</option>
            @foreach ($unitItems as $unitItem)
                <option value="{{ $unitItem->id }}"
                    {{ isset($sparepart) && $sparepart->unit_id == $unitItem->id ? 'selected' : (old('unit_id') == $unitItem->id ? 'selected' : '') }}>
                    {{ $unitItem->unit_name }}
                </option>
            @endforeach
        </select>
        @error('unit_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="estimated-price">{{ __('Estimated Price') }}</label>
        <input type="number" name="estimated_price" id="estimated-price"
            class="form-control @error('estimated_price') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->estimated_price : old('estimated_price') }}"
            placeholder="{{ __('Estimated Price') }}" required />

        @error('estimated_price')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="opanme">{{ __('Stock Opname') }}</label>
        <input type="number" name="opname" id="opanme" class="form-control @error('opname') is-invalid @enderror"
            value="{{ isset($sparepart) ? $sparepart->opname : old('opname') }}"
            placeholder="{{ __('Stock Opname') }}" required />

        @error('opname')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <input type="hidden" name="stock" value="{{ isset($sparepart) ? $sparepart->stock : old('stock') }}">
</div>
