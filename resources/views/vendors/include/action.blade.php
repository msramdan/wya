<td>
    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
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
        id="view_gambar" data-bs-target="#largeModal" title="View Gambar"><i class="mdi mdi-file"></i>
    </a>
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Vendor : <span id="modal_nama_produk"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <hr>
                </div>
                <div class="modal-body">
                    <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
                        <center>
                            <embed style="width: 580px; height:470px"
                                src="{{ asset('material/Scrum Open (Muhammad Saeful Ramdan).pdf') }}"
                                title="W3Schools Free Online Web Tutorials">
                        </center>
                        <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button'
                            data-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#carouselExampleIndicators' role='button'
                            data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                        </a>
                    </div>
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
@push('js')
    <script type="text/javascript">
        $(document).on('click', '#view_gambar', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#largeModal #modal_nama_produk').text(nama);
            console.log(id)

            // $.ajax({
            //     url: '/panel/GetGambarProduk/' + id,
            //     type: 'GET',

            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
            //     },
            //     data: {

            //     },
            //     success: function(html) {
            //         $("#result").html(html);
            //     }

            // });


        })
    </script>
@endpush
