<td>
    @can('loan view')
        <a href="{{ route('loans.show', $model->id) }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>
    @endcan
    @can('loan edit')
        <a href="{{ route('loans.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('loan delete')
        <form action="{{ route('loans.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
