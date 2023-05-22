<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Electrical Safety</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="mesh_voltage">Mesh Voltage (VAC)</label>
                        <input type="number" step="any" name="mesh_voltage"
                            class="form-control @error('mesh_voltage') is-invalid @enderror" id="mesh_voltage"
                            value="{{ old('mesh_voltage') ? old('mesh_voltage') : $workOrderProcesess->mesh_voltage }}"{{ $readonly ? 'disabled' : '' }}>

                        @error('mesh_voltage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="ups">UPS (VAC)</label>
                        <input type="number" step="any" name="ups"
                            class="form-control @error('ups') is-invalid @enderror" id="ups"
                            value="{{ old('ups') ? old('ups') : $workOrderProcesess->ups }}"{{ $readonly ? 'disabled' : '' }}>

                        @error('ups')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="grounding">Grounding (OHM)</label>
                        <input type="number" step="any" name="grounding"
                            class="form-control @error('grounding') is-invalid @enderror" id="grounding"
                            value="{{ old('grounding') ? old('grounding') : $workOrderProcesess->grounding }}"{{ $readonly ? 'disabled' : '' }}>

                        @error('grounding')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="leakage_electric">Leakage Electric (uA)</label>
                        <input type="number" step="any" name="leakage_electric"
                            class="form-control @error('leakage_electric') is-invalid @enderror" id="leakage_electric"
                            value="{{ old('leakage_electric') ? old('leakage_electric') : $workOrderProcesess->leakage_electric }}"{{ $readonly ? 'disabled' : '' }}>

                        @error('leakage_electric')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
