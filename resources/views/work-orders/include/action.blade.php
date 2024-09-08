<td>
    @if ($displayAction)
        @can('work order edit')
            <a href="{{ route('work-orders.edit', $model->id) }}" class="btn btn-success btn-sm">
                <i class="mdi mdi-pencil"></i>
            </a>
        @endcan

        @can('work order delete')
            <form action="{{ route('work-orders.destroy', $model->id) }}" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                @csrf
                @method('delete')

                <button class="btn btn-danger btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            </form>
        @endcan
    @endif

    <div class="modal fade" id="modalSubmission{{ $model->id }}" tabindex="-1" aria-labelledby="modalSubmission{{ $model->id }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSubmission{{ $model->id }}Label">{{ trans('work-order/submission/index.detail_work_order') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ trans('work-order/submission/index.wo_number') }}</th>
                            <td>{{ $model->wo_number }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.filed_date') }}</th>
                            <td>{{ date('Y-m-d', strtotime($model->filed_date)) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.equipment') }}</th>
                            <td>{{ $model->equipment->barcode }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.type') }}</th>
                            <td>{{ $model->type_wo == 'Training' ? 'Training/Uji fungsi' : $model->type_wo }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.category') }}</th>
                            <td>{{ $model->category_wo }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.created_by') }}</th>
                            <td>{{ $model->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('work-order/submission/index.approval_user') }}</th>
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
                </div>
            </div>
        </div>
    </div>
    <button type="button" data-bs-toggle="modal" data-bs-target="#modalSubmission{{ $model->id }}" class="btn btn-sm btn-primary"><i class="mdi mdi-format-float-center"></i></button>
</td>
