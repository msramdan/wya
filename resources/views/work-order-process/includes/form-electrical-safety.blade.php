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
                        <input type="text" name="mesh_voltage" class="form-control" id="mesh_voltage" value="{{ old('mesh_voltage') ? old('mesh_voltage') : $workOrderProcesess->mesh_voltage }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="ups">UPS (VAC)</label>
                        <input type="text" name="ups" class="form-control" id="ups" value="{{ old('ups') ? old('ups') : $workOrderProcesess->ups }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="grounding">Grounding (OHM)</label>
                        <input type="text" name="grounding" class="form-control" id="grounding" value="{{ old('grounding') ? old('grounding') : $workOrderProcesess->grounding }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="leakage_electric">Leakage Electric (uA)</label>
                        <input type="text" name="leakage_electric" class="form-control" id="leakage_electric" value="{{ old('leakage_electric') ? old('leakage_electric') : $workOrderProcesess->leakage_electric }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label for="electrical_safety_note">Note</label>
                        <textarea name="electrical_safety_note" class="form-control" placeholder="Note" style="height: 80px" id="electrical_safety_note" cols="30" rows="10">{{ $workOrderProcesess->electrical_safety_note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
