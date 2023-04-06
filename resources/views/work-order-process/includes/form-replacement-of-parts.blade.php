<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Replacement of Parts/Consumables</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Part / Consumable</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($workOrderProcesess->replacementOfParts as $replacementOfPart)
                            <tr data-index="{{ $index }}">
                                <td>
                                    <button class="btn btn-sm btn-primary" @if ($index == 0) onclick="addRowReplacementOfPart(this.parentElement.parentElement)"
                                @else
                                onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select name="sparepart_id[{{ $index }}]" class="form-control" id="sparepart_id_{{ $index }}">
                                            <option value="">--Choose Sparepart--</option>
                                            @foreach ($spareparts as $sparepart)
                                                <option value="{{ $sparepart->id }}">{{ $sparepart->sparepart_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="price[{{ $index }}]" placeholder="Price" class="form-control text-right" id="price_{{ $index }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="stock[{{ $index }}]" placeholder="Stock" class="form-control text-right" id="stock_{{ $index }}" readonly="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="amount[{{ $index }}]" placeholder="Amount" class="form-control text-right" id="amount_{{ $index }}">
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-index="0">
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="addRowReplacementOfPart(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select name="sparepart_id[0]" class="form-control" id="sparepart_id_0" onchange="getSparepartInfo(0)">
                                            <option value="">--Choose Sparepart--</option>
                                            @foreach ($spareparts as $sparepart)
                                                <option value="{{ $sparepart->id }}">{{ $sparepart->sparepart_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="price[0]" placeholder="Price" class="form-control text-right" id="price0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="stock[0]" placeholder="Stock" class="form-control text-right" id="stock0" readonly="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="amount[0]" placeholder="Amount" class="form-control text-right" id="amount0">
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="replacement_of_part_service_price" class="control-label">Service Price</label>
                        <input type="number" name="replacement_of_part_service_price" class="form-control" placeholder="Service Price" id="replacement_of_part_service_price" value="{{ old('replacement_of_part_service_price') ? old('replacement_of_part_service_price') : $workOrderProcesess->replacement_of_part_service_price }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
