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
                        @forelse ($workOrderProcesess->toolMaintenances as $index => $item)
                            <tr data-index="{{ $index }}">
                                <td>
                                    <button class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowToolMaintenance(this.parentElement.parentElement)"
                                @else
                                onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="information[{{ $index }}]" class="form-control" placeholder="Information" id="information_{{ $index }}">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[{{ $index }}]" class="form-check" value="Yes">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[{{ $index }}]" class="form-check" value="No">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[{{ $index }}]" class="form-check" value="NA">
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-index="0">
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="addRowToolMaintenance(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="information[0]" class="form-control" placeholder="Information" id="information_0">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[0]" class="form-check" value="Yes">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[0]" class="form-check" value="No">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="radio" name="status[0]" class="form-check" value="NA">
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
