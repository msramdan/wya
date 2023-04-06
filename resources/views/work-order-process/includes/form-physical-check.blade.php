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
                            @forelse ($workOrderProcesess->physicalChecks as $index => $physicalCheck)
                                <tr data-index="{{ $index }}">
                                    <td>
                                        <button class="btn btn-sm btn-primary" @if ($index == 0) onclick="addRowPhysicalCheck(this.parentElement.parentElement)"
                                    @else
                                        onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" placeholder="Physical Check" name="physical_check[{{ $index }}]" class="form-control">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[{{ $index }}]" class="form-check" value="good">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[{{ $index }}]" class="form-check" value="minor damage">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[{{ $index }}]" class="form-check" value="major damage">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_cleanliness[{{ $index }}]" class="form-check" value="clean">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_cleanliness[{{ $index }}]" class="form-check" value="dirty">
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-index="0">
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="addRowPhysicalCheck(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" placeholder="Physical Check" name="physical_check[0]" class="form-control">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[0]" class="form-check" value="good">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[0]" class="form-check" value="minor damage">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_health[0]" class="form-check" value="major damage">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_cleanliness[0]" class="form-check" value="clean">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input type="radio" name="physical_cleanliness[0]" class="form-check" value="dirty">
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
</div>
