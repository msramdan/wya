<div class="row ">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> {{ trans('work-order/submission/form.wo_data') }}</b>
                </div>
                <hr>

                <div class="row">
                    @if (!session('sessionHospital'))
                        <div class="col-md-12 mb-2">
                            <label for="hospital_id">{{ trans('work-order/submission/form.hospital') }}</label>
                            <select
                                class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                                name="hospital_id" id="hospital_id" required>
                                <option value="" selected disabled>--
                                    {{ trans('work-order/submission/form.filter_hospital') }} --</option>
                                @if (isset($workOrder))
                                    @foreach ($hispotals as $hispotal)
                                        <option value="{{ $hispotal->id }}"
                                            {{ $workOrder->hospital_id == $hispotal->id ? 'selected' : '' }}
                                            {{ $workOrder->hospital_id != $hispotal->id ? 'disabled' : '' }}>
                                            {{ $hispotal->name }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($hispotals as $hispotal)
                                        <option value="{{ $hispotal->id }}"
                                            {{ isset($workOrder) && $workOrder->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                                            {{ $hispotal->name }}
                                        </option>
                                    @endforeach
                                @endif


                            </select>
                            @error('hospital_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" readonly value="{{ session('sessionHospital') }}"
                            id="hospital_id" name="hospital_id">
                    @endif
                    <div class="col-md-6 mb-2">
                        <label for="equipment-id">{{ trans('work-order/submission/form.wo_number') }}</label>
                        <input type="text" name="wo_number" id="wo_number" readonly
                            class="form-control @error('wo_number') is-invalid @enderror"
                            value="{{ isset($workOrder) ? $workOrder->wo_number : $woNumber }}" placeholder=""
                            required />
                        @error('wo_number')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="filed-date">{{ trans('work-order/submission/form.filed_date') }}</label>
                        <input type="date" name="filed_date" id="filed-date" readonly
                            class="form-control @error('filed_date') is-invalid @enderror"
                            value="{{ isset($workOrder) && $workOrder->filed_date ? $workOrder->filed_date->format('Y-m-d') : date('Y-m-d') }}"
                            placeholder="{{ __('Filed Date') }}" required />
                        @error('filed_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="type-wo">{{ trans('work-order/submission/form.type_wo') }}</label>
                        <select class="form-control js-example-basic-multiple @error('type_wo') is-invalid @enderror"
                            name="type_wo" id="type-wo" required>
                            <option value="" selected disabled>--
                                {{ trans('work-order/submission/form.filter_type_wo') }} --</option>
                            <option value="Calibration"
                                {{ isset($workOrder) && $workOrder->type_wo == 'Calibration' ? 'selected' : (old('type_wo') == 'Calibration' ? 'selected' : '') }}>
                                {{ __('Calibration') }}</option>
                            <option value="Service"
                                {{ isset($workOrder) && $workOrder->type_wo == 'Service' ? 'selected' : (old('type_wo') == 'Service' ? 'selected' : '') }}>
                                {{ __('Service') }}</option>
                            <option value="Training"
                                {{ isset($workOrder) && $workOrder->type_wo == 'Training' ? 'selected' : (old('type_wo') == 'Training' ? 'selected' : '') }}>
                                {{ __('Training/Uji fungsi') }}</option>
                            <option value="Inspection and Preventive Maintenance"
                                {{ isset($workOrder) && $workOrder->type_wo == 'Inspection and Preventive Maintenance' ? 'selected' : (old('type_wo') == 'Inspection and Preventive Maintenance' ? 'selected' : '') }}>
                                {{ __('Inspection and Preventive Maintenance') }}</option>`
                        </select>
                        @error('type_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="category-wo">{{ trans('work-order/submission/form.category_wo') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('category_wo') is-invalid @enderror"
                            name="category_wo" id="category-wo" required>
                            <option value="" selected disabled>--
                                {{ trans('work-order/submission/form.filter_category_wo') }} --</option>
                            <option value="Rutin"
                                {{ isset($workOrder) && $workOrder->category_wo == 'Rutin' ? 'selected' : (old('category_wo') == 'Rutin' ? 'selected' : '') }}>
                                {{ __('Rutin') }}</option>
                            <option value="Non Rutin"
                                {{ isset($workOrder) && $workOrder->category_wo == 'Non Rutin' ? 'selected' : (old('category_wo') == 'Non Rutin' ? 'selected' : '') }}>
                                {{ __('Non Rutin') }}</option>
                        </select>
                        @error('category_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">{{ trans('work-order/submission/form.note') }}</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                placeholder="{{ trans('work-order/submission/form.note') }}" required>{{ isset($workOrder) ? $workOrder->note : old('note') }}</textarea>
                            @error('note')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> {{ trans('work-order/submission/form.equipment_data') }}</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <center onclick="showQrScanner()">
                            <label for="equipment-id">{{ trans('work-order/submission/form.search_qr') }}</label> <br>
                            <img src="{{ asset('material/qr.png') }}" alt="" style="width: 50%">

                        </center>

                    </div>
                    <div class="col-md-8 mb-2">
                        <label for="location_id">{{ trans('work-order/submission/form.search_location') }}</label>
                        <select
                            class="form-control js-example-basic-multiple  @error('location_id') is-invalid @enderror"
                            name="location_id" id="location_id" required>
                            <option value="" selected disabled>--
                                {{ trans('work-order/submission/form.filter_location') }} --</option>
                            @foreach ($equipmentLocations as $equipmentLocation)
                                <option value="{{ $equipmentLocation->id }}"
                                    @if (old('location_id')) {{ old('location_id') == $equipmentLocation->id ? 'selected' : '' }}
                                    @elseif(isset($workOrder))
                                    {{ $workOrderObj->equipment->equipment_location_id == $equipmentLocation->id ? 'selected' : '' }} @endif>
                                    {{ $equipmentLocation->location_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <br> <br>
                        <label for="equipment-id">{{ trans('work-order/submission/form.equipment') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('equipment_id') is-invalid @enderror"
                            name="equipment_id" id="equipment-id" required>
                            <option value="" selected disabled>--
                                {{ trans('work-order/submission/form.filter_location') }} --</option>
                        </select>
                        @error('equipment_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 {{ old('category_wo') ? '' : (isset($workOrder) ? '' : 'd-none') }}"
        id="schedule-information-container">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> {{ trans('work-order/submission/form.schedule_information') }}</b>
                </div>
                <hr>

                <div class="row">
                    <div
                        class="col-md-6 mb-2
                    @if (old('category_wo')) {{ old('category_wo') == 'Rutin' ? 'd-none' : '' }}
                    @elseif(isset($workOrder))
                    {{ $workOrder->category_wo == 'Rutin' ? 'd-none' : '' }} @endif

                    ">
                        <label for="schedule-date">{{ __('Schedule Date') }}</label>
                        <input type="date" name="schedule_date" id="schedule-date"
                            class="form-control @error('schedule_date') is-invalid @enderror"
                            value="{{ isset($workOrder) && $workOrder->schedule_date ? $workOrder->schedule_date->format('Y-m-d') : old('schedule_date') }}"
                            placeholder="{{ __('Schedule Date') }}" />
                        @error('schedule_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div
                        class="col-md-6 mb-2

                    @if (old('category_wo')) {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}
                    @elseif(isset($workOrder))
                    {{ $workOrder->category_wo == 'Non Rutin' ? 'd-none' : '' }} @endif

                    ">
                        <label for="schedule-wo">{{ trans('work-order/submission/form.schedule_wo') }}</label>
                        <select
                            class="form-control js-example-basic-multiple @error('schedule_wo') is-invalid @enderror"
                            name="schedule_wo" id="schedule-wo">
                            <option value="" selected disabled>--
                                {{ trans('work-order/submission/form.filter_schedule_wo') }} --</option>
                            <option value="Harian"
                                {{ isset($workOrder) && $workOrder->schedule_wo == 'Harian' ? 'selected' : (old('schedule_wo') == 'Harian' ? 'selected' : '') }}>
                                {{ __('Harian') }}</option>
                            <option value="Mingguan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == 'Mingguan' ? 'selected' : (old('schedule_wo') == 'Mingguan' ? 'selected' : '') }}>
                                {{ __('Mingguan') }}</option>
                            <option value="Bulanan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == 'Bulanan' ? 'selected' : (old('schedule_wo') == 'Bulanan' ? 'selected' : '') }}>
                                {{ __('Bulanan') }}</option>
                            <option value="2 Bulanan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == '2 Bulanan' ? 'selected' : (old('schedule_wo') == '2 Bulanan' ? 'selected' : '') }}>
                                {{ __('2 Bulanan') }}</option>
                            <option value="3 Bulanan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == '3 Bulanan' ? 'selected' : (old('schedule_wo') == '3 Bulanan' ? 'selected' : '') }}>
                                {{ __('3 Bulanan') }}</option>
                            <option value="4 Bulanan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == '4 Bulanan' ? 'selected' : (old('schedule_wo') == '4 Bulanan' ? 'selected' : '') }}>
                                {{ __('4 Bulanan') }}</option>
                            <option value="6 Bulanan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == '6 Bulanan' ? 'selected' : (old('schedule_wo') == '6 Bulanan' ? 'selected' : '') }}>
                                {{ __('6 Bulanan') }}</option>
                            <option value="Tahunan"
                                {{ isset($workOrder) && $workOrder->schedule_wo == 'Tahunan' ? 'selected' : (old('schedule_wo') == 'Tahunan' ? 'selected' : '') }}>
                                {{ __('Tahunan') }}</option>
                        </select>
                        @error('schedule_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div
                        class="col-md-6 mb-2

                    @if (old('category_wo')) {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}
                    @elseif(isset($workOrder))
                    {{ $workOrder->category_wo == 'Non Rutin' ? 'd-none' : '' }} @endif

                    ">
                        <label for="start-date">{{ trans('work-order/submission/form.start_date') }}</label>
                        <input type="date" name="start_date" id="start-date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ isset($workOrder) && $workOrder->start_date ? $workOrder->start_date : old('start_date') }}"
                            placeholder="{{ __('Schedule Date') }}" />
                        @error('start_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div
                        class="col-md-6 mb-2

                    @if (old('category_wo')) {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}
                    @elseif(isset($workOrder))
                    {{ $workOrder->category_wo == 'Non Rutin' ? 'd-none' : '' }} @endif

                    ">
                        <label for="end-date">{{ trans('work-order/submission/form.end_date') }}</label>
                        <input type="date" name="end_date" id="end-date"
                            class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ isset($workOrder) && $workOrder->end_date ? $workOrder->end_date : old('end_date') }}"
                            placeholder="{{ __('Schedule Date') }}" />
                        @error('end_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="border rounded p-2">
                            <div class="col-4">
                                <div class="form-group d-none" id="group-viewmode">
                                    <label for="view_mode">{{ trans('work-order/submission/form.view_mode') }}</label>
                                    <select name="view_mode" id="view_mode"
                                        class="form-control js-example-basic-multiple">
                                        <option value="Day">Day</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="gantt"></div>
                                <div id="table-container" class="d-none">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Start Date</th>
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
        </div>
    </div>

    <div class="col-md-6 d-none" id="container-equipment-detail">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> {{ trans('work-order/submission/form.equipment_detail') }}</b>
                </div>
                <hr>
                <div id="equipment-detail-content">

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa fa-file" aria-hidden="true"></i> Photo sebelum WO <span
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
