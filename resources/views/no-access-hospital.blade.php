@extends('layouts.app')

@section('title', __('No Access Hospital'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="card-title">Akses Ditolak</h2>
                            <p class="card-text">
                                Anda tidak memiliki akses ke rumah sakit.
                                Silahkan hubungi admin untuk mendapatkan bantuan atau informasi lebih lanjut.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
