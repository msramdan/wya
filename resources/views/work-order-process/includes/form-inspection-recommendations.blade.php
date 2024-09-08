<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Inspection Recommendations</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tools_can_be_used_well" class="form-check-input"
                            type="checkbox" value="1" id="tools_can_be_used_well"
                            @if (old('tools_can_be_used_well')) {{ old('tools_can_be_used_well') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tools_can_be_used_well == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tools_can_be_used_well">Alat Berfungsi Baik</label>
                    </div>
                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tool_need_calibration" class="form-check-input"
                            type="checkbox" value="1" id="tool_need_calibration"
                            @if (old('tool_need_calibration')) {{ old('tool_need_calibration') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tool_need_calibration == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tool_need_calibration" style="color: red">
                            Alat Perlu Kalibrasi
                        </label>
                    </div>

                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tool_need_repair" class="form-check-input"
                            type="checkbox" value="1" id="tool_need_repair"
                            @if (old('tool_need_repair')) {{ old('tool_need_repair') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tool_need_repair == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tool_need_repair" style="color: red">
                            Alat Rusak Ringan, Perlu Perbaikan
                        </label>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tool_can_be_used_need_replacement_accessories"
                            class="form-check-input" type="checkbox" value="1"
                            id="tool_can_be_used_need_replacement_accessories"
                            @if (old('tool_can_be_used_need_replacement_accessories')) {{ old('tool_can_be_used_need_replacement_accessories') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tool_can_be_used_need_replacement_accessories == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tool_can_be_used_need_replacement_accessories">
                            Alat Berfungsi Baik, Perlu Penggantian Part / Acessoris
                        </label>
                    </div>

                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tool_cannot_be_used" class="form-check-input"
                            type="checkbox" value="1" id="tool_cannot_be_used"
                            @if (old('tool_cannot_be_used')) {{ old('tool_cannot_be_used') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tool_cannot_be_used == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tool_cannot_be_used" style="color: red">
                            Alat Rusak Berat, Tidak Dapat Digunakan
                        </label>
                    </div>

                    <div class="form-check">
                        <input {{ $readonly ? 'disabled' : '' }} name="tool_need_bleaching" class="form-check-input"
                            type="checkbox" value="1" id="tool_need_bleaching"
                            @if (old('tool_need_bleaching')) {{ old('tool_need_bleaching') == 1 ? 'checked' : '' }}
                            @else
                            {{ $workOrderProcesess->tool_need_bleaching == 1 ? 'checked' : '' }} @endif>
                        <label class="form-check-label" for="tool_need_bleaching" style="color: red">
                            ⁠Alat Rusak Berat, Rekomendasi Penghapusan Asset
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
