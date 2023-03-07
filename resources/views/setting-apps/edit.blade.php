@extends('layouts.app')

@section('title', __('Edit Setting Apps'))

@section('content')


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Setting Apps') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('setting-apps.index') }}">{{ __('Setting Apps') }}</a>
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('setting-apps.update', $settingApp->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('setting-apps.include.form')
                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
