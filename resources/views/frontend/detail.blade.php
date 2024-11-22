@extends('frontend.landing')

@section('title', __('Detail Aduan'))

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <main class="main">
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0"></h1>
            </div>
        </div>

        <section id="starter-section" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Detail Aduan</h2>
            </div>
            <div class="container d-flex justify-content-center" data-aos="fade-up">
                <div class="col-md-12">
                    <table class="table table-hover table-xl">
                        <tr>
                            <td class="fw-bold">{{ __('Nama') }}</td>
                            <td>:</td>
                            <td>{{ $aduan->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('Email') }}</td>
                            <td>:</td>
                            <td>{{ $aduan->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('Judul') }}</td>
                            <td>:</td>
                            <td>{{ $aduan->judul }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                            <td>:</td>
                            <td>{{ $aduan->keterangan }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('Tanggal') }}</td>
                            <td>:</td>
                            <td><i class="fas fa-calendar-alt"></i> {{ $aduan->tanggal }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('Type') }}</td>
                            <td>:</td>
                            <td>{{ $aduan->type }}</td>
                        </tr>
                        @if ($aduan->type == 'Private')
                            <tr>
                                <td class="fw-bold">{{ __('Is Read') }}</td>
                                <td>:</td>
                                <td>{{ $aduan->is_read }}</td>
                            </tr>
                            <tr>
                        @endif

                        <td class="fw-bold">{{ __('Status') }}</td>
                        <td>:</td>
                        <td>
                            @if ($aduan->status == 'Dalam Penanganan')
                                <button class="btn btn-secondary">
                                    <i class="fa fa-spinner fa-spin"></i> {{ $aduan->status }}
                                </button>
                            @elseif ($aduan->status == 'Ditolak')
                                <button class="btn btn-danger">
                                    <i class="fa fa-times-circle"></i> {{ $aduan->status }}
                                </button>
                            @elseif ($aduan->status == 'Selesai')
                                <button class="btn btn-success">
                                    <i class="fa fa-check-circle"></i> {{ $aduan->status }}
                                </button>
                            @else
                                <span>{{ $aduan->status }}</span>
                                <!-- Fallback if status is not one of the known values -->
                            @endif
                        </td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>

    </main>

@endsection
