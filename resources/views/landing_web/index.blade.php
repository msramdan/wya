<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ setting_web()->aplication_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/demo/templates/Appland/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <header id="header" class="fixed-top  header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="#"><img src="{{ asset('landing/logo.png') }}" alt=""></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#ipm">IPM</a></li>
                    <li><a class="nav-link scrollto" href="#inventory">Inventory</a></li>
                    <li><a class="nav-link scrollto" href="#riwayat">Riwayat Peralatan</a></li>
                    <li><a class="nav-link scrollto" href="#expense">Expense / Cost</a></li>
                    <li><a class="nav-link scrollto" href="#dokumen">Dokumen</a></li>
                    <li><a class="nav-link scrollto" href="#report">General Report</a></li>
                    <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
                    <li><a class="nav-link scrollto" href="https://wa.marsweb.co.id/app/index.php/dashboard" target="_blank">WA Blast</a></li>
                    <li><a class="getstarted scrollto" href="/login">Login</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>

    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up">
                    <div>
                        <h1>MARS WEB</h1>
                        <p style="text-align: justify">Merupakan sebuah Aplikasi Manajemen Aset yang bebbasis Website
                            yang diperuntukan Rumah Sakit
                            yang befungsi untuk Mengelola Aset dan sebagai Sarana Pendukung Program Inspection
                            Preventive Maintanance yang mengacu pada MFK 8/KARS 2012/JCI.</p>
                        {{-- <a href="#" class="download-btn"><i class="bx bxl-whatsapp"></i> Kirim
                            Email</a>
                        <a href="#" class="download-btn"><i class="bx bxl-whatsapp"></i> Pesan WhatsApp</a> --}}
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img"
                    data-aos="fade-up">
                    <img src="{{ asset('landing/demo/templates/Appland/assets/img/hero-img.png') }}" class="img-fluid"
                        alt="">
                </div>
            </div>
        </div>

    </section>

    <main id="main">
        <section class="details">
            <div class="container">
                <div class="row content" id="ipm">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/ipm.png') }}" class="img-fluid"
                            alt="">
                    </div>
                    <div class="col-md-8 pt-4" data-aos="fade-up">
                        <h3>Manajemen IPM</h3>
                        <p class="fst-italic" style="text-align: justify">
                            Inspeksi Preventive Maintenance merupakan sebuah program pengelolaan peralatan kesehatan
                            yang meliputi :
                        </p>
                        <ul>
                            <li><i class="bi bi-check"></i>Maintenance
                            </li>
                            <li><i class="bi bi-check"></i> Service
                            </li>
                            <li><i class="bi bi-check"></i> Kalibrasi </li>
                            <li><i class="bi bi-check"></i> Training</li>
                        </ul>
                        <p style="text-align: justify">
                            Pengelolaan program tersebut adalah berupa penjadwalan program-program yang di rencanakan
                            secara Rutin atau Non Rutin yang tersistem berupa reminder jadwal-jadwal kegiatan, remider
                            tersebut dalam bentuk tabel list jadwal, pesan notifikasi dan email notifikasi.
                        </p>
                        <p style="text-align: justify">
                            Pengajuan jadwal kegiatan Work Order dapat dilakukan oleh divisi IPSRS ataupun masing-masing
                            user accout yang telah diberikan lisensi. Tim IPSRS merespon pengajuan Work Order dengan
                            melaporkan hasil kegiatan ke dalam Lembar Kerja. Hasil dari kegiatan IPM yg di input di
                            dalam LK, secara otomatis tersimpan ke dalam Riwayat Peralatan.
                        </p>
                    </div>
                </div>

                <div class="row content" id="inventory">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/inventory.png') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Manajemen Inventory</h3>
                        <p style="text-align: justify">
                            Permasalahan yang sering timbul dalam pengelolaan aset adalah peralatan tidak terdata secara
                            baik, tidak terintegrasi nya data antar departement, data peralatan yang berulang, tidak
                            terdata kondisi peralatan, tidak terdata status kalibrasi, riwayat peralatan tidak terdata
                            dengan baik, tidak terdata nya biaya-biaya yg telah dikeluarkan selama masa operasi, tidak
                            diketahui prediksi nilai aset, serta tidak diketahuinya total aset yang dimiliki.
                        </p>
                        <p style="text-align: justify">
                            Untuk itu diperlukan sebuah system yang mampu mempermudah sebuah institusi dalam melakukan
                            pengelolaan aset nya. MARS mampu mengatasi semua permasalahan tersebut.
                        </p>
                    </div>
                </div>

                <div class="row content" id="riwayat">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/riwayat.png') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5" data-aos="fade-up">
                        <h3>Riwayat Peralatan</h3>
                        <p style="text-align: justify">Salah satu feature utama dari Manajemen Asset Rumah Sakit yaitu
                            adanya laporan Riwayat
                            Peralatan yang menyajikan seluruh informasi seperti : </p>
                        <ul>
                            <li><i class="bi bi-check"></i> kegiatan Preventive Maintenance
                            </li>
                            <li><i class="bi bi-check"></i> kegiatan Kalibrasi
                            </li>
                            <li><i class="bi bi-check"></i> kegiatan Service
                            </li>
                            <li><i class="bi bi-check"></i> kegiatan Training
                            </li>
                            <li><i class="bi bi-check"></i> penggantian part/ asessoris
                        </ul>
                        <p style="text-align: justify">
                            Riwayat Peralatan ini dapat digunakan sebagai bahan pertimbangan perlu tidak nya dilakuakn
                            penambahan aset peralatan, perlu tidaknya dilakukan perbaikan kembali atau sebagai bahan
                            acuan untuk pmelakukan penggantian/ penghapusan peralatan tersebut.
                        </p>
                    </div>
                </div>

                <div class="row content" id="expense">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/cost.png') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Expense / Cost</h3>
                        <p style="text-align: justify">
                            Dalam pengelolaan Aset tentu tidak sedikit biaya yang dikeluarkan selama masa operasi
                            peralatan tersebut, baik itu biaya maintenance, biaya service, biaya kalibrasi, biaya
                            penggantian part dan asessoris, dengan metode konvensional selama ini tentunya juga sering
                            sekali tidak tercatat secara baik.
                        </p>
                        <p style="text-align: justify">
                            MARS memiliki solusi untuk mengatasi permasalahan tersebut, MARS memiliki feature perekaman
                            dan pencatatan secara akurat pengeluaran-pengeluaran biaya yang dikeluarkan untuk setiap
                            peralatan selama masa operasi peralatan tersebut.
                        </p>
                    </div>
                </div>

                <div class="row content" id="dokumen">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/dokumen.png') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-4" data-aos="fade-up">
                        <h3>Dokumen</h3>
                        <p style="text-align: justify">
                            Dalam pengelolaan Asset baik itu dalam hal Maintenance, Service, Kalibrasi, Inventory
                            Peralatan, Inventory Part dan Assesoris, Pengeluaran biaya-biaya selama peralatan
                            beroperasi, sampai dengan dokumen teknis peralatan seperti Service Manual, User Manual,
                        </p>
                        <p style="text-align: justify">
                            COO merupakan syarat mutlah yang harus terdokumentasi dengan baik, Manajemen Asset Rumah
                            Sakit tentunya menyediakan fasilitas feature Manajemen Dokumen, yang dapat di akses kapan
                            pun dan di cetak kapan saja.
                        </p>
                    </div>
                </div>

                <div class="row content" id="report">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="{{ asset('landing/demo/templates/Appland/assets/img/report.png') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>General Report</h3>
                        <p style="text-align: justify">
                            MARS juga memberikan fasilitas General Report dengan Template sederhana dengan output file
                            microsoft word guna memudahkan dalam pengeditan, namun data-data yang di butuhkan telah di
                            dapatkan.
                        </p>
                        <p style="text-align: justify">
                            General Report ini menyajikan beberapa data penting yang diperlukan dalam pelaporan, juga
                            dapat kita tentukan periode waktu yang akan di tampilkan di dalam Laporan ini.
                        </p>
                        <p style="text-align: justify">
                            Beberapa data yang di tampilkan di dalam Laporan ini adalah Total Kegiatan IPM (di dalamnya
                            ada Preventive Maintenance, Service, Kalibrasi dan Training), Informasi Status Work Order
                            (Waiing for Approval, Approved, on Progress dan Finish), informasi Expense (Service,
                            Kalibrasi dan Part/ Asessoris), Total Asset yang dimiliki oleh Rumah Sakit)
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Gallery</h2>
                    <p>Beberapa tampilan dari aplikasi MARS WEB</p>
                </div>

            </div>

            <div class="container-fluid" data-aos="fade-up">
                <div class="gallery-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a
                                href=" {{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-1.webp') }}"
                                class="gallery-lightbox" data-gall="gallery-carousel"><img
                                    style="width: 100%; border-radius: 10%;"
                                    src="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-1.webp') }}"
                                    class="img-fluid" alt=""></a></div>

                        <div class="swiper-slide"><a
                                href="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-2.webp') }}"
                                class="gallery-lightbox" data-gall="gallery-carousel"><img
                                    style="width: 100%; border-radius: 10%;"
                                    src="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-2.webp') }}"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a
                                href="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-3.webp') }}"
                                class="gallery-lightbox" data-gall="gallery-carousel"><img
                                    style="width: 100%; border-radius: 10%;"
                                    src="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-3.webp') }}"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a
                                href="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-4.webp') }}"
                                class="gallery-lightbox" data-gall="gallery-carousel"><img
                                    style="width: 100%; border-radius: 10%;"
                                    src="{{ asset('landing/demo/templates/Appland/assets/img/gallery/gallery-4.webp') }}"
                                    class="img-fluid" alt=""></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>
    </main>
    <script src="{{ asset('landing/assets/vendor/aos/aos.js') }} "></script>
    <script src="{{ asset('landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('landing/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('landing/demo/templates/Appland/assets/js/main.js') }}"></script>
    <script async src='https://www.googletagmanager.com/gtag/js?id=G-P7JSYB1CSP'></script>
    <script type="text/javascript">
        (function() {
            var options = {
                telegram: "msramdan9090", // Telegram bot username
                whatsapp: "+6283874731480", // WhatsApp number
                call_to_action: "Kirimi kami pesan", // Call to action
                button_color: "#129BF4", // Color of button
                position: "right", // Position may be 'right' or 'left'
                order: "telegram,whatsapp", // Order of buttons
            };
            var proto = 'https:',
                host = "getbutton.io",
                url = proto + '//static.' + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();
    </script>
</body>

</html>
