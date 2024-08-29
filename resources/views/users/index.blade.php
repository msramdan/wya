@extends('layouts.app')

@section('title', __('Users'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('utilities/users/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ trans('utilities/users/index.head') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('user create')
                                <a href="{{ route('users.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ trans('utilities/users/index.create') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('utilities/users/index.avatar') }}</th>
                                            <th>{{ trans('utilities/users/index.role') }}</th>
                                            <th>{{ trans('utilities/users/index.name') }}</th>
                                            <th>{{ trans('utilities/users/index.email') }}</th>
                                            <th>{{ trans('utilities/users/index.phone') }}</th>
                                            <th>{{ trans('utilities/users/index.action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'avatar',
                name: 'avatar',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return `<div class="avatar">
                            <img src="${data}" alt="avatar" style="width:75px">
                        </div>`;
                }
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'no_hp',
                name: 'no_hp'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('users.index') }}",
                data: function(s) {}
            },
            columns: columns
        })
    </script>
@endpush
