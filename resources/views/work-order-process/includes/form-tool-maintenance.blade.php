<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Tool Maintenance</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table" id="table-fungsi">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Information</th>
                            <th class="text-center">Yes</th>
                            <th class="text-center">No</th>
                            <th class="text-center">NA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (old('tool_maintenance_information'))
                            @foreach (old('tool_maintenance_information') as $oldIndex => $justCounter)
                                <tr data-index="{{ $oldIndex }}">
                                    <td>
                                        <button type="button" class="btn btn-sm btn-{{ $oldIndex == 0 ? 'primary' : 'danger' }}" @if ($oldIndex == 0) onclick="addRowToolMaintenance(this.parentElement.parentElement)"
                                            @else
                                            onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $oldIndex == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" name="tool_maintenance_information[{{ $oldIndex }}]" class="form-control @error('tool_maintenance_information.' . $oldIndex) is-invalid @enderror" placeholder="Information" id="tool_maintenance_information{{ $oldIndex }}" value="{{ old('tool_maintenance_information')[$oldIndex] }}">

                                            @error('tool_maintenance_information.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="tool_maintenance_status[{{ $oldIndex }}]" class="form-check" value="Yes" {{ isset(old('tool_maintenance_status')[$oldIndex]) ? (old('tool_maintenance_status')[$oldIndex] == 'Yes' ? 'checked' : '') : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="tool_maintenance_status[{{ $oldIndex }}]" class="form-check" value="No" {{ isset(old('tool_maintenance_status')[$oldIndex]) ? (old('tool_maintenance_status')[$oldIndex] == 'No' ? 'checked' : '') : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="tool_maintenance_status[{{ $oldIndex }}]" class="form-check" value="NA" {{ isset(old('tool_maintenance_status')[$oldIndex]) ? (old('tool_maintenance_status')[$oldIndex] == 'NA' ? 'checked' : '') : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($workOrderProcesess->toolMaintenances as $index => $item)
                                <tr data-index="{{ $index }}">
                                    <td>
                                        <button type="button" {{ $readonly ? 'disabled' : '' }} class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowToolMaintenance(this.parentElement.parentElement)"
                                @else
                                onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" {{ $readonly ? 'disabled' : '' }} autocomplete="off" name="tool_maintenance_information[{{ $index }}]" class="form-control" placeholder="Information" id="tool_maintenance_information{{ $index }}" value="{{ $item->information }}">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[{{ $index }}]" class="form-check" value="Yes" {{ $item->status == 'Yes' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[{{ $index }}]" class="form-check" value="No" {{ $item->status == 'No' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[{{ $index }}]" class="form-check" value="NA" {{ $item->status == 'NA' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-index="0">
                                    <td>
                                        <button type="button" {{ $readonly ? 'disabled' : '' }} class="btn btn-sm btn-primary" onclick="addRowToolMaintenance(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" {{ $readonly ? 'disabled' : '' }} autocomplete="off" name="tool_maintenance_information[0]" class="form-control" placeholder="Information" id="tool_maintenance_information_0">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[0]" class="form-check" value="Yes">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[0]" class="form-check" value="No">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" {{ $readonly ? 'disabled' : '' }} name="tool_maintenance_status[0]" class="form-check" value="NA">
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