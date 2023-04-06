<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Inspection Recommendations</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-check">
                        <input name="tools_can_be_used_well" class="form-check-input" type="checkbox" value="1" {{ $workOrderProcesess->tools_can_be_used_well == 1 ? 'checked' : '' }} id="tools_can_be_used_well">
                        <label class="form-check-label" for="tools_can_be_used_well">Tools Can Be Used Well</label>
                    </div>
                    <div class="form-check">
                        <input name="tool_cannot_be_used" class="form-check-input" type="checkbox" value="1" {{ $workOrderProcesess->tool_cannot_be_used == 1 ? 'checked' : '' }} id="tool_cannot_be_used">
                        <label class="form-check-label" for="tool_cannot_be_used" style="color: red">
                            Tool Cannot Be Used
                        </label>
                    </div>
                    <div class="form-check">
                        <input name="tool_need_repair" class="form-check-input" type="checkbox" value="1" {{ $workOrderProcesess->tool_need_repair == 1 ? 'checked' : '' }} id="tool_need_repair">
                        <label class="form-check-label" for="tool_need_repair" style="color: red">
                            Tool Needs Repair
                        </label>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="form-check">
                        <input name="tool_can_be_used_need_replacement_accessories" class="form-check-input" {{ $workOrderProcesess->tool_can_be_used_need_replacement_accessories == 1 ? 'checked' : '' }} type="checkbox" value="1" id="tool_can_be_used_need_replacement_accessories">
                        <label class="form-check-label" for="tool_can_be_used_need_replacement_accessories">
                            Tools Can Be Used Need Replacement Accessories
                        </label>
                    </div>
                    <div class="form-check">
                        <input name="tool_need_calibration" class="form-check-input" type="checkbox" value="1" {{ $workOrderProcesess->tool_need_calibration == 1 ? 'checked' : '' }} id="tool_need_calibration">
                        <label class="form-check-label" for="tool_need_calibration" style="color: red">
                            Tool Needs Calibration
                        </label>
                    </div>
                    <div class="form-check">
                        <input name="tool_need_bleaching" class="form-check-input" type="checkbox" value="1" {{ $workOrderProcesess->tool_need_bleaching == 1 ? 'checked' : '' }} id="tool_need_bleaching">
                        <label class="form-check-label" for="tool_need_bleaching" style="color: red">
                            Tools Need Bleaching
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
