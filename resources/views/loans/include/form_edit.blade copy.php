<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="no-peminjaman">{{ __('No Peminjaman') }}</label>
        <input type="text" name="no_peminjaman" id="no-peminjaman"
            class="form-control @error('no_peminjaman') is-invalid @enderror"
            value="{{ isset($loan) ? $loan->no_peminjaman : old('no_peminjaman') }}"
            placeholder="{{ __('No Peminjaman') }}" required />
        @error('no_peminjaman')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    {{-- <div class="col-md-6 mb-2">
        <label for="equipment-id">{{ __('Equipment') }}</label>
        <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" id="equipment-id"
            required>
            <option value="" selected disabled>-- {{ __('Select equipment') }} --</option>

            @foreach ($equipment as $equipment)
                <option value="{{ $equipment->id }}"
                    {{ isset($loan) && $loan->equipment_id == $equipment->id ? 'selected' : (old('equipment_id') == $equipment->id ? 'selected' : '') }}>
                    {{ $equipment->condition }}
                </option>
            @endforeach
        </select>
        @error('equipment_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div> --}}
    <div class="col-md-6 mb-2">
        <label for="hospital-id">{{ __('Hospital') }}</label>
        <select class="form-control @error('hospital_id') is-invalid @enderror" name="hospital_id" id="hospital-id"
            required>
            <option value="" selected disabled>-- {{ __('Select hospital') }} --</option>

            @foreach ($hispotals as $hospital)
                <option value="{{ $hospital->id }}"
                    {{ isset($loan) && $loan->hospital_id == $hospital->id ? 'selected' : (old('hospital_id') == $hospital->id ? 'selected' : '') }}>
                    {{ $hospital->name }}
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
        <label for="lokasi-asal-id">{{ __('Equipment Location') }}</label>
        <select class="form-control @error('lokasi_asal_id') is-invalid @enderror" name="lokasi_asal_id"
            id="lokasi-asal-id" required>
            <option value="" selected disabled>-- {{ __('Select equipment location') }} --</option>

            @foreach ($equipmentLocations as $equipmentLocation)
                <option value="{{ $equipmentLocation->id }}"
                    {{ isset($loan) && $loan->lokasi_asal_id == $equipmentLocation->id ? 'selected' : (old('lokasi_asal_id') == $equipmentLocation->id ? 'selected' : '') }}>
                    {{ $equipmentLocation->location_name }}
                </option>
            @endforeach
        </select>
        @error('lokasi_asal_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="lokasi-peminjam-id">{{ __('Equipment Location') }}</label>
        <select class="form-control @error('lokasi_peminjam_id') is-invalid @enderror" name="lokasi_peminjam_id"
            id="lokasi-peminjam-id" required>
            <option value="" selected disabled>-- {{ __('Select equipment location') }} --</option>

            @foreach ($equipmentLocations as $equipmentLocation)
                <option value="{{ $equipmentLocation->id }}"
                    {{ isset($loan) && $loan->lokasi_peminjam_id == $equipmentLocation->id ? 'selected' : (old('lokasi_peminjam_id') == $equipmentLocation->id ? 'selected' : '') }}>
                    {{ $equipmentLocation->location_name }}
                </option>
            @endforeach
        </select>
        @error('lokasi_peminjam_id')
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
    <div class="col-md-6 mb-2">
        <label for="waktu-dikembalikan">{{ __('Waktu Dikembalikan') }}</label>
        <input type="datetime-local" name="waktu_dikembalikan" id="waktu-dikembalikan"
            class="form-control @error('waktu_dikembalikan') is-invalid @enderror"
            value="{{ isset($loan) && $loan->waktu_dikembalikan ? $loan->waktu_dikembalikan->format('Y-m-d\TH:i') : old('waktu_dikembalikan') }}"
            placeholder="{{ __('Waktu Dikembalikan') }}" />
        @error('waktu_dikembalikan')
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
        <label for="status-peminjaman">{{ __('Status Peminjaman') }}</label>
        <select class="form-control @error('status_peminjaman') is-invalid @enderror" name="status_peminjaman"
            id="status-peminjaman" required>
            <option value="" selected disabled>-- {{ __('Select status peminjaman') }} --</option>
            <option value="Sudah dikembalikan"
                {{ isset($loan) && $loan->status_peminjaman == 'Sudah dikembalikan' ? 'selected' : (old('status_peminjaman') == 'Sudah dikembalikan' ? 'selected' : '') }}>
                Sudah dikembalikan</option>
            <option value="Belum dikembalikan"
                {{ isset($loan) && $loan->status_peminjaman == 'Belum dikembalikan' ? 'selected' : (old('status_peminjaman') == 'Belum dikembalikan' ? 'selected' : '') }}>
                Belum dikembalikan</option>
        </select>
        @error('status_peminjaman')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="catatan-pengembalian">{{ __('Catatan Pengembalian') }}</label>
            <textarea name="catatan_pengembalian" id="catatan-pengembalian"
                class="form-control @error('catatan_pengembalian') is-invalid @enderror"
                placeholder="{{ __('Catatan Pengembalian') }}">{{ isset($loan) ? $loan->catatan_pengembalian : old('catatan_pengembalian') }}</textarea>
            @error('catatan_pengembalian')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="pic-penanggungjawab">{{ __('Pic Penanggungjawab') }}</label>
        <input type="text" name="pic_penanggungjawab" id="pic-penanggungjawab"
            class="form-control @error('pic_penanggungjawab') is-invalid @enderror"
            value="{{ isset($loan) ? $loan->pic_penanggungjawab : old('pic_penanggungjawab') }}"
            placeholder="{{ __('Pic Penanggungjawab') }}" required />
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
    @isset($loan)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($loan->bukti_pengembalian == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Bukti Pengembalian"
                            class="rounded mb-2 mt-2" alt="Bukti Pengembalian" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/bukti_pengembalians/' . $loan->bukti_pengembalian) }}"
                            alt="Bukti Pengembalian" class="rounded mb-2 mt-2" width="200" height="150"
                            style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="bukti_pengembalian">{{ __('Bukti Pengembalian') }}</label>
                        <input type="file" name="bukti_pengembalian"
                            class="form-control @error('bukti_pengembalian') is-invalid @enderror"
                            id="bukti_pengembalian">

                        @error('bukti_pengembalian')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="bukti_pengembalianHelpBlock" class="form-text">
                            {{ __('Leave the bukti pengembalian blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="bukti_pengembalian">{{ __('Bukti Pengembalian') }}</label>
                <input type="file" name="bukti_pengembalian"
                    class="form-control @error('bukti_pengembalian') is-invalid @enderror" id="bukti_pengembalian">

                @error('bukti_pengembalian')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6 mb-2">
        <label for="user-created">{{ __('User') }}</label>
        <select class="form-control @error('user_created') is-invalid @enderror" name="user_created"
            id="user-created" required>
            <option value="" selected disabled>-- {{ __('Select user') }} --</option>

            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($loan) && $loan->user_created == $user->id ? 'selected' : (old('user_created') == $user->id ? 'selected' : '') }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('user_created')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="user-updated">{{ __('User') }}</label>
        <select class="form-control @error('user_updated') is-invalid @enderror" name="user_updated"
            id="user-updated">
            <option value="" selected disabled>-- {{ __('Select user') }} --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($loan) && $loan->user_updated == $user->id ? 'selected' : (old('user_updated') == $user->id ? 'selected' : '') }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('user_updated')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
