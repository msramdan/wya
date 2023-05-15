<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ __('Name') }}" value="{{ isset($hospital) ? $hospital->name : old('name') }}" required
                autofocus>
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-2">
        <div class="form-group">
            <label for="phone">{{ __('Phone') }}</label>
            <input type="phone" name="phone" id="phone"
                class="form-control @error('phone') is-invalid @enderror" placeholder="{{ __('Phone') }}"
                value="{{ isset($hospital) ? $hospital->phone : old('phone') }}" required>
            @error('phone')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-2">
        <div class="form-group  mb-3">
            <label for="address">{{ __('Address') }}</label>
            <input type="text" name="address" class="form-control  @error('address') is-invalid @enderror"
                id="address" placeholder="{{ __('Address') }}"
                value="{{ old('address') ? old('address') : (isset($hospital) ? $hospital->address : '') }}" required>
            @error('address')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    @empty($hospital)
        <div class="col-md-5 me-0 pe-0">
            <div class="form-group">
                <label for="logo">{{ __('Logo') }}</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                    id="logo">
                @error('logo')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endempty

    @isset($hospital)
        <div class="row">
            <div class="col-md-1 text-center">
                <div class="avatar avatar-xl">
                    @if ($hospital->logo == null)
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($hospital->name))) }}&s=500"
                            alt="logo">
                    @else
                        <img src="{{ asset("uploads/images/logos/$hospital->logo") }}" alt="logo">
                    @endif
                </div>
            </div>

            <div class="col-md-5 me-0 pe-0">
                <div class="form-group">
                    <label for="logo">{{ __('Logo') }}</label>
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                        id="logo">
                    @error('logo')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    @if ($hospital->logo == null)
                        <div id="passwordHelpBlock" class="form-text">
                            {{ __('Leave the logo blank if you don`t want to change it.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endisset
</div>
