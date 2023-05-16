<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($hospital) ? $hospital->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="phone">{{ __('Phone') }}</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ isset($hospital) ? $hospital->phone : old('phone') }}" placeholder="{{ __('Phone') }}" required />
            @error('phone')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="email">{{ __('Email') }}</label>
            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($hospital) ? $hospital->email : old('email') }}" placeholder="{{ __('Email') }}" required />
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="{{ __('Address') }}" required>{{ isset($hospital) ? $hospital->address : old('address') }}</textarea>
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
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo" class="rounded mb-2 mt-2" alt="Logo" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/logos/' . $hospital->logo) }}" alt="Logo" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="logo">{{ __('Logo') }}</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo">

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
                <label for="logo">{{ __('Logo') }}</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo" required>

                @error('logo')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
<div class="col-md-6 mb-2">
                               <label for="notif-wa">{{ __('Notif Wa') }}</label>
                                    <select class="form-control @error('notif_wa') is-invalid @enderror" name="notif_wa" id="notif-wa"  required>
                                        <option value="" selected disabled>-- {{ __('Select notif wa') }} --</option>
                                        <option value="1" {{ isset($hospital) && $hospital->notif_wa == '1' ? 'selected' : (old('notif_wa') == '1' ? 'selected' : '') }}>{{ __('True') }}</option>
				<option value="0" {{ isset($hospital) && $hospital->notif_wa == '0' ? 'selected' : (old('notif_wa') == '0' ? 'selected' : '') }}>{{ __('False') }}</option>
                                    </select>
                                    @error('notif_wa')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="url-wa-gateway">{{ __('Url Wa Gateway') }}</label>
            <input type="text" name="url_wa_gateway" id="url-wa-gateway" class="form-control @error('url_wa_gateway') is-invalid @enderror" value="{{ isset($hospital) ? $hospital->url_wa_gateway : old('url_wa_gateway') }}" placeholder="{{ __('Url Wa Gateway') }}" required />
            @error('url_wa_gateway')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="session-wa-gateway">{{ __('Session Wa Gateway') }}</label>
            <input type="text" name="session_wa_gateway" id="session-wa-gateway" class="form-control @error('session_wa_gateway') is-invalid @enderror" value="{{ isset($hospital) ? $hospital->session_wa_gateway : old('session_wa_gateway') }}" placeholder="{{ __('Session Wa Gateway') }}" required />
            @error('session_wa_gateway')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="paper-qr-code">{{ __('Paper Qr Code') }}</label>
                                    <select class="form-control @error('paper_qr_code') is-invalid @enderror" name="paper_qr_code" id="paper-qr-code"  required>
                                        <option value="" selected disabled>-- {{ __('Select paper qr code') }} --</option>
                                        <option value="1" {{ isset($hospital) && $hospital->paper_qr_code == '1' ? 'selected' : (old('paper_qr_code') == '1' ? 'selected' : '') }}>{{ __('True') }}</option>
				<option value="0" {{ isset($hospital) && $hospital->paper_qr_code == '0' ? 'selected' : (old('paper_qr_code') == '0' ? 'selected' : '') }}>{{ __('False') }}</option>
                                    </select>
                                    @error('paper_qr_code')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="bot-telegram">{{ __('Bot Telegram') }}</label>
                                    <select class="form-control @error('bot_telegram') is-invalid @enderror" name="bot_telegram" id="bot-telegram"  required>
                                        <option value="" selected disabled>-- {{ __('Select bot telegram') }} --</option>
                                        <option value="1" {{ isset($hospital) && $hospital->bot_telegram == '1' ? 'selected' : (old('bot_telegram') == '1' ? 'selected' : '') }}>{{ __('True') }}</option>
				<option value="0" {{ isset($hospital) && $hospital->bot_telegram == '0' ? 'selected' : (old('bot_telegram') == '0' ? 'selected' : '') }}>{{ __('False') }}</option>
                                    </select>
                                    @error('bot_telegram')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="work-order-has-access-approval-users-id">{{ __('Work Order Has Access Approval Users Id') }}</label>
            <textarea name="work_order_has_access_approval_users_id" id="work-order-has-access-approval-users-id" class="form-control @error('work_order_has_access_approval_users_id') is-invalid @enderror" placeholder="{{ __('Work Order Has Access Approval Users Id') }}" required>{{ isset($hospital) ? $hospital->work_order_has_access_approval_users_id : old('work_order_has_access_approval_users_id') }}</textarea>
            @error('work_order_has_access_approval_users_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>