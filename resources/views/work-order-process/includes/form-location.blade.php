<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3>Location</h3>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" value="{{ $workOrder->equipment->equipment_location->location_name }}" class="form-control" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="initial_temperature">Initial Temperature (℃)</label>
                <input type="number" step="any" name="initial_temperature" id="initial_temperature" class="form-control @error('initial_temperature') is-invalid @enderror" value="{{ old('initial_temperature') ? old('initial_temperature') : $workOrderProcesess->initial_temperature }}" {{ $readonly ? 'disabled' : '' }}>
                @error('initial_temperature')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="initial_humidity">Initial Humidity (℃)</label>
                <input type="number" step="any" name="initial_humidity" id="initial_humidity" class="form-control @error('initial_humidity') is-invalid @enderror" value="{{ old('initial_humidity') ? old('initial_humidity') : $workOrderProcesess->initial_humidity }}" {{ $readonly ? 'disabled' : '' }}>
                @error('initial_humidity')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="final_temperature">Final Temperature (℃)</label>
                <input type="number" step="any" name="final_temperature" id="final_temperature" class="form-control @error('final_temperature') is-invalid @enderror" value="{{ old('final_temperature') ? old('final_temperature') : $workOrderProcesess->final_temperature }}" {{ $readonly ? 'disabled' : '' }}>
                @error('final_temperature')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="final_humidity">Final Humidity (℃)</label>
                <input type="number" step="any" name="final_humidity" id="final_humidity" class="form-control @error('final_humidity') is-invalid @enderror" value="{{ old('final_humidity') ? old('final_humidity') : $workOrderProcesess->final_humidity }}" {{ $readonly ? 'disabled' : '' }}>
                @error('final_humidity')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>
