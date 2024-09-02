@extends('layouts.app')

@section('title', __('Edit Moving Equipment'))

@section('content')

    <div class="modal fade" id="modal-return" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Return Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('loans.update', $loan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="waktu-dikembalikan">{{ __('Waktu Dikembalikan') }}</label>
                                <input required type="datetime-local" name="waktu_dikembalikan" id="waktu-dikembalikan"
                                    class="form-control" value="" placeholder="{{ __('Waktu Dikembalikan') }}" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="catatan-pengembalian">{{ __('Catatan Pengembalian') }}</label>
                                    <textarea required name="catatan_pengembalian" id="catatan-pengembalian" class="form-control"
                                        placeholder="{{ __('Catatan Pengembalian') }}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="bukti_pengembalian">{{ __('Bukti Pengembalian') }}</label>
                                    <input type="file" name="bukti_pengembalian" class="form-control"
                                        id="bukti_pengembalian" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Moving Equipment') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('loans.index') }}">{{ __('Moving Equipment') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
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
                            @include('loans.include.form_edit')
                            <a href="{{route('loans.index')}}" class="btn btn-secondary"><i
                                    class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>
                            @if ($loan->status_peminjaman == 'Sudah dikembalikan')
                                <a href="#" type="button" class="btn btn-success disabled">
                                    <i class="mdi mdi-cached"></i> Return Equipment
                                </a>
                            @elseif($loan->status_peminjaman == 'Belum dikembalikan')
                                <a href="#" type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modal-return">
                                    <i class="mdi mdi-cached"></i> Return Equipment
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script type="text/javascript">
        $(document).on('click', '#view_photo_eq', function() {
            var photo_eq = $(this).data('photo_eq');
            var name_photo = $(this).data('name_photo');
            $('#largeModalPhoto #photo_eq').attr("src", "../../../storage/img/moving_photo/" + photo_eq);
            $('#largeModalPhoto #name_photo').text(name_photo);
        })
    </script>
@endpush
