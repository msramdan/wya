<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Physical Check</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Physical Check</th>
                                <th class="text-center">Good</th>
                                <th class="text-center">Minor Damage</th>
                                <th class="text-center">Major Damage</th>
                                <th class="text-center">Clean</th>
                                <th class="text-center">Dirty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (old('physical_check'))
                                @foreach (old('physical_check') as $indexOld => $justCounter)
                                    <tr data-index="{{ $indexOld }}">
                                        <td>
                                            <button type="button" class="btn btn-sm btn-{{ $indexOld == 0 ? 'primary' : 'danger' }}" @if ($indexOld == 0) onclick="addRowPhysicalCheck(this.parentElement.parentElement)"
                                            @else
                                            onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $indexOld == 0 ? 'plus' : 'trash' }}"></i></button>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input autocomplete="off" type="text" placeholder="Physical Check" name="physical_check[{{ $indexOld }}]" class="form-control @error('physical_check.' . $indexOld) is-invalid @enderror" value="{{ old('physical_check')[$indexOld] }}">

                                                @error('physical_check.' . $indexOld)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="physical_health[{{ $indexOld }}]" class="form-check" value="good" {{ isset(old('physical_health')[$indexOld]) ? (old('physical_health')[$indexOld] == 'good' ? 'checked' : '') : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="physical_health[{{ $indexOld }}]" class="form-check" value="minor damage" {{ isset(old('physical_health')[$indexOld]) ? (old('physical_health')[$indexOld] == 'minor damage' ? 'checked' : '') : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="physical_health[{{ $indexOld }}]" class="form-check" value="major damage" {{ isset(old('physical_health')[$indexOld]) ? (old('physical_health')[$indexOld] == 'major damage' ? 'checked' : '') : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="physical_cleanliness[{{ $indexOld }}]" class="form-check" value="clean" {{ isset(old('physical_cleanliness')[$indexOld]) ? (old('physical_cleanliness')[$indexOld] == 'clean' ? 'checked' : '') : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="physical_cleanliness[{{ $indexOld }}]" class="form-check" value="dirty" {{ isset(old('physical_cleanliness')[$indexOld]) ? (old('physical_cleanliness')[$indexOld] == 'dirty' ? 'checked' : '') : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @forelse ($workOrderProcesess->physicalChecks as $index => $physicalCheck)
                                    <tr data-index="{{ $index }}">
                                        <td>
                                            <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowPhysicalCheck(this.parentElement.parentElement)"
                                            @else
                                            onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input {{ $readonly ? 'disabled' : '' }} autocomplete="off" type="text" placeholder="Physical Check" name="physical_check[{{ $index }}]" class="form-control" value="{{ $physicalCheck->physical_check }}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[{{ $index }}]" class="form-check" value="good" {{ $physicalCheck->physical_health == 'good' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[{{ $index }}]" class="form-check" value="minor damage" {{ $physicalCheck->physical_health == 'minor damage' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[{{ $index }}]" class="form-check" value="major damage" {{ $physicalCheck->physical_health == 'major damage' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_cleanliness[{{ $index }}]" class="form-check" value="clean" {{ $physicalCheck->physical_cleanliness == 'clean' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_cleanliness[{{ $index }}]" class="form-check" value="dirty" {{ $physicalCheck->physical_cleanliness == 'dirty' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr data-index="0">
                                        <td>
                                            <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-primary" onclick="addRowPhysicalCheck(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input {{ $readonly ? 'disabled' : '' }} autocomplete="off" type="text" placeholder="Physical Check" name="physical_check[0]" class="form-control">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[0]" class="form-check" value="good">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[0]" class="form-check" value="minor damage">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_health[0]" class="form-check" value="major damage">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_cleanliness[0]" class="form-check" value="clean">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input {{ $readonly ? 'disabled' : '' }} type="radio" name="physical_cleanliness[0]" class="form-check" value="dirty">
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
