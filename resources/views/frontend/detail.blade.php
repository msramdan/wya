@extends('frontend.landing')

@section('title', __('Detail Aduan'))

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Styling for the comment section */
        .comments-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .comment-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-item .d-flex {
            align-items: center;
        }

        .comment-item img {
            border-radius: 50%;
        }

        .comment-item p {
            margin: 0;
        }

        .comment-item .text-muted {
            font-size: 0.875rem;
        }

        .comment-item strong {
            font-size: 1rem;
            font-weight: 600;
        }
    </style>



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
                        <tr>
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
                                @endif
                            </td>
                        </tr>
                    </table>

                    <!-- Comment Section -->
                    <div class="comments-section mt-4">
                        <h3>{{ __('Komentar') }}</h3>
                        @foreach ($comments as $comment)
                            <!-- Assuming 'comments' is a relationship -->
                            <div class="comment-item mb-3">
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    @if ($comment->user_avatar == null)
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($comment->user_email))) }}&s=50"
                                            alt="{{ $comment->user_name }}" class="rounded-circle me-3" width="40"
                                            height="40">
                                    @else
                                        <img src="{{ asset('uploads/images/avatars/' . $comment->user_avatar) }}"
                                            alt="{{ $comment->user_name }}" class="rounded-circle me-3" width="40"
                                            height="40">
                                    @endif

                                    <!-- Comment Details -->
                                    <div>
                                        <p class="mb-1">
                                            <strong>{{ $comment->user_name }}</strong>
                                            <span
                                                class="text-muted">{{ \Carbon\Carbon::parse($comment->tanggal)->diffForHumans() }}</span>
                                        </p>
                                        <p class="mb-0" style="text-align: justify">{{ $comment->komentar }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
