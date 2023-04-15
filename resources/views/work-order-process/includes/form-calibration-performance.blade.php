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
                        @if (old('calibration_performance_tool_performance_check'))
                            @foreach (old('calibration_performance_tool_performance_check') as $indexOld => $justCounter)
                                <tr data-index="{{ $indexOld }}">
                                    <td>
                                        <button type="button" class="btn btn-sm btn-{{ $indexOld == 0 ? 'primary' : 'danger' }}" @if ($indexOld == 0) onclick="addRowPerformanceCalibration(this.parentElement.parentElement)"
                                        @else
                                        onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $indexOld == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Tool Performance Check" name="calibration_performance_tool_performance_check[{{ $indexOld }}]" class="form-control @error('calibration_performance_tool_performance_check.' . $indexOld) is-invalid @enderror" id="tool_performance_check_{{ $indexOld }}" value="{{ old('calibration_performance_tool_performance_check')[$indexOld] }}">

                                            @error('calibration_performance_tool_performance_check.' . $indexOld)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Setting" name="calibration_performance_setting[{{ $indexOld }}]" class="form-control @error('calibration_performance_setting.' . $indexOld) is-invalid @enderror" id="setting_{{ $indexOld }}" value="{{ old('calibration_performance_setting')[$indexOld] }}">

                                            @error('calibration_performance_setting.' . $indexOld)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Measurable" name="calibration_performance_measurable[{{ $indexOld }}]" class="form-control @error('calibration_performance_measurable.' . $indexOld) is-invalid @enderror" id="measurable_{{ $indexOld }}" value="{{ old('calibration_performance_measurable')[$indexOld] }}">

                                            @error('calibration_performance_measurable.' . $indexOld)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Reference Value" name="calibration_performance_reference_value[{{ $indexOld }}]" class="form-control @error('calibration_performance_reference_value.' . $indexOld) is-invalid @enderror" id="reference_value_{{ $indexOld }}" value="{{ old('calibration_performance_reference_value')[$indexOld] }}">

                                            @error('calibration_performance_reference_value.' . $indexOld)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[{{ $indexOld }}]" class="form-check-input @error('calibration_performance_is_good.' . $indexOld) is-invalid @enderror" value="1" {{ isset(old('calibration_performance_is_good')[$indexOld]) ? (old('calibration_performance_is_good')[$indexOld] == 1 ? 'checked' : '') : '' }}>
                                        </div>
                                        @error('calibration_performance_is_good.' . $indexOld)
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[{{ $indexOld }}]" class="form-check-input @error('calibration_performance_is_good.' . $indexOld) is-invalid @enderror" value="0" {{ isset(old('calibration_performance_is_good')[$indexOld]) ? (old('calibration_performance_is_good')[$indexOld] == 0 ? 'checked' : '') : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($workOrderProcesess->calibrationPerformance as $index => $calibrationPerformance)
                                <tr data-index="{{ $index }}">
                                    <td>
                                        <button type="button" {{ $readonly ? 'disabled' : '' }} class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowPerformanceCalibration(this.parentElement.parentElement)"
                                    @else
                                    onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Tool Performance Check" name="calibration_performance_tool_performance_check[{{ $index }}]" class="form-control" id="tool_performance_check_{{ $index }}" value="{{ $calibrationPerformance->tool_performance_check }}" {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Setting" name="calibration_performance_setting[{{ $index }}]" class="form-control" id="setting_{{ $index }}" value="{{ $calibrationPerformance->setting }}" {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Measurable" name="calibration_performance_measurable[{{ $index }}]" class="form-control" id="measurable_{{ $index }}" value="{{ $calibrationPerformance->measurable }}" {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Reference Value" name="calibration_performance_reference_value[{{ $index }}]" class="form-control" id="reference_value_{{ $index }}" value="{{ $calibrationPerformance->reference_value }}" {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[{{ $index }}]" class="form-check" value="1" {{ $calibrationPerformance->is_good == '1' ? 'checked' : '' }} {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[{{ $index }}]" class="form-check" value="0" {{ $calibrationPerformance->is_good == '0' ? 'checked' : '' }} {{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-index="0">
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" {{ $readonly ? 'disabled' : '' }} onclick="addRowPerformanceCalibration(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Tool Performance Check" name="calibration_performance_tool_performance_check[0]" class="form-control" id="tool_performance_check_0"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Setting" name="calibration_performance_setting[0]" class="form-control" id="setting_0"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Measurable" name="calibration_performance_measurable[0]" class="form-control" id="measurable_0"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" placeholder="Reference Value" name="calibration_performance_reference_value[0]" class="form-control" id="reference_value_0"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[0]" class="form-check" value="1"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="calibration_performance_is_good[0]" class="form-check" value="0"{{ $readonly ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                <hr>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label">Performance Check Results</label>
                        <div class="form-check">
                            <input {{ $readonly ? 'disabled' : '' }} type="radio" id="calibration_performance_is_feasible_to_use_1" class="form-check-input @error('calibration_performance_is_feasible_to_use') is-invalid @enderror" value="1" name="calibration_performance_is_feasible_to_use" @if (old('calibration_performance_is_feasible_to_use')) {{ old('calibration_performance_is_feasible_to_use') == 1 ? 'checked' : '' }}
                            @else
                                {{ $workOrderProcesess->calibration_performance_is_feasible_to_use == 1 ? 'checked' : '' }} @endif>
                            <label class="form-check-label" for="calibration_performance_is_feasible_to_use_1">
                                Laik Pakai
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input {{ $readonly ? 'disabled' : '' }} type="radio" id="calibration_performance_is_feasible_to_use_0" class="form-check-input @error('calibration_performance_is_feasible_to_use') is-invalid @enderror" value="0" name="calibration_performance_is_feasible_to_use" @if (old('calibration_performance_is_feasible_to_use')) {{ old('calibration_performance_is_feasible_to_use') == 0 ? 'checked' : '' }}
                            @else
                                {{ $workOrderProcesess->calibration_performance_is_feasible_to_use == 0 ? 'checked' : '' }} @endif>
                            <label class="form-check-label" for="calibration_performance_is_feasible_to_use_0">
                                Tidak Laik Pakai
                            </label>
                        </div>
                        @error('calibration_performance_is_feasible_to_use')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="calibration_performance_calibration_price" class="control-label">Calibration Price</label>
                        <input type="number" {{ $readonly ? 'disabled' : '' }} step="any" name="calibration_performance_calibration_price" class="form-control @error('calibration_performance_calibration_price') is-invalid @enderror" id="calibration_performance_calibration_price" value="{{ old('calibration_performance_calibration_price') ? old('calibration_performance_calibration_price') : $workOrderProcesess->calibration_performance_calibration_price }}">

                        @error('calibration_performance_calibration_price')
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
