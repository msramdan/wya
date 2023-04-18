<div class="col-12" id="col-replacement-of-parts">
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
                            <th style="width: 100px">Unit</th>
                            <th style="width: 150zpx">Qty</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (old('replacement_sparepart_id'))
                            @foreach (old('replacement_sparepart_id') as $oldIndex => $replacementSparepartId)
                                <tr data-index="{{ $oldIndex }}">
                                    <td>
                                        <button type="button" class="btn btn-sm btn-{{ $oldIndex == 0 ? 'primary' : 'danger' }}" @if ($oldIndex == 0) onclick="addRowReplacementOfPart(this.parentElement.parentElement)"
                            @else
                            onclick="removeWoProcWo(this)" @endif><i class="fa fa-{{ $oldIndex == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select {{ isset(old('replacement_id')[$oldIndex]) ? 'readonly' : '' }} onchange="loadStockSparepart(this)" name="replacement_sparepart_id[{{ $oldIndex }}]" class="form-control" id="replacement_sparepart_id_{{ $oldIndex }}">
                                                <option value="">--Choose Sparepart--</option>
                                                @foreach ($spareparts as $sparepart)
                                                    <option data-unit="{{ $sparepart->unit_item->code_unit }}" data-price="{{ $sparepart->estimated_price }}" data-stock="{{ $sparepart->stock }}" value="{{ $sparepart->id }}" {{ old('replacement_sparepart_id')[$oldIndex] == $sparepart->id ? 'selected' : '' }}>{{ $sparepart->sparepart_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('replacement_sparepart_id.' . $oldIndex)
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" step="any" name="replacement_price[{{ $oldIndex }}]" placeholder="Price" class="form-control text-right @error('replacement_price.' . $oldIndex) is-invalid @enderror" id="replacement_price_{{ $oldIndex }}" readonly value="{{ old('replacement_price')[$oldIndex] }}">

                                            @error('replacement_price.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" step="any" name="replacement_stock[{{ $oldIndex }}]" placeholder="Stock" class="form-control text-right @error('replacement_stock.' . $oldIndex) is-invalid @enderror" id="replacement_stock_{{ $oldIndex }}" readonly value="{{ old('replacement_stock')[$oldIndex] }}">

                                            @error('replacement_stock.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input autocomplete="off" type="text" name="unit_stock[{{ $oldIndex }}]" placeholder="Unit" class="form-control text-right" id="unit_stock{{ $oldIndex }}" readonly="" value="{{ old('unit_stock')[$oldIndex] }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" {{ isset(old('replacement_id')[$oldIndex]) ? 'readonly' : '' }} onkeyup="generateAmountReplacementOfPart(this)" name="replacement_qty[{{ $oldIndex }}]" placeholder="Qty" class="form-control text-right @error('replacement_qty.' . $oldIndex) is-invalid @enderror" id="replacement_qty_{{ $oldIndex }}" value="{{ old('replacement_qty')[$oldIndex] }}">

                                            @error('replacement_qty.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" step="any" name="replacement_amount[{{ $oldIndex }}]" placeholder="Amount" class="form-control text-right @error('replacement_amount.' . $oldIndex) is-invalid @enderror" id="replacement_amount_{{ $oldIndex }}" value="{{ old('replacement_amount')[$oldIndex] }}" readonly>

                                            @error('replacement_amount.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($workOrderProcesess->replacementOfParts as $index => $replacementOfPart)
                                <input type="hidden" name="replacement_id[{{ $index }}]" value="{{ $replacementOfPart->id }}">
                                <tr data-index="{{ $index }}">
                                    <td>
                                        <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowReplacementOfPart(this.parentElement.parentElement)"
                                @else
                                onclick="removeWoProcWo(this)" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select readonly {{ $readonly ? 'disabled' : '' }} onchange="loadStockSparepart(this)" name="replacement_sparepart_id[{{ $index }}]" class="form-control" id="replacement_sparepart_id_{{ $index }}">
                                                <option value="">--Choose Sparepart--</option>
                                                @php
                                                    $selectedSparepart = null;
                                                @endphp
                                                @foreach ($spareparts as $sparepart)
                                                    @if ($sparepart->id == $replacementOfPart->sparepart_id)
                                                        @php
                                                            $selectedSparepart = $sparepart;
                                                        @endphp
                                                    @endif

                                                    <option data-unit="{{ $sparepart->unit_item->code_unit }}" data-price="{{ $sparepart->estimated_price }}" data-stock="{{ $sparepart->stock }}" value="{{ $sparepart->id }}" {{ $sparepart->id == $replacementOfPart->sparepart_id ? 'selected' : '' }}>{{ $sparepart->sparepart_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_price[{{ $index }}]" placeholder="Price" class="form-control text-right" id="replacement_price_{{ $index }}" readonly value="{{ $replacementOfPart->price }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_stock[{{ $index }}]" placeholder="Stock" class="form-control text-right" id="replacement_stock_{{ $index }}" readonly="" value="{{ $replacementOfPart->sparepart->stock }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input autocomplete="off" type="text" name="unit_stock[{{ $index }}]" placeholder="Unit" class="form-control text-right" id="unit_stock{{ $index }}" readonly="" value="{{ $replacementOfPart->sparepart->unit_item->code_unit }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input readonly {{ $readonly ? 'disabled' : '' }} type="number" onkeyup="generateAmountReplacementOfPart(this)" name="replacement_qty[{{ $index }}]" placeholder="Qty" class="form-control text-right" id="replacement_qty_{{ $index }}" value="{{ $replacementOfPart->qty }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_amount[{{ $index }}]" placeholder="Amount" class="form-control text-right" id="replacement_amount_{{ $index }}" value="{{ $replacementOfPart->amount }}" readonly>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-index="0">
                                    <td>
                                        <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-primary" onclick="addRowReplacementOfPart(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select {{ $readonly ? 'disabled' : '' }} onchange="loadStockSparepart(this)" name="replacement_sparepart_id[0]" class="form-control" id="replacement_sparepart_id_0" onchange="getSparepartInfo(0)">
                                                <option value="">--Choose Sparepart--</option>
                                                @foreach ($spareparts as $sparepart)
                                                    <option data-unit="{{ $sparepart->unit_item->code_unit }}" data-price="{{ $sparepart->estimated_price }}" data-stock="{{ $sparepart->stock }}" value="{{ $sparepart->id }}">{{ $sparepart->sparepart_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_price[0]" placeholder="Price" class="form-control text-right" id="replacement_price0" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_stock[0]" placeholder="Stock" class="form-control text-right" id="replacement_stock0" readonly="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input autocomplete="off" type="text" name="unit_stock[0]" placeholder="Unit" class="form-control text-right" id="unit_stock0" readonly="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="number" onkeyup="generateAmountReplacementOfPart(this)" name="replacement_qty[0]" placeholder="Amount" class="form-control text-right" id="replacement_qty0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="text" name="replacement_amount[0]" placeholder="Amount" class="form-control text-right" id="replacement_amount0" readonly>
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

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Service Price</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="replacement_of_part_service_price" class="control-label">Service Price</label>
                        <input type="number" {{ $readonly ? 'disabled' : '' }} step="any" name="replacement_of_part_service_price" class="form-control @error('replacement_of_part_service_price') is-invalid @enderror" placeholder="Service Price" id="replacement_of_part_service_price" value="{{ old('replacement_of_part_service_price') ? old('replacement_of_part_service_price') : $workOrderProcesess->replacement_of_part_service_price }}">

                        @error('replacement_of_part_service_price')
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
