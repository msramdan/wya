<td>
    @can('work order approval')
        <form action="{{ route('work-order-approvals.update', $model->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to accept this record?')">
            @csrf
            @method('put')
            <input type="hidden" name="status" value="accepted">

            <button class="btn btn-success btn-sm">
                <i class="mdi mdi-check"></i>
            </button>
        </form>
    @endcan

    @can('work order approval')
        <form action="{{ route('work-order-approvals.update', $model->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to reject this record?')">
            @csrf
            @method('put')
            <input type="hidden" name="status" value="rejected">

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-close"></i>
            </button>
        </form>
    @endcan
</td>
