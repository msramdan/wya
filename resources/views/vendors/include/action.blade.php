<td>
    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" title="View PIC"
        data-bs-target="#exampleModalPic{{ $model->id }}">
        <i class="mdi mdi-phone-classic"></i>
    </button>
    <div class="modal fade" id="exampleModalPic{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Contact Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered dataTables-example" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Remark') }}</th>
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


    <a href="#" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-id="{{ $model->id }}"
        id="view_gambar" data-bs-target="#largeModal" title="View  File Vendor"><i class="mdi mdi-file"></i>
    </a>
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
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan

</td>

<script>
    $('.dataTables-example').DataTable();
</script>
