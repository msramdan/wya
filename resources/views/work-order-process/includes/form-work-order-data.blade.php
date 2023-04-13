@php
    use App\Models\User;
@endphp
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Work Order Data</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="type_wo">WO Type</label>
                        <input type="text" name="type_wo" id="type_wo" class="form-control" value="{{ $workOrder->type_wo }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="executor">Executor</label>
                        <select name="executor" class="form-control js-example-basic-multiple" id="executor" {{ $readonly ? 'disabled' : '' }}>
                            <option value="" @if (!old('executor')) {{ !$workOrderProcesess->executor ? 'selected' : '' }} @endif disabled>-- Choose Executor --</option>

                            <option value="vendor_or_supplier" @if (old('executor')) {{ old('executor') == 'vendor_or_supplier' ? 'selected' : '' }}
                            @else
                            {{ $workOrderProcesess->executor == 'vendor_or_supplier' ? 'selected' : '' }} @endif>Vendor/Supplier</option>
                            <option value="technician" @if (old('executor')) {{ old('executor') == 'technician' ? 'selected' : '' }}
                            @else
                            {{ $workOrderProcesess->executor == 'technician' ? 'selected' : '' }} @endif>Teknisi</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 {{ old('executor') ? (old('executor') == 'technician' ? '' : 'd-none') : ($workOrderProcesess->executor == 'technician' ? '' : 'd-none') }}">
                        <label for="work_executor_technician_id">Technician</label>
                        <select name="work_executor_technician_id" class="form-control js-example-basic-multiple" id="work_executor_technician_id" {{ $readonly ? 'disabled' : '' }}>
                            <option value="" selected disabled>-- Choose Work Executor --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @if (old('work_executor_technician_id')) {{ old('work_executor_technician_id') == $vendor->id ? 'selected' : '' }}
                                @else
                                    {{ $workOrderProcesess->work_executor_technician_id == $employee->id ? 'selected' : '' }} @endif>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 {{ old('executor') ? (old('executor') == 'vendor_or_supplier' ? '' : 'd-none') : ($workOrderProcesess->executor == 'vendor_or_supplier' ? '' : 'd-none') }}">
                        <label for="work_executor_vendor_id">Vendor</label>
                        <select name="work_executor_vendor_id" class="form-control js-example-basic-multiple" id="work_executor_vendor_id" {{ $readonly ? 'disabled' : '' }}>
                            <option value="" {{ !$workOrderProcesess->work_executor_vendor_id ? 'selected' : '' }} disabled>-- Choose Vendor --</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if (old('work_executor_vendor_id')) {{ old('work_executor_vendor_id') == $vendor->id ? 'selected' : '' }}
                                    @else
                                        {{ $workOrderProcesess->work_executor_vendor_id == $vendor->id ? 'selected' : '' }} @endif>{{ $vendor->name_vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="proposed_by">Proposed By</label>
                        <input type="text" name="proposed_by" id="proposed_by" class="form-control" value="{{ $workOrder->createdBy->name }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="proposed_date">Proposed Date</label>
                        <input type="text" name="proposed_date" id="proposed_date" class="form-control" value="{{ $workOrder->created_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="date_proposed_approved">Date Proposed Approved</label>
                        <input type="text" name="date_proposed_approved" id="date_proposed_approved" class="form-control" value="{{ $workOrder->approved_at ? date('Y-m-d H:i:s', strtotime($workOrder->approved_at)) : '' }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="propose_approved_by">Proposes Approved By</label>
                        <ul>
                            @forelse (json_decode($workOrder->approval_users_id, true) as $approvalUser)
                                <li>
                                    <input type="text" name="propose_approved_by[]" value="{{ User::find($approvalUser['user_id'])->name }}" class="form-control" readonly>
                                </li>
                            @empty
                                <li>
                                    <input type="text" name="propose_approved_by[]" value="-" class="form-control" readonly>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="form-group mb-3">
                        <label for="work_date">Work Date</label>
                        <input type="date" name="work_date" id="work_date" class="form-control @error('work_date') is-invalid @enderror" value="{{ old('work_date') ? old('work_date') : ($workOrderProcesess->work_date ? $workOrderProcesess->work_date : date('Y-m-d')) }}" {{ $readonly ? 'disabled' : '' }}>

                        @error('work_date')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
