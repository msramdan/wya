<div class="row mb-2">
    @if (!Auth::user()->roles->first()->hospital_id)
        <div class="col-md-6 mb-2">
            <label for="hospital_id">{{ trans('main-data/unit-item/form.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id" required>
                <option value="" selected disabled>-- {{ trans('main-data/unit-item/form.select_hospital') }} --
                </option>

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
        <label for="no-peminjaman">{{ __('No Peminjaman') }}</label>
        <input type="text" name="no_peminjaman" id="no-peminjaman"
            class="form-control @error('no_peminjaman') is-invalid @enderror"
            value="{{ isset($loan) ? $loan->no_peminjaman : $noPeminjaman }}"
            placeholder="{{ __('No Peminjaman') }}" required readonly />
        @error('no_peminjaman')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-3 mb-2">
        <label for="lokasi-asal-id">{{ __('Resource location') }}</label>
        <select class="form-control js-example-basic-multiple @error('lokasi_asal_id') is-invalid @enderror" name="lokasi_asal_id"
            id="lokasi-asal-id" required>
            <option value="" selected disabled>-- {{ __('Select Resource location') }} --</option>
        </select>
        @error('lokasi_asal_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="lokasi-peminjam-id">{{ __('Destination location') }}</label>
        <select class="form-control js-example-basic-multiple @error('lokasi_peminjam_id') is-invalid @enderror" name="lokasi_peminjam_id"
            id="lokasi-peminjam-id" required>
            <option value="" selected disabled>-- {{ __('Select Destination location') }} --</option>
        </select>
        @error('lokasi_peminjam_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>


    <div class="col-md-6 mb-2">
        <label for="equipment-id">{{ __('Equipment') }}</label>
        <select class="form-control js-example-basic-multiple @error('equipment_id') is-invalid @enderror" name="equipment_id" id="equipment-id"
            required>
            <option value="" selected disabled>-- {{ __('Select equipment') }} --</option>
        </select>
        @error('equipment_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>



    <div class="col-md-6 mb-2">
        <label for="waktu-pinjam">{{ __('Waktu Pinjam') }}</label>
        <input type="datetime-local" name="waktu_pinjam" id="waktu-pinjam"
            class="form-control @error('waktu_pinjam') is-invalid @enderror"
            value="{{ isset($loan) && $loan->waktu_pinjam ? $loan->waktu_pinjam->format('Y-m-d\TH:i') : old('waktu_pinjam') }}"
            placeholder="{{ __('Waktu Pinjam') }}" required />
        @error('waktu_pinjam')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="alasan-peminjaman">{{ __('Alasan Peminjaman') }}</label>
            <textarea name="alasan_peminjaman" id="alasan-peminjaman"
                class="form-control @error('alasan_peminjaman') is-invalid @enderror" placeholder="{{ __('Alasan Peminjaman') }}"
                required>{{ isset($loan) ? $loan->alasan_peminjaman : old('alasan_peminjaman') }}</textarea>
            @error('alasan_peminjaman')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-2">
        <label for="pic-penanggungjawab">{{ __('Pic Penanggungjawab') }}</label>
        <select class="form-control js-example-basic-multiple @error('pic_penanggungjawab') is-invalid @enderror" name="pic_penanggungjawab" id="pic-penanggungjawab"
            required>
            <option value="" selected disabled>-- {{ __('Select') }} --</option>
        </select>
        @error('pic_penanggungjawab')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>



    @isset($loan)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($loan->bukti_peminjaman == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Bukti Peminjaman"
                            class="rounded mb-2 mt-2" alt="Bukti Peminjaman" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/bukti_peminjamen/' . $loan->bukti_peminjaman) }}"
                            alt="Bukti Peminjaman" class="rounded mb-2 mt-2" width="200" height="150"
                            style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="bukti_peminjaman">{{ __('Bukti Peminjaman') }}</label>
                        <input type="file" name="bukti_peminjaman"
                            class="form-control @error('bukti_peminjaman') is-invalid @enderror" id="bukti_peminjaman">

                        @error('bukti_peminjaman')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="bukti_peminjamanHelpBlock" class="form-text">
                            {{ __('Leave the bukti peminjaman blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="bukti_peminjaman">{{ __('Bukti Peminjaman') }}</label>
                <input type="file" name="bukti_peminjaman"
                    class="form-control @error('bukti_peminjaman') is-invalid @enderror" id="bukti_peminjaman" required>

                @error('bukti_peminjaman')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
</div>
