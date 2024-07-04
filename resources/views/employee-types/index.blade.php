@extends('layouts.app')

@section('title', __('Employee Types'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('employee/type/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ trans('employee/type/index.head') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('employee type create')
                                <a href="{{ route('employee-types.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ trans('employee/type/index.create') }}</a>
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
                                                    <option value="">--
                                                        {{ trans('employee/type/index.select_hospital') }} --</option>
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

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            @if (!Auth::user()->roles->first()->hospital_id)
                                                <th>{{ trans('employee/type/index.hospital') }}</th>
                                            @endif
                                            <th>{{ trans('employee/type/index.name') }}</th>
                                            <th>{{ trans('employee/type/index.action') }}</th>
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
            @if (!Auth::user()->roles->first()->hospital_id)
                {
                    data: 'hospital',
                    name: 'hospital',
                },
            @endif {
                data: 'name_employee_type',
                name: 'name_employee_type',
            },
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
                url: "{{ route('employee-types.index') }}",
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
