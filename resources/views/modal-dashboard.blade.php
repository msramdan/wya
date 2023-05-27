<!-- Modal -->
<div class="modal fade" id="total_work_order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Work Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('modal-dashboard.wo_modal')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_euipment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Equipment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('modal-dashboard.eq_modal')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('modal-dashboard.em_modal')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_vendor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Vendor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('modal-dashboard.vendor_modal')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_wo_by_status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Wo By Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="data-table-work-order-by-status">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="white-space: nowrap">{{ __('Hospital') }}</th>
                                <th style="white-space: nowrap">{{ __('Wo Number') }}</th>
                                <th style="white-space: nowrap">{{ __('Filed Date') }}</th>
                                <th style="white-space: nowrap">{{ __('Equipment') }}</th>
                                <th style="white-space: nowrap">{{ __('Type') }}</th>
                                <th style="white-space: nowrap">{{ __('Category') }}</th>
                                <th style="white-space: nowrap">{{ __('Created By') }}</th>
                                <th style="white-space: nowrap">{{ __('Approval Users') }}</th>
                                <th style="white-space: nowrap">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_wo_by_category" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Wo By Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="data-table-work-order-by-category">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="white-space: nowrap">{{ __('Hospital') }}</th>
                                <th style="white-space: nowrap">{{ __('Wo Number') }}</th>
                                <th style="white-space: nowrap">{{ __('Filed Date') }}</th>
                                <th style="white-space: nowrap">{{ __('Equipment') }}</th>
                                <th style="white-space: nowrap">{{ __('Type') }}</th>
                                <th style="white-space: nowrap">{{ __('Category') }}</th>
                                <th style="white-space: nowrap">{{ __('Created By') }}</th>
                                <th style="white-space: nowrap">{{ __('Approval Users') }}</th>
                                <th style="white-space: nowrap">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="total_wo_by_type" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Total Wo By Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="data-table-work-order-by-type">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="white-space: nowrap">{{ __('Hospital') }}</th>
                                <th style="white-space: nowrap">{{ __('Wo Number') }}</th>
                                <th style="white-space: nowrap">{{ __('Filed Date') }}</th>
                                <th style="white-space: nowrap">{{ __('Equipment') }}</th>
                                <th style="white-space: nowrap">{{ __('Type') }}</th>
                                <th style="white-space: nowrap">{{ __('Category') }}</th>
                                <th style="white-space: nowrap">{{ __('Created By') }}</th>
                                <th style="white-space: nowrap">{{ __('Approval Users') }}</th>
                                <th style="white-space: nowrap">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
