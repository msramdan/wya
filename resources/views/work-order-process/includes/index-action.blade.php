<td>
    <a href="{{ route('work-order-processes.index') }}/{{ $model->id }}" class="btn btn-sm btn-success"><i class="mdi mdi-table-edit"></i></a>

    <div class="modal fade" id="modalProcesses{{ $model->id }}" tabindex="-1" aria-labelledby="modalProcesses{{ $model->id }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProcesses{{ $model->id }}Label">Detail Work Order Processes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>WO Number</th>
                            <td>{{ $model->wo_number }}</td>
                        </tr>
                        <tr>
                            <th>Filled Date</th>
                            <td>{{ date('Y-m-d', strtotime($model->filed_date)) }}</td>
                        </tr>
                        <tr>
                            <th>Equipment</th>
                            <td>{{ $model->equipment->barcode }}</td>
                        </tr>
                        <tr>
                            <th>Type WO</th>
                            <td>{{ $model->type_wo }}</td>
                        </tr>
                        <tr>
                            <th>Category WO</th>
                            <td>{{ $model->category_wo }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $model->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Finished Processes</th>
                            <td>{{ $model->countWoProcess('finished') . '/' . $model->countWoProcess() }}</td>
                        </tr>
                        <tr>
                            <th>Status WO</th>
                            <td>
                                @switch($model->status_wo)
                                    @case('accepted')
                                        <span class="badge bg-primary">ready for process</span>
                                    @break

                                    @case('on-going')
                                        <span class="badge bg-info">on-going</span>
                                    @break

                                    @case('finished')
                                        <span class="badge bg-success">finished</span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-sm btn btn-secondary" data-bs-dismiss="modal"><i class="mdi mdi-arrow-up"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" data-bs-toggle="modal" data-bs-target="#modalProcesses{{ $model->id }}" class="btn btn-sm btn-primary"><i class="mdi mdi-format-float-center"></i></button>
</td>
