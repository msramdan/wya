@extends('layouts.app')

@section('title', __('Edit Positions'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Positions') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('positions.index') }}">{{ __('Positions') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('Edit') }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('positions.update', $position->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('positions.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
