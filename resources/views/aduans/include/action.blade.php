<td>
    @can('aduan view')
        <a href="{{ route('aduans.show', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>
    @endcan
    @can('aduan delete')
        <form action="{{ route('aduans.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
