<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="name">{{ trans('hospital/form.name') }}</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ isset($hospital) ? $hospital->name : old('name') }}" placeholder="{{ __('Name') }}" required />
        @error('name')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="phone">{{ trans('hospital/form.phone') }}</label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
            value="{{ isset($hospital) ? $hospital->phone : old('phone') }}" placeholder="{{ __('Phone') }}"
            required />
        @error('phone')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="email">{{ trans('hospital/form.email') }}</label>
        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ isset($hospital) ? $hospital->email : old('email') }}" placeholder="{{ __('Email') }}"
            required />
        @error('email')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">{{ trans('hospital/form.address') }}</label>
            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                placeholder="{{ __('Address') }}" required>{{ isset($hospital) ? $hospital->address : old('address') }}</textarea>
            @error('address')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($hospital)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($hospital->logo == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo"
                            class="rounded mb-2 mt-2" alt="Logo" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/logos/' . $hospital->logo) }}" alt="Logo"
                            class="rounded mb-2 mt-2" style="object-fit: cover; width:90%">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="logo">{{ trans('hospital/form.logo') }}</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                            id="logo">

                        @error('logo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="logoHelpBlock" class="form-text">
                            {{ __('Leave the logo blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="logo">{{ trans('hospital/form.logo') }}</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo"
                    required>

                @error('logo')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset

    <div class="col-6 mb-2">
        <label for="notif-wa">{{ trans('hospital/form.notif_wa') }}</label>
        <select class="form-control js-example-basic-multiple @error('notif_wa') is-invalid @enderror" name="notif_wa"
            id="notif-wa" required>
            <option value="" selected disabled>-- {{ __('Select notif wa') }} --</option>
            <option value="1"
                {{ isset($hospital) && $hospital->notif_wa == '1' ? 'selected' : (old('notif_wa') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($hospital) && $hospital->notif_wa == '0' ? 'selected' : (old('notif_wa') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('notif_wa')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="url-wa-gateway">{{ trans('hospital/form.url_wa') }}</label>
        <input type="text" name="url_wa_gateway" id="url-wa-gateway"
            class="form-control @error('url_wa_gateway') is-invalid @enderror"
            value="{{ isset($hospital) ? $hospital->url_wa_gateway : old('url_wa_gateway') }}"
            placeholder="{{ __('Url Wa Gateway') }}" required />
        @error('url_wa_gateway')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="session-wa-gateway">{{ trans('hospital/form.session_wa') }}</label>
        <input type="text" name="session_wa_gateway" id="session-wa-gateway"
            class="form-control @error('session_wa_gateway') is-invalid @enderror"
            value="{{ isset($hospital) ? $hospital->session_wa_gateway : old('session_wa_gateway') }}"
            placeholder="{{ __('Session Wa Gateway') }}" required />
        @error('session_wa_gateway')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-6 mb-2">
        <label for="paper-qr-code">{{ trans('hospital/form.qrcode') }}</label>
        <select class="form-control js-example-basic-multiple  @error('paper_qr_code') is-invalid @enderror"
            name="paper_qr_code" id="paper-qr-code" required>
            <option value="" selected disabled>-- {{ __('Select QRcode Paper') }} --</option>
            <option value="93.5433"
                {{ isset($hospital) && $hospital->paper_qr_code == '93.5433' ? 'selected' : (old('paper_qr_code') == '93.5433' ? 'selected' : '') }}>
                {{ __('24mm') }}</option>
            <option value="68.0315"
                {{ isset($hospital) && $hospital->paper_qr_code == '68.0315' ? 'selected' : (old('paper_qr_code') == '68.0315' ? 'selected' : '') }}>
                {{ __('18mm') }}</option>

        </select>
        @error('paper_qr_code')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-6 mb-2">
        <label for="bot-telegram">{{ trans('hospital/form.bot_telegram') }}</label>
        <select class="form-control js-example-basic-multiple @error('bot_telegram') is-invalid @enderror"
            name="bot_telegram" id="bot-telegram" required>
            <option value="" selected disabled>-- {{ __('Select bot telegram') }} --</option>
            <option value="1"
                {{ isset($hospital) && $hospital->bot_telegram == '1' ? 'selected' : (old('bot_telegram') == '1' ? 'selected' : '') }}>
                {{ __('True') }}</option>
            <option value="0"
                {{ isset($hospital) && $hospital->bot_telegram == '0' ? 'selected' : (old('bot_telegram') == '0' ? 'selected' : '') }}>
                {{ __('False') }}</option>
        </select>
        @error('bot_telegram')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    @if (Request::segment(3) != 'create')
        <div class="col-6 mb-2">
            <label for="work-order-has-access-approval-users">{{ trans('hospital/form.wo_has_access') }}</label>
            <select data-placeholder="Select Users" name="work_order_has_access_approval_users_id[]"
                multiple="multiple" id="work-order-has-access-approval-users"
                class="form-control js-example-basic-multiple @error('work_order_has_access_approval_users_id') is-invalid @enderror">
                <option value="" disabled>-- {{ __('Select Users') }} --</option>
                @foreach ($users as $user)
                    @if (isset($hospital))
                        <option value="{{ $user->id }}"
                            {{ in_array($user->id, json_decode($hospital->work_order_has_access_approval_users_id, true) ? json_decode($hospital->work_order_has_access_approval_users_id, true) : []) ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('work_order_has_access_approval_users_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    @endif
</div>
