<td>
    @can('cat view')
    <a href="{{ route('cats.show', $model->id) }}" class="btn btn-info btn-md">
        <i class="fa fa-eye"></i>
    </a>
    @endcan

    @can('cat edit')
        <a href="{{ route('cats.edit', $model->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('cat delete')
        <form action="{{ route('cats.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
