<td>
    {{-- @can('employee view')
        <a href="{{ route('employees.show', $model->id) }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>
    @endcan --}}

    @can('employee edit')
        <a href="{{ route('employees.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('employee delete')
        <form action="{{ route('employees.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
