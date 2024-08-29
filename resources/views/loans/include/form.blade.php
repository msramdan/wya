<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <center onclick="showQrScanner()">
                            <label for="equipment-id">{{ trans('work-order/submission/form.search_qr') }}</label> <br>
                            <img src="{{ asset('material/qr.png') }}" alt="" style="width: 50%">
                        </center>
                    </div>
                    <div class="col-md-8">
                        <div class="col-md-12 mb-2">
                            <label for="lokasi_asal_id">{{ __('Resource location') }}</label>
                            <select
                                class="form-control js-example-basic-multiple  @error('lokasi_asal_id') is-invalid @enderror"
                                name="lokasi_asal_id" id="lokasi_asal_id" required>
                                <option value="" selected disabled>-- Select --</option>
                                @foreach ($equipmentLocations as $equipmentLocation)
                                    <option value="{{ $equipmentLocation->id }}"
                                        @if (old('lokasi_asal_id')) {{ old('lokasi_asal_id') == $equipmentLocation->id ? 'selected' : '' }}
                                        @elseif(isset($workOrder))
                                        {{ $workOrderObj->equipment->equipment_location_id == $equipmentLocation->id ? 'selected' : '' }} @endif>
                                        {{ $equipmentLocation->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_asal_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="equipment-id">{{ trans('work-order/submission/form.equipment') }}</label>
                            <select
                                class="form-control js-example-basic-multiple @error('equipment_id') is-invalid @enderror"
                                name="equipment_id" id="equipment-id" required>
                                <option value="" selected disabled>-- Select --</option>
                            </select>
                            @error('equipment_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="lokasi-peminjam-id">{{ __('Destination location') }}</label>
                            <select
                                class="form-control js-example-basic-multiple @error('lokasi_peminjam_id') is-invalid @enderror"
                                name="lokasi_peminjam_id" id="lokasi-peminjam-id" required>
                                <option value="" selected disabled>-- {{ __('Select Destination location') }} --
                                </option>
                            </select>
                            @error('lokasi_peminjam_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="col-md-12 d-none" id="container-equipment-detail">
                        <div class="card">
                            <div class="card-body">
                                <div id="equipment-detail-content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-2">
                    <label for="no-peminjaman">{{ __('No Peminjaman') }}</label>
                    <input type="text" name="no_peminjaman" id="no-peminjaman"
                        class="form-control @error('no_peminjaman') is-invalid @enderror"
                        value="{{ isset($loan) ? $loan->no_peminjaman : $noPeminjaman }}"
                        placeholder="{{ __('No Peminjaman') }}" required readonly />
                    @error('no_peminjaman')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="col-md-12 mb-2">
                    <label for="waktu-pinjam">{{ __('Waktu Pinjam') }}</label>
                    <input type="datetime-local" name="waktu_pinjam" id="waktu-pinjam"
                        class="form-control @error('waktu_pinjam') is-invalid @enderror"
                        value="{{ isset($loan) && $loan->waktu_pinjam ? $loan->waktu_pinjam->format('Y-m-d\TH:i') : old('waktu_pinjam') }}"
                        placeholder="{{ __('Waktu Pinjam') }}" required />
                    @error('waktu_pinjam')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="col-md-12 mb-2">
                    <label for="rencana_pengembalian">{{ __('Rencana pengembalian') }}</label>
                    <input type="date" name="rencana_pengembalian" id="rencana_pengembalian"
                        class="form-control @error('rencana_pengembalian') is-invalid @enderror"
                        value="{{ isset($loan) && $loan->rencana_pengembalian ? $loan->rencana_pengembalian->format('Y-m-d\TH:i') : old('rencana_pengembalian') }}"
                        placeholder="{{ __('Rencana pengembalian') }}" required />
                    @error('rencana_pengembalian')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="alasan-peminjaman">{{ __('Alasan Peminjaman') }}</label>
                        <textarea name="alasan_peminjaman" id="alasan-peminjaman"
                            class="form-control @error('alasan_peminjaman') is-invalid @enderror" placeholder="{{ __('Alasan Peminjaman') }}"
                            required>{{ isset($loan) ? $loan->alasan_peminjaman : old('alasan_peminjaman') }}</textarea>
                        @error('alasan_peminjaman')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 mb-2">
                    <label for="pic-penanggungjawab">{{ __('Pic Penanggungjawab') }}</label>
                    <select
                        class="form-control js-example-basic-multiple @error('pic_penanggungjawab') is-invalid @enderror"
                        name="pic_penanggungjawab" id="pic-penanggungjawab" required>
                        <option value="" selected disabled>-- {{ __('Select') }} --</option>
                    </select>
                    @error('pic_penanggungjawab')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- photo --}}
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-file" aria-hidden="true"></i> Bukti peminjaman <span
                            style="color:red; font-size:11px">(
                            Rekomendasi gambar adalah jpg/png ) </span></b>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button style="margin-bottom: 10px;" type="button" name="add_berkas3" id="add_berkas3"
                            class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>
                            {{ trans('inventory/equipment/form.add_photo') }}</button>
                        <table class="table table-bordered" id="dynamic_field3">
                            <thead>
                                <tr>
                                    <th>{{ trans('inventory/equipment/form.desc') }}</th>
                                    <th style="width: 200px">{{ trans('inventory/equipment/form.file') }}</th>
                                    <th>{{ trans('inventory/equipment/form.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('css-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.css"
        integrity="sha512-b6CPl1eORfMoZgwWGEYWNxYv79KG0dALXfVu4uReZJOXAfkINSK4UhA0ELwGcBBY7VJN7sykwrCGQnbS8qTKhQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js-libs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"
        integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('js')
    <script>
        $('#lokasi_asal_id').on("select2:select", function(e) {
            eventChangeLocationId();
        });

        $('#equipment-id').on('select2:select', function(e) {
            eventChangeEquipmentId();
        });

        if ($('#lokasi_asal_id').val() != null) {
            eventChangeLocationId(() => {
                eventChangeEquipmentId();
            });
        }

        function eventChangeLocationId(cb = null) {
            const equipmentLocationId = $('#lokasi_asal_id').val();
            const valueEquipmentId = '{{ old('equipment_id') }}';

            fetch(`{{ route('api.equipment.index') }}?equipment_location_id=${equipmentLocationId}`)
                .then((res) => res.json())
                .then((response) => {
                    $('#equipment-id').select2('destroy');
                    $("#equipment-id").html('<option value="" selected disabled>-- Select equipment --</option>');

                    response.data.forEach((equipment) => {
                        $("#equipment-id").append(
                            `<option value="${equipment.id}" ${valueEquipmentId == equipment.id ? 'selected' : ''}>${equipment.serial_number} | ${equipment.type} | ${equipment.manufacturer}</option>`
                        );
                    });
                    $('#equipment-id').select2();
                    !$('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').addClass(
                        'd-none') : '';

                    if (cb != null) {
                        cb();
                    }
                });
        }

        function eventChangeEquipmentId() {
            const value = $('#equipment-id').val();

            fetch(`{{ route('api.equipment.index') }}/${value}`)
                .then((res) => res.json())
                .then((response) => {
                    let data = response.data;
                    $('#container-equipment-detail').hasClass('d-none') ? $('#container-equipment-detail').removeClass(
                        'd-none') : '';

                    $('#container-equipment-detail #equipment-detail-content').html(
                        `<div class="row">
                            <div class="col-lg-4">
                                <img src="/storage/img/equipment/${data.photo}" class="img-thumbnail" alt="">
                            </div>
                            <div class="col-lg-8">
                                <table class="table">
                                    <tr>
                                        <th>Barcode</th>
                                        <th>:</th>
                                        <td>${data.barcode}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Category</th>
                                        <th>:</th>
                                        <td>${data.equipment_category.category_name}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>:</th>
                                        <td>${data.vendor.name_vendor}</td>
                                    </tr>
                                    <tr>
                                        <th>Risk Level</th>
                                        <th>:</th>
                                        <td>${data.risk_level}</td>
                                    </tr>
                                    <tr>
                                        <th>Financing Code</th>
                                        <th>:</th>
                                        <td>${data.financing_code}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomenklatur</th>
                                        <th>:</th>
                                        <td>${data.nomenklatur.name_nomenklatur}</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>:</th>
                                        <td>${data.manufacturer}</td>
                                    </tr>
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>:</th>
                                        <td>${data.serial_number}</td>
                                    </tr>
                                    <tr>
                                        <th>Condition</th>
                                        <th>:</th>
                                        <td>${data.condition}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment Location</th>
                                        <th>:</th>
                                        <td>${data.equipment_location.location_name}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>`
                    );
                });
        }

        function showQrScanner() {
            const modalScanner = new bootstrap.Modal(document.getElementById('modalScanner'));
            modalScanner.show()

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "camera-scanner", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render((decodedText, decodedResult) => {
                fetch('{{ url('/') }}/api/equipments/' + decodedText + '/barcode')
                    .then((res) => res.json())
                    .then((response) => {
                        const data = response.data;
                        $('#lokasi_asal_id').val(data.equipment_location_id).trigger('change');
                        eventChangeLocationId(() => {
                            $('#equipment-id').val(data.id).trigger('change');
                            eventChangeEquipmentId();
                            modalScanner.hide();
                            html5QrcodeScanner.clear();
                        });
                    });
            });
        }
    </script>
@endpush
