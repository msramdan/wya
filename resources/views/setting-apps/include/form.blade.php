<div class="row mb-2">
    <div class="col-md-6">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="aplication-name">{{ __('Aplication Name') }}</label>
                <input type="text" name="aplication_name" id="aplication-name"
                    class="form-control @error('aplication_name') is-invalid @enderror"
                    value="{{ isset($settingApp) ? $settingApp->aplication_name : old('aplication_name') }}"
                    placeholder="{{ __('Aplication Name') }}" required />
                @error('aplication_name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="col-12 mb-3">
                @if ($settingApp->logo != '' || $settingApp->logo != null)
                    <img style="width: 180px; height:80px"
                        src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}" class="">
                    <p style="color: red">* Choose a logo if you want to change it</p>
                @endif
                <label class="form-label" for="logo"> Logo</label>
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                    name="logo" onchange="previewImg()" value="{{ $settingApp->logo }}">
                @error('logo')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-12 mb-3">
                @if ($settingApp->favicon != '' || $settingApp->favicon != null)
                    <img style="width:80px;height:80px"
                        src="{{ Storage::url('public/img/setting_app/') . $settingApp->favicon }}" class="">
                    <p style="color: red">* Choose a favicon if you want to change it</p>
                @endif
                <label class="form-label" for="favicon"> {{ __('Favicon') }}</label>
                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon"
                    name="favicon" onchange="previewImg()" value="{{ $settingApp->favicon }}">
                @error('favicon')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

        </div>
    </div>
</div>
</div>
</div>
