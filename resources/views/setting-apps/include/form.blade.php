<div class="row mb-2">
    <div class="col-md-6 mb-3">
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
    <div class="col-md-6 mb-3">
        <label for="phone">{{ __('Phone') }}</label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
            value="{{ isset($settingApp) ? $settingApp->phone : old('phone') }}" placeholder="{{ __('Phone') }}"
            required />
        @error('phone')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">{{ __('Email') }}</label>
        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ isset($settingApp) ? $settingApp->email : old('email') }}" placeholder="{{ __('Email') }}"
            required />
        @error('email')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6  mb-2">
        <label for="address">{{ __('Address') }}</label>
        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
            placeholder="{{ __('Address') }}" required>{{ isset($settingApp) ? $settingApp->address : old('address') }}</textarea>
        @error('address')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="notif-wa">{{ __('Notif Wa') }}</label>
        <select class="form-control @error('notif_wa') is-invalid @enderror" name="notif_wa" id="notif-wa" required>
            <option value="" selected disabled>-- {{ __('Select notif wa') }} --</option>
            <option value="1"
                {{ isset($settingApp) && $settingApp->notif_wa == '1' ? 'selected' : (old('notif_wa') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($settingApp) && $settingApp->notif_wa == '0' ? 'selected' : (old('notif_wa') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('notif_wa')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="url-wa-gateway">{{ __('Url Wa Gateway') }}</label>
        <input type="text" name="url_wa_gateway" id="url-wa-gateway"
            class="form-control @error('url_wa_gateway') is-invalid @enderror"
            value="{{ isset($settingApp) ? $settingApp->url_wa_gateway : old('url_wa_gateway') }}"
            placeholder="{{ __('Url Wa Gateway') }}" required />
        @error('url_wa_gateway')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="session-wa-gateway">{{ __('Session Wa Gateway') }}</label>
        <input type="text" name="session_wa_gateway" id="session-wa-gateway"
            class="form-control @error('session_wa_gateway') is-invalid @enderror"
            value="{{ isset($settingApp) ? $settingApp->session_wa_gateway : old('session_wa_gateway') }}"
            placeholder="{{ __('Session Wa Gateway') }}" required />
        @error('session_wa_gateway')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="bot-telegram">{{ __('Bot Telegram') }}</label>
        <select class="form-control @error('bot_telegram') is-invalid @enderror" name="bot_telegram" id="bot-telegram"
            required>
            <option value="" selected disabled>-- {{ __('Select bot telegram') }} --</option>
            <option value="1"
                {{ isset($settingApp) && $settingApp->bot_telegram == '1' ? 'selected' : (old('bot_telegram') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($settingApp) && $settingApp->bot_telegram == '0' ? 'selected' : (old('bot_telegram') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('bot_telegram')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        @if ($settingApp->logo != '' || $settingApp->logo != null)
            <img src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}"
                class="img-preview d-block w-20 mb-1 col-sm-5 rounded ">
            <p style="color: red">* Choose a logo if you want to change it</p>
        @endif
        <label class="form-label" for="logo"> Logo</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo"
            onchange="previewImg()" value="{{ $settingApp->logo }}">
        @error('logo')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        @if ($settingApp->favicon != '' || $settingApp->favicon != null)
            <img src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}"
                class="img-preview d-block w-20 mb-1 col-sm-5 rounded ">
            <p style="color: red">* Choose a favicon if you want to change it</p>
        @endif
        <label class="form-label" for="favicon"> {{ __('Favicon') }}</label>
        <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon"
            onchange="previewImg()" value="{{ $settingApp->favicon }}">
        @error('favicon')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
