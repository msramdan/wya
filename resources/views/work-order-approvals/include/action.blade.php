<td>
    <div class="modal fade" id="modalDetail{{ $model->id }}" tabindex="-1" aria-labelledby="modalDetail{{ $model->id }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetail{{ $model->id }}Label">Detail Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>WO Number</th>
                            <td>{{ $model->wo_number }}</td>
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
                            <th>Schedule Date</th>
                            <td>{{ date('Y-m-d', strtotime($model->schedule_date ? $model->schedule_date : $model->start_date)) }}</td>
                        </tr>
                        <tr>
                            <th>Requested Start Date</th>
                            <td>{{ $model->start_date }}</td>
                        </tr>
                        <tr>
                            <th>Requested End Date</th>
                            <td>{{ $model->end_date }}</td>
                        </tr>
                        <tr>
                            <th>Schedule WO</th>
                            <td>{{ $model->schedule_wo }}</td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{ $model->note }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $model->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <th>Approval Users</th>
                            <td>
                                <ul>
                                    @foreach ($arrApprovalUsers as $approvalUser)
                                        @php
                                            switch ($approvalUser->status) {
                                                case 'pending':
                                                    $rowStatus = 'primary';
                                                    break;
                                                case 'rejected':
                                                    $rowStatus = 'danger';
                                                    break;
                                                case 'accepted':
                                                    $rowStatus = 'success';
                                                    break;
                                            }
                                        @endphp

                                        <li style="white-space: nowrap">{{ $approvalUser->user_name }}: <span class="badge bg-{{ $rowStatus }}">{{ $approvalUser->status }}</span></li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Status WO</th>
                            <td>
                                @php
                                    switch ($model->status_wo) {
                                        case 'pending':
                                            $rowStatus = 'primary';
                                            break;
                                        case 'rejected':
                                            $rowStatus = 'danger';
                                            break;
                                        case 'accepted':
                                            $rowStatus = 'success';
                                            break;
                                        case 'on-going':
                                            $rowStatus = 'success';
                                            break;
                                        case 'finished':
                                            $rowStatus = 'success';
                                            break;
                                    }
                                @endphp
                                <span class="badge bg-{{ $rowStatus }}">{{ in_array($model->status_wo, ['accepted', 'on-going', 'finished']) ? 'accepted' : $model->status_wo }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-sm btn btn-secondary" data-bs-dismiss="modal"><i class="mdi mdi-arrow-up"></i> Close</button>
                    @can('work order approval')
                        @if ($displayAction)
                            <form action="{{ route('work-order-approvals.update', $model->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to reject this record?')">
                                @csrf
                                @method('put')
                                <input type="hidden" name="status" value="rejected">

                                <button class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-close"></i> Reject
                                </button>
                            </form>
                            <form action="{{ route('work-order-approvals.update', $model->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to accept this record?')">
                                @csrf
                                @method('put')
                                <input type="hidden" name="status" value="accepted">

                                <button class="btn btn-success btn-sm">
                                    <i class="mdi mdi-check"></i> Accept
                                </button>
                            </form>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <button type="button" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $model->id }}" class="btn btn-sm btn-primary"><i class="mdi mdi-format-float-center"></i></button>
</td>