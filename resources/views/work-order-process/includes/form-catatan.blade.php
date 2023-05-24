<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Note</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <textarea name="electrical_safety_note" {{ $readonly ? 'disabled' : '' }}
                            class="form-control @error('electrical_safety_note') is-invalid @enderror" placeholder="Note" style="height: 80px"
                            id="electrical_safety_note" cols="30" rows="10">{{ old('electrical_safety_note') ? old('electrical_safety_note') : $workOrderProcesess->electrical_safety_note }}</textarea>

                        @error('electrical_safety_note')
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
