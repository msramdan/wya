<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama">{{ __('Nama') }}</label>
        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
            value="{{ isset($aduan) ? $aduan->nama : old('nama') }}" placeholder="{{ __('Nama') }}" required />
        @error('nama')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="email">{{ __('Email') }}</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ isset($aduan) ? $aduan->email : old('email') }}" placeholder="{{ __('Email') }}" required />
        @error('email')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="judul">{{ __('Judul') }}</label>
        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror"
            value="{{ isset($aduan) ? $aduan->judul : old('judul') }}" placeholder="{{ __('Judul') }}" required />
        @error('judul')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('Keterangan') }}" required>{{ isset($aduan) ? $aduan->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="tanggal">{{ __('Tanggal') }}</label>
        <input type="datetime-local" name="tanggal" id="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            value="{{ isset($aduan) && $aduan->tanggal ? $aduan->tanggal->format('Y-m-d\TH:i') : old('tanggal') }}"
            placeholder="{{ __('Tanggal') }}" required />
        @error('tanggal')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="type">{{ __('Type') }}</label>
        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
            <option value="" selected disabled>-- {{ __('Select type') }} --</option>
            <option value="Public"
                {{ isset($aduan) && $aduan->type == 'Public' ? 'selected' : (old('type') == 'Public' ? 'selected' : '') }}>
                Public</option>
            <option value="Private"
                {{ isset($aduan) && $aduan->type == 'Private' ? 'selected' : (old('type') == 'Private' ? 'selected' : '') }}>
                Private</option>
        </select>
        @error('type')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="is-read">{{ __('Is Read') }}</label>
        <select class="form-control @error('is_read') is-invalid @enderror" name="is_read" id="is-read" required>
            <option value="" selected disabled>-- {{ __('Select is read') }} --</option>
            <option value="Yes"
                {{ isset($aduan) && $aduan->is_read == 'Yes' ? 'selected' : (old('is_read') == 'Yes' ? 'selected' : '') }}>
                Yes</option>
            <option value="No"
                {{ isset($aduan) && $aduan->is_read == 'No' ? 'selected' : (old('is_read') == 'No' ? 'selected' : '') }}>
                No</option>
        </select>
        @error('is_read')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
