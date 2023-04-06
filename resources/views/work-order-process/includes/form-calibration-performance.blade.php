<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Calibration Performance</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tool Performance Check</th>
                            <th>Setting</th>
                            <th>Measurable</th>
                            <th>Reference Value</th>
                            <th class="text-center">Good</th>
                            <th class="text-center">Not Good</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($workOrderProcesess->calibrationPerformance as $index => $calibrationPerformance)
                            <tr data-index="{{ $index }}">
                                <td>
                                    <button class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowPerformanceCalibration(this.parentElement.parentElement)"
                                    @else
                                    onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Tool Performance Check" name="tool_performance_check[{{ $index }}]" class="form-control" id="tool_performance_check_{{ $index }}" value="{{ $calibrationPerformance->tool_performance_check }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Setting" name="setting[{{ $index }}]" class="form-control" id="setting_{{ $index }}" value="{{ $calibrationPerformance->setting }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Measurable" name="measurable[{{ $index }}]" class="form-control" id="measurable_{{ $index }}" value="{{ $calibrationPerformance->measurable }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Reference Value" name="reference_value[{{ $index }}]" class="form-control" id="reference_value_{{ $index }}" value="{{ $calibrationPerformance->reference_value }}">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="is_good[{{ $index }}]" class="form-check" value="1" {{ $calibrationPerformance->is_good == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="is_good[{{ $index }}]" class="form-check" value="0" {{ $calibrationPerformance->is_good == 0 ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-index="0">
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="addRowPerformanceCalibration(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Tool Performance Check" name="tool_performance_check[0]" class="form-control" id="tool_performance_check_0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Setting" name="setting[0]" class="form-control" id="setting_0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Measurable" name="measurable[0]" class="form-control" id="measurable_0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" placeholder="Reference Value" name="reference_value[0]" class="form-control" id="reference_value_0">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="is_good[0]" class="form-check" value="1">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="is_good[0]" class="form-check" value="0">
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <hr>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label">Performance Check Results</label>
                        <div class="form-check">
                            <input type="radio" id="calibration_performance_is_feasible_to_use_1" class="form-check-input" value="1" name="calibration_performance_is_feasible_to_use" {{ $workOrderProcesess->calibration_performance_is_feasible_to_use == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="calibration_performance_is_feasible_to_use_1">
                                Feasible to Use
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="radio" id="calibration_performance_is_feasible_to_use_0" class="form-check-input" value="0" name="calibration_performance_is_feasible_to_use" {{ $workOrderProcesess->calibration_performance_is_feasible_to_use == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="calibration_performance_is_feasible_to_use_0">
                                Not Worth to Use
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="calibration_performance_calibration_price" class="control-label">Calibration Price</label>
                        <input type="text" name="calibration_performance_calibration_price" class="form-control" id="calibration_performance_calibration_price" value="{{ old('calibration_performance_calibration_price') ? old('calibration_performance_calibration_price') : $workOrderProcesess->calibration_performance_calibration_price }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
