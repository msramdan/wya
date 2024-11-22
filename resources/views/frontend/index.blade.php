@extends('frontend.landing')

@section('title', __('Home'))

@section('content')
    <main class="main">
        <section id="hero" class="hero section">
            <div class="hero-bg">
                <img src="{{ asset('landing') }}/assets/img/hero-bg-light.webp" alt="">
            </div>
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up">Welcome to <span>WithYouAlways</span></h1>
                    <p data-aos="fade-up" data-aos-delay="100">
                        Platform ini dibuat untuk melaporkan dan menangani kasus bullying di sekolah dengan cepat dan
                        efisien.
                    </p>

                    </p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Watch
                                Video</span></a>
                    </div>
                    <img src="{{ asset('landing') }}/assets/img/hero-services-img.webp" class="img-fluid hero-img"
                        alt="" data-aos="zoom-out" data-aos-delay="300">
                </div>
            </div>
        </section>

        <section id="featured-services" class="featured-services section light-background">

            <div class="container">

                <div class="row gy-4">
                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-person-x"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Stop Bullying</a></h4>
                                <p class="description">Hentikan segala bentuk perundungan dan ciptakan lingkungan sekolah
                                    yang aman dan nyaman.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-people"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Bersama Kita Bisa</a></h4>
                                <p class="description">Ayo saling mendukung dan membangun solidaritas untuk mengakhiri
                                    bullying di sekolah.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Sekolah Ramah Anak</a></h4>
                                <p class="description">Mari wujudkan sekolah sebagai tempat yang penuh rasa hormat, tanpa
                                    kekerasan, dan inklusif.</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </section>

    </main>
@endsection
