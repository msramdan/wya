@extends('frontend.landing')

@section('title', __('Aduan Private'))

@section('content')
    <main class="main">
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0"></h1>
            </div>
        </div>
        <section id="starter-section" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Aduan Private</h2>
                <p>Silakan masukkan token OTP yang Anda dapatkan ketika mengajukan laporan dengan tipe private. Token
                    tersebut dikirim juga ke email Anda.</p>
            </div>
            <div class="container" data-aos="fade-up">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <form method="POST" action="">
                            @csrf
                            <div class="form-group text-center">
                                <div class="border-pin">
                                    <input type="text" name="satu" class="num" maxlength="1" required>
                                    <input type="text" name="dua" class="num" maxlength="1" required>
                                    <input type="text" name="tiga" class="num" maxlength="1" required>
                                    <input type="text" name="empat" class="num" maxlength="1" required>
                                    <input type="text" name="lima" class="num" maxlength="1" required>
                                    <input type="text" name="enam" class="num" maxlength="1" required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success w-100">Lihat Aduan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection

<style>
    .border-pin {
        display: flex;
    }

    .num {
        color: #000;
        background-color: transparent;
        width: 17%;
        height: 75px;
        text-align: center;
        outline: none;
        padding: 1rem 1rem;
        margin: 0 1px;
        font-size: 24px;
        margin: 5px;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: .5rem;
        color: rgba(0, 0, 0, 0.5);
    }

    .num:focus,
    .num:valid {
        box-shadow: 0 0 .5rem rgba(20, 3, 255, 0.5);
        inset 0 0 .5rem rgba(20, 3, 255, 0.5);
        border-color: rgba(20, 3, 255, 0.5);
    }
</style>

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.num').on('input', function() {
                var $this = $(this);
                if ($this.val().length === 1) {
                    $this.next('.num').focus();
                }
            });

            $('.num').on('keydown', function(e) {
                var $this = $(this);
                if (e.key === 'Backspace' && $this.val().length === 0) {
                    $this.prev('.num').focus();
                }
            });
        });
    </script>
@endpush
