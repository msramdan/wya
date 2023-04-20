<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3>Equipment</h3>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="equipment">Equipment</label>
                <input type="text" name="equipment" id="equipment" value="{{ $workOrder->equipment->serial_number }} | {{ $workOrder->equipment->manufacturer }} | {{ $workOrder->equipment->type }}" class="form-control" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="{{ $workOrder->equipment->equipment_category->category_name }}" class="form-control" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="manufacturer">Manufacturer</label>
                <input type="text" name="manufacturer" id="manufacturer" value="{{ $workOrder->equipment->manufacturer }}" readonly class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="serial_number">Serial Number</label>
                <input type="text" name="serial_number" id="serial_number" readonly value="{{ $workOrder->equipment->serial_number }}" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="{{ $workOrder->equipment->type }}" readonly class="form-control">
            </div>
        </div>
    </div>
</div>
