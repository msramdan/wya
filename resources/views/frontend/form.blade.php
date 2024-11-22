@extends('frontend.landing')

@section('title', __('Form Aduan'))

@section('content')
    <main class="main">
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0"></h1>
            </div>
        </div>
        <section id="starter-section" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Form Aduan</h2>
                <p>Gunakan form ini untuk melaporkan kasus bullying di sekolah. Mari bersama menciptakan lingkungan yang
                    aman dan nyaman bagi semua.</p>
            </div>
            <div class="container" data-aos="fade-up">
                <div class="d-flex justify-content-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <center>
                                <img src="{{ asset('landing') }}/assets/img/stop.jpg" alt="Image related to Aduan"
                                    class="img-fluid">
                            </center>
                        </div>

                        <div class="col-lg-6">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {!! session('success') !!}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="card border-0"> <!-- No border on the card -->
                                <div class="card-body">
                                    <form action="{{ route('web.store') }}" method="POST">
                                        @csrf
                                        <div class="row gy-4">
                                            <!-- Nama -->
                                            <div class="col-md-6">
                                                <input type="text" name="nama" class="form-control"
                                                    placeholder="Nama Asli/Samaran" required="" />
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Email" required="" />
                                            </div>

                                            <!-- Judul -->
                                            <div class="col-md-12">
                                                <input type="text" name="judul" class="form-control"
                                                    placeholder="Judul" required="" />
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="col-md-12">
                                                <textarea name="keterangan" class="form-control" rows="6" placeholder="Keterangan" required=""></textarea>
                                            </div>

                                            <!-- Type -->
                                            <div class="col-md-12">
                                                <select name="type" class="form-control" required="">
                                                    <option value="Public">-- Type laporan --</option>
                                                    <option value="Public">Public</option>
                                                    <option value="Private">Private</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                {!! NoCaptcha::renderJs() !!}
                                                @error('g-recaptcha-response')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Submit -->
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-success">Kirim Laporan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
