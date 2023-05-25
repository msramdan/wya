@extends('layouts.app')

@section('title', __('Profile'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Profile') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Profile --}}
            <div class="row">
                <div class="col-md-3">
                    <h4>{{ __('Profile') }}</h4>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('user-profile-information.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group  mb-3">
                                    <label for="email">{{ __('E-mail Address') }}</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror"
                                        id="email" placeholder="{{ __('E-mail Address') }}"
                                        value="{{ old('email') ?? auth()->user()->email }}" required>

                                    @error('email', 'updateProfileInformation')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group  mb-3">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" name="name"
                                        class="form-control  @error('name', 'updateProfileInformation') is-invalid @enderror"
                                        id="name" placeholder="{{ __('Name') }}"
                                        value="{{ old('name') ?? auth()->user()->name }}" required>
                                    @error('name', 'updateProfileInformation')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group  mb-3">
                                    <label for="no_hp">{{ __('Number Phone') }}</label>
                                    <input type="text" name="no_hp"
                                        class="form-control  @error('no_hp', 'updateProfileInformation') is-invalid @enderror"
                                        id="no_hp" placeholder="{{ __('Number Phone') }}"
                                        value="{{ old('no_hp') ?? auth()->user()->no_hp }}" required>
                                    @error('no_hp', 'updateProfileInformation')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="avatar avatar-xl mb-3">
                                            @if (auth()->user()->avatar == null)
                                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=500"
                                                    alt="Avatar">
                                            @else
                                                <img src="{{ asset('uploads/images/avatars/' . auth()->user()->avatar) }}"
                                                    alt="Avatar" style="width: 120px">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="avatar">{{ __('Avatar') }}</label>
                                            <input type="file" name="avatar"
                                                class="form-control @error('avatar', 'updateProfileInformation') is-invalid @enderror"
                                                id="avatar">

                                            @error('avatar', 'updateProfileInformation')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Password --}}
            <div class="row">
                <div class="col-md-3">
                    <h4>{{ __('Change Password') }}</h4>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user-password.update') }}">
                                @csrf
                                @method('put')
                                <div class="form-group  mb-3">
                                    <label for="password">{{ __('Current Password') }}</label>
                                    <input type="password" name="current_password"
                                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                        id="password" placeholder="Current Password" required>
                                    @error('current_password', 'updatePassword')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group  mb-3">
                                    <label for="password">{{ __('New Password') }}</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                        id="password" placeholder="New Password" required>
                                    @error('password', 'updatePassword')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group  mb-3">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm Password" required>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
