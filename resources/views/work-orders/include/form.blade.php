<div class="row ">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> Work Order Data</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="equipment-id">{{ __('WO Number') }}</label>
                        <input type="text" name="wo_number" id="wo_number" readonly class="form-control @error('wo_number') is-invalid @enderror" value="{{ isset($workOrder) ? $workOrder->wo_number : $woNumber }}" placeholder="" required />
                        @error('wo_number')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="filed-date">{{ __('Filed Date') }}</label>
                        <input type="date" name="filed_date" id="filed-date" readonly class="form-control @error('filed_date') is-invalid @enderror" value="{{ isset($workOrder) && $workOrder->filed_date ? $workOrder->filed_date->format('Y-m-d') : date('Y-m-d') }}" placeholder="{{ __('Filed Date') }}" required />
                        @error('filed_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="type-wo">{{ __('Type Wo') }}</label>
                        <select class="form-control js-example-basic-multiple @error('type_wo') is-invalid @enderror" name="type_wo" id="type-wo" required>
                            <option value="" selected disabled>-- {{ __('Select type wo') }} --</option>
                            <option value="Calibration" {{ isset($workOrder) && $workOrder->type_wo == 'Calibration' ? 'selected' : (old('type_wo') == 'Calibration' ? 'selected' : '') }}>
                                {{ __('Calibration') }}</option>
                            <option value="Service" {{ isset($workOrder) && $workOrder->type_wo == 'Service' ? 'selected' : (old('type_wo') == 'Service' ? 'selected' : '') }}>
                                {{ __('Service') }}</option>
                            <option value="Training" {{ isset($workOrder) && $workOrder->type_wo == 'Training' ? 'selected' : (old('type_wo') == 'Training' ? 'selected' : '') }}>
                                {{ __('Training') }}</option>
                            <option value="Inspection and Preventive Maintenance" {{ isset($workOrder) && $workOrder->type_wo == 'Inspection and Preventive Maintenance' ? 'selected' : (old('type_wo') == 'Inspection and Preventive Maintenance' ? 'selected' : '') }}>
                                {{ __('Inspection and Preventive Maintenance') }}</option>`
                        </select>
                        @error('type_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="category-wo">{{ __('Category Wo') }}</label>
                        <select class="form-control js-example-basic-multiple @error('category_wo') is-invalid @enderror" name="category_wo" id="category-wo" required>
                            <option value="" selected disabled>-- {{ __('Select category wo') }} --</option>
                            <option value="Rutin" {{ isset($workOrder) && $workOrder->category_wo == 'Rutin' ? 'selected' : (old('category_wo') == 'Rutin' ? 'selected' : '') }}>
                                {{ __('Rutin') }}</option>
                            <option value="Non Rutin" {{ isset($workOrder) && $workOrder->category_wo == 'Non Rutin' ? 'selected' : (old('category_wo') == 'Non Rutin' ? 'selected' : '') }}>
                                {{ __('Non Rutin') }}</option>
                        </select>
                        @error('category_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="note">{{ __('Note') }}</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" placeholder="{{ __('Note') }}" required>{{ isset($workOrder) ? $workOrder->note : old('note') }}</textarea>
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
                    <b> Equipment Data</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <center>
                            <label for="equipment-id">{{ __('Search by Qrcode') }}</label> <br>
                            <img src="{{ asset('material/qr.png') }}" alt="" style="width: 50%">

                        </center>

                    </div>
                    <div class="col-md-8 mb-2">
                        <label for="location_id">{{ __('Search by Location') }}</label>
                        <select class="form-control js-example-basic-multiple  @error('location_id') is-invalid @enderror" name="location_id" id="location_id" required>
                            <option value="" selected disabled>-- {{ __('Select location') }} --</option>
                            @foreach ($equipmentLocations as $equipmentLocation)
                                <option value="{{ $equipmentLocation->id }}" @if (old('location_id')) {{ old('location_id') == $equipmentLocation->id ? 'selected' : '' }}
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
                        <label for="equipment-id">{{ __('Equipment') }}</label>
                        <select class="form-control js-example-basic-multiple @error('equipment_id') is-invalid @enderror" name="equipment_id" id="equipment-id" required>
                            <option value="" selected disabled>-- {{ __('Select equipment') }} --</option>
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

        {{-- <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> <i class="fa-solid fa-money-bill"></i> Price Reduction</b>
                </div>
                <hr>
            </div>
        </div> --}}

    </div>

    <div class="col-md-6 {{ old('category_wo') ? '' : 'd-none' }}" id="schedule-information-container">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> Schedule Information</b>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="schedule-date">{{ __('Schedule Date') }}</label>
                        <input type="date" name="schedule_date" id="schedule-date" class="form-control @error('schedule_date') is-invalid @enderror" value="{{ isset($workOrder) && $workOrder->schedule_date ? $workOrder->schedule_date->format('Y-m-d') : old('schedule_date') }}" placeholder="{{ __('Schedule Date') }}" />
                        @error('schedule_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2 {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}">
                        <label for="schedule-wo">{{ __('Schedule Wo') }}</label>
                        <select class="form-control js-example-basic-multiple @error('schedule_wo') is-invalid @enderror" name="schedule_wo" id="schedule-wo">
                            <option value="" selected disabled>-- {{ __('Select schedule wo') }} --</option>
                            <option value="Harian" {{ isset($workOrder) && $workOrder->schedule_wo == 'Harian' ? 'selected' : (old('schedule_wo') == 'Harian' ? 'selected' : '') }}>
                                {{ __('Harian') }}</option>
                            <option value="Mingguan" {{ isset($workOrder) && $workOrder->schedule_wo == 'Mingguan' ? 'selected' : (old('schedule_wo') == 'Mingguan' ? 'selected' : '') }}>
                                {{ __('Mingguan') }}</option>
                            <option value="Bulanan" {{ isset($workOrder) && $workOrder->schedule_wo == 'Bulanan' ? 'selected' : (old('schedule_wo') == 'Bulanan' ? 'selected' : '') }}>
                                {{ __('Bulanan') }}</option>
                            <option value="2 Bulanan" {{ isset($workOrder) && $workOrder->schedule_wo == '2 Bulanan' ? 'selected' : (old('schedule_wo') == '2 Bulanan' ? 'selected' : '') }}>
                                {{ __('2 Bulanan') }}</option>
                            <option value="3 Bulanan" {{ isset($workOrder) && $workOrder->schedule_wo == '3 Bulanan' ? 'selected' : (old('schedule_wo') == '3 Bulanan' ? 'selected' : '') }}>
                                {{ __('3 Bulanan') }}</option>
                            <option value="4 Bulanan" {{ isset($workOrder) && $workOrder->schedule_wo == '4 Bulanan' ? 'selected' : (old('schedule_wo') == '4 Bulanan' ? 'selected' : '') }}>
                                {{ __('4 Bulanan') }}</option>
                            <option value="6 Bulanan" {{ isset($workOrder) && $workOrder->schedule_wo == '6 Bulanan' ? 'selected' : (old('schedule_wo') == '6 Bulanan' ? 'selected' : '') }}>
                                {{ __('6 Bulanan') }}</option>
                            <option value="Tahunan" {{ isset($workOrder) && $workOrder->schedule_wo == 'Tahunan' ? 'selected' : (old('schedule_wo') == 'Tahunan' ? 'selected' : '') }}>
                                {{ __('Tahunan') }}</option>
                        </select>
                        @error('schedule_wo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2 {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}">
                        <label for="start-date">{{ __('Start Date') }}</label>
                        <input type="date" name="start_date" id="start-date" class="form-control @error('start_date') is-invalid @enderror" value="{{ isset($workOrder) && $workOrder->start_date ? $workOrder->start_date : old('start_date') }}" placeholder="{{ __('Schedule Date') }}" />
                        @error('start_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2 {{ old('category_wo') == 'Non Rutin' ? 'd-none' : '' }}">
                        <label for="end-date">{{ __('End Date') }}</label>
                        <input type="date" name="end_date" id="end-date" class="form-control @error('end_date') is-invalid @enderror" value="{{ isset($workOrder) && $workOrder->end_date ? $workOrder->end_date : old('end_date') }}" placeholder="{{ __('Schedule Date') }}" />
                        @error('end_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>


    </div>

    <div class="col-md-6 d-none" id="container-equipment-detail">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <b> Equipment Detail</b>
                </div>
                <hr>
                <div id="equipment-detail-content">

                </div>
            </div>
        </div>
    </div>
</div>
