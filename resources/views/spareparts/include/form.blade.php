<div class="row">
    <div class="col-md-6">
        @if (!Auth::user()->roles->first()->hospital_id)
            <div class="col-md-12 mb-2">
                <label for="hospital_id">{{ trans('inventory/sparepart/form.hospital') }}</label>
                <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                    name="hospital_id" id="hospital_id" required>
                    <option value="" selected disabled>-- {{ trans('inventory/sparepart/form.hospital') }} --
                    </option>

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
        <div class="col-md-12 mb-2">
            <label for="barcode">{{ trans('inventory/sparepart/form.barcode') }}</label>
            <input type="text" name="barcode" id="barcode"
                class="form-control @error('barcode') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->barcode : old('barcode') }}"
                placeholder="{{ trans('inventory/sparepart/form.barcode') }}" required />
            @error('barcode')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="col-md-12 mb-2">
            <label for="sparepart-name">{{ trans('inventory/sparepart/form.sparepart_name') }}</label>
            <input type="text" name="sparepart_name" id="sparepart-name"
                class="form-control @error('sparepart_name') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->sparepart_name : old('sparepart_name') }}"
                placeholder="{{ trans('inventory/sparepart/form.sparepart_name') }}" required />
            @error('sparepart_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="col-md-12 mb-2">
            <label for="merk">{{ trans('inventory/sparepart/form.merk') }}</label>
            <input type="text" name="merk" id="merk" class="form-control @error('merk') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->merk : old('merk') }}"
                placeholder="{{ trans('inventory/sparepart/form.merk') }}" required />
            @error('merk')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="col-md-12 mb-2">
            <label for="sparepart-type">{{ trans('inventory/sparepart/form.sparepart_type') }}</label>
            <input type="text" name="sparepart_type" id="sparepart-type"
                class="form-control @error('sparepart_type') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->sparepart_type : old('sparepart_type') }}"
                placeholder="{{ trans('inventory/sparepart/form.sparepart_type') }}" required />
            @error('sparepart_type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="col-md-12 mb-2">
            <label for="unit-id">{{ trans('inventory/sparepart/form.unit_item') }}</label>
            <select class="form-control js-example-basic-multiple @error('unit_id') is-invalid @enderror" name="unit_id"
                id="unit-id" required>
                <option value="" selected disabled>-- {{ trans('inventory/sparepart/form.select_unit_item') }} --
                </option>
            </select>
            @error('unit_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="col-md-12 mb-2">
            <label for="estimated-price">{{ trans('inventory/sparepart/form.estimated_price') }}</label>
            <input type="number" name="estimated_price" id="estimated-price"
                class="form-control @error('estimated_price') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->estimated_price : old('estimated_price') }}"
                placeholder="{{ trans('inventory/sparepart/form.estimated_price') }}" required />

            @error('estimated_price')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="col-md-12 mb-2">
            <label for="opname">{{ trans('inventory/sparepart/form.stock_opname') }}</label>
            <input type="number" name="opname" id="opname"
                class="form-control @error('opname') is-invalid @enderror"
                value="{{ isset($sparepart) ? $sparepart->opname : old('opname') }}"
                placeholder="{{ trans('inventory/sparepart/form.stock_opname') }}" required />

            @error('opname')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <input type="hidden" name="stock" value="0">
    </div>

    <div class="col-md-6">
        {{-- photo --}}
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-file" aria-hidden="true"></i> Photo Sparepart <span
                            style="color:red; font-size:11px">(
                            Rekomendasi gambar adalah jpg/png ) </span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas3" id="add_berkas3"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>
                            {{ trans('inventory/equipment/form.add_photo') }}</button>
                        <table class="table table-bordered" id="dynamic_field3">
                            <thead>
                                <tr>
                                    <th>{{ trans('inventory/equipment/form.desc') }}</th>
                                    <th style="width: 200px">{{ trans('inventory/equipment/form.file') }}</th>
                                    <th>{{ trans('inventory/equipment/form.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
