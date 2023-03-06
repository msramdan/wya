@extends('layouts.app')

@section('title', __('Cats'))

@section('content')
<div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Cats') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Cats') }}</li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                @can('cat create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('cats.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new cat') }}
                    </a>
                </div>
                @endcan
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="display dataTable no-footer" id="data-table" role="grid">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th>{{ __('Action') }}</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('cats.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
