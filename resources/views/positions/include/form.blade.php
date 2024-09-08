<div class="row mb-2">

    <div class="col-md-6 mb-3">
        <label for="code-position">Kode Jabatan</label>
        <input type="text" name="code_position" id="code-position"
            class="form-control @error('code_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->code_position : old('code_position') }}"
            placeholder="Kode Jabatan" required />
        @error('code_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name-position">Nama Jabatan</label>
        <input type="text" name="name_position" id="name-position"
            class="form-control @error('name_position') is-invalid @enderror"
            value="{{ isset($position) ? $position->name_position : old('name_position') }}"
            placeholder="Nama Jabatan" required />
        @error('name_position')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
