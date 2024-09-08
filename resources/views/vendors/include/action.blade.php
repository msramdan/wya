<td>
    <div class="modal fade" id="exampleModalPic{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ trans('vendor/index.contact_vendor') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered dataTables-example" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans('vendor/index.name') }}</th>
                                <th>{{ trans('vendor/index.phone') }}</th>
                                <th>{{ trans('vendor/index.email') }}</th>
                                <th>{{ trans('vendor/index.remark') }}</th>
                            </tr>
                        </thead>
                        @php
                            $pic = DB::table('vendor_pics')
                                ->where('vendor_id', '=', $model->id)
                                ->orderBy('id', 'DESC')
                                ->limit(100)
                                ->get();
                        @endphp
                        <tbody>
                            @foreach ($pic as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Vendor : <span id="name_file"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <hr>
                </div>
                <div class="modal-body">
                    <center>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <span id="result" style="width: 700px;height:500px; margin:0px"></span>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @can('vendor edit')
        <a href="{{ route('vendors.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan
    @can('vendor delete')
        <form action="{{ route('vendors.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
    <div class="btn-group">
        <button class="btn btn-md btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-cog"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            {{-- <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#detailEquipment{{ $model->id }}">
                    Detail
                </a>
            </li> --}}
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#exampleModalPic{{ $model->id }}">
                    PIC Vendor
                </a>
            </li>
            <li>
                <a href="#" type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#largeModal" data-id="{{ $model->id }}" id="view_gambar">
                    File Vendor
                </a>
            </li>
        </ul>
    </div>



</td>

<script>
    $('.dataTables-example').DataTable();
</script>
