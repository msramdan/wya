@extends('layouts.app')

@section('title', __('Positions'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Positions') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Positions') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('position create')
                                <a href="{{ route('positions.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new position') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            @if (!Auth::user()->roles->first()->hospital_id)
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <form class="form-inline" method="get">
                                            @csrf
                                            <div class="input-group mb-2 mr-sm-2">
                                                <select name="hospital_id" id="hospital_id"
                                                    class="form-control js-example-basic-multiple">
                                                    <option value="">-- Filter Hospital --</option>
                                                    @foreach ($hispotals as $hispotal)
                                                        <option value="{{ $hispotal->id }}"
                                                            {{ isset($unitItem) && $unitItem->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                                            {{ $hispotal->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Hospital') }}</th>
                                            <th>{{ __('Code Position') }}</th>
                                            <th>{{ __('Name Position') }}</th>
                                            {{-- <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th> --}}
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
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'hospital',
                name: 'hospital',
            },
            {
                data: 'code_position',
                name: 'code_position',
            },
            {
                data: 'name_position',
                name: 'name_position',
            },
            // {
            //     data: 'created_at',
            //     name: 'created_at'
            // },
            // {
            //     data: 'updated_at',
            //     name: 'updated_at'
            // },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]


        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('positions.index') }}",
                data: function(s) {
                    s.hospital_id = $('select[name=hospital_id] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        $('#hospital_id').change(function() {
            table.draw();
        })
    </script>
@endpush
