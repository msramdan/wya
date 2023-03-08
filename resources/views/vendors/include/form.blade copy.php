<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="code-vendor">{{ __('Code Vendor') }}</label>
            <input type="text" name="code_vendor" id="code-vendor" class="form-control @error('code_vendor') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->code_vendor : old('code_vendor') }}" placeholder="{{ __('Code Vendor') }}" required />
            @error('code_vendor')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="name-vendor">{{ __('Name Vendor') }}</label>
            <input type="text" name="name_vendor" id="name-vendor" class="form-control @error('name_vendor') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->name_vendor : old('name_vendor') }}" placeholder="{{ __('Name Vendor') }}" required />
            @error('name_vendor')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="category-vendor-id">{{ __('Category Vendor') }}</label>
                                    <select class="form-control @error('category_vendor_id') is-invalid @enderror" name="category_vendor_id" id="category-vendor-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select category vendor') }} --</option>
                                        
                        @foreach ($categoryVendors as $categoryVendor)
                            <option value="{{ $categoryVendor->id }}" {{ isset($vendor) && $vendor->category_vendor_id == $categoryVendor->id ? 'selected' : (old('category_vendor_id') == $categoryVendor->id ? 'selected' : '') }}>
                                {{ $categoryVendor->name_category_vendors }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('category_vendor_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="email">{{ __('Email') }}</label>
            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->email : old('email') }}" placeholder="{{ __('Email') }}" required />
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="provinsi-id">{{ __('Province') }}</label>
                                    <select class="form-control @error('provinsi_id') is-invalid @enderror" name="provinsi_id" id="provinsi-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select province') }} --</option>
                                        
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" {{ isset($vendor) && $vendor->provinsi_id == $province->id ? 'selected' : (old('provinsi_id') == $province->id ? 'selected' : '') }}>
                                {{ $province->provinsi }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('provinsi_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="kabkot-id">{{ __('Kabkot') }}</label>
                                    <select class="form-control @error('kabkot_id') is-invalid @enderror" name="kabkot_id" id="kabkot-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select kabkot') }} --</option>
                                        
                        @foreach ($kabkots as $kabkot)
                            <option value="{{ $kabkot->id }}" {{ isset($vendor) && $vendor->kabkot_id == $kabkot->id ? 'selected' : (old('kabkot_id') == $kabkot->id ? 'selected' : '') }}>
                                {{ $kabkot->provinsi_id }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('kabkot_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="kecamatan-id">{{ __('Kecamatan') }}</label>
                                    <select class="form-control @error('kecamatan_id') is-invalid @enderror" name="kecamatan_id" id="kecamatan-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select kecamatan') }} --</option>
                                        
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ isset($vendor) && $vendor->kecamatan_id == $kecamatan->id ? 'selected' : (old('kecamatan_id') == $kecamatan->id ? 'selected' : '') }}>
                                {{ $kecamatan->kabkot_id }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('kecamatan_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="kelurahan-id">{{ __('Kelurahan') }}</label>
                                    <select class="form-control @error('kelurahan_id') is-invalid @enderror" name="kelurahan_id" id="kelurahan-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select kelurahan') }} --</option>
                                        
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ isset($vendor) && $vendor->kelurahan_id == $kelurahan->id ? 'selected' : (old('kelurahan_id') == $kelurahan->id ? 'selected' : '') }}>
                                {{ $kelurahan->kecamatan_id }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('kelurahan_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="zip-kode">{{ __('Zip Kode') }}</label>
            <input type="text" name="zip_kode" id="zip-kode" class="form-control @error('zip_kode') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->zip_kode : old('zip_kode') }}" placeholder="{{ __('Zip Kode') }}" required />
            @error('zip_kode')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="longitude">{{ __('Longitude') }}</label>
            <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->longitude : old('longitude') }}" placeholder="{{ __('Longitude') }}" required />
            @error('longitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="latitude">{{ __('Latitude') }}</label>
            <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ isset($vendor) ? $vendor->latitude : old('latitude') }}" placeholder="{{ __('Latitude') }}" required />
            @error('latitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>