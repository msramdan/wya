<td>
    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#qrcode-equipment"><i
            class='fa fa-qrcode'></i>
    </button>
    @can('equipment edit')
        <a href="{{ route('equipment.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('equipment delete')
        <form action="{{ route('equipment.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>

<!-- Modal -->
<div class="modal fade" id="qrcode-equipment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <table style="padding: 5px">
                        <thead>
                            <tr>
                                <td style="padding: 5px">{!! QrCode::size(150)->generate($model->barcode) !!}</td>
                            </tr>
                        </thead>
                    </table>
                    @if (setting_web()->logo != null)
                        <img style="width: 30%"
                            src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}" alt="">
                    @endif
                </center>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('print_qr_equipment', $model->barcode) }}" target="_blank" class="btn btn-danger "> <i
                        class="fa fa-print" aria-hidden="true"></i>
                    Print</a>
            </div>
        </div>
    </div>
</div>
