@extends('layouts.app')

@section('title', __('Detail of Aduans'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Aduans') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/panel">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('aduans.index') }}">{{ __('Aduans') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Detail') }}
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama') }}</td>
                                        <td>{{ $aduan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $aduan->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Judul') }}</td>
                                        <td>{{ $aduan->judul }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Keterangan') }}</td>
                                        <td>{{ $aduan->keterangan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal') }}</td>
                                        <td>{{ $aduan->tanggal }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Type') }}</td>
                                        <td>{{ $aduan->type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Read') }}</td>
                                        <td>{{ $aduan->is_read }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status') }}</td>
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
                                    <tr>
                                        <td class="fw-bold">{{ __('Token') }}</td>
                                        @if ($aduan->token != null)
                                            <td><b>{{ $aduan->token }}</b></td>
                                        @else
                                            <td><b>-</b></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"
                                    aria-hidden="true"></i> {{ __('Kembali') }}</a>
                            @can('update aduan')
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#statusModal">{{ __('Update Status') }}</button>
                            @endcan

                            <!-- Modal -->
                            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusModalLabel">{{ __('Update Status Aduan') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('aduans.updateStatus', $aduan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="status"
                                                        class="form-label">{{ __('Status Baru') }}</label>
                                                    <select class="form-select" id="status_aduan" name="status_aduan"
                                                        required>
                                                        <option value="Dalam Penanganan"
                                                            {{ $aduan->status == 'Dalam Penanganan' ? 'selected' : '' }}>
                                                            {{ __('Dalam Penanganan') }}
                                                        </option>
                                                        <option value="Ditolak"
                                                            {{ $aduan->status == 'Ditolak' ? 'selected' : '' }}>
                                                            {{ __('Ditolak') }}
                                                        </option>
                                                        <option value="Selesai"
                                                            {{ $aduan->status == 'Selesai' ? 'selected' : '' }}>
                                                            {{ __('Selesai') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom untuk form komentar dan daftar komentar -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ __('Komentar') }}</h5>
                            <div class="comments-list">
                                @forelse ($comments as $comment)
                                    <div class="comment-item mb-3 d-flex">
                                        <!-- Avatar -->
                                        @if ($comment->user_avatar == null)
                                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($comment->user_email))) }}&s=450"
                                                alt="{{ $comment->user_name }}" class="rounded-circle me-3" width="40"
                                                height="40">
                                        @else
                                            <img src="{{ asset('uploads/images/avatars/' . $comment->user_avatar) }}"
                                                alt="{{ $comment->user_name }}" class="rounded-circle me-3" width="40"
                                                height="40">
                                        @endif
                                        <div>
                                            <p class="mb-1">
                                                <strong>{{ $comment->user_name }}</strong>
                                                <span
                                                    class="text-muted">{{ \Carbon\Carbon::parse($comment->tanggal)->diffForHumans() }}</span>
                                            </p>
                                            <p class="mb-0" style="text-align: justify">{{ $comment->komentar }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>{{ __('Belum ada komentar.') }}</p>
                                @endforelse
                            </div>
                            <br>
                            @can('respon aduan')
                                <form action="{{ route('aduans.comments.store', $aduan->id) }}" method="POST" style="margin-bottom: 50px">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="comment" rows="3" placeholder="{{ __('Tulis komentar...') }}" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{ __('Kirim') }}</button>
                                </form>
                            @endcan

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
