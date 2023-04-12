<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Status</h3>
        </div>
        <div class="card-body">
            <div class="card card-{{ $workOrderProcesess->status == 'on-progress' ? 'primary' : ($workOrderProcesess->status == 'ready-to-start' ? 'dark' : 'success') }}">
                <div class="card-header">
                    <h3 class="card-title">Status : {{ str_replace('-', ' ', $workOrderProcesess->status) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
