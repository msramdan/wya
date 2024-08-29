<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Photo Kondisi Peralatan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table" id="table-dokumen">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo Name</th>
                            <th>Description</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (old('wo_photo_name'))
                            @foreach (old('wo_photo_name') as $oldIndex => $justCounter)
                                <tr data-index="{{ $oldIndex }}">
                                    <td>
                                        <button type="button" class="btn btn-sm btn-{{ $oldIndex == 0 ? 'primary' : 'danger' }}" @if ($oldIndex == 0) onclick="addRowWoPhoto(this.parentElement.parentElement)"
                                        @else
                                        onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $oldIndex == 0 ? 'plus' : 'trash' }}"></i></button>

                                        @if (isset(old('old_id')[$oldIndex]))
                                            <input type="hidden" name="old_id[{{ $oldIndex }}]" value="{{ old('old_id')[$oldIndex] }}" class="d-none">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input placeholder="Photo Name" type="text" name="wo_photo_name[{{ $oldIndex }}]" class="form-control @error('wo_photo_name.' . $oldIndex) is-invalid @enderror" id="photo_name_{{ $oldIndex }}" value="{{ old('wo_photo_name')[$oldIndex] }}">
                                            @error('wo_photo_name.' . $oldIndex)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">

                                            @if (isset(old('old_wo_photo_file')[$oldIndex]))
                                                <input type="file" name="wo_photo_file[{{ $oldIndex }}]" id="wo_photo_file[{{ $oldIndex }}]" class="d-none">
                                                <input type="hidden" name="old_wo_photo_file[{{ $oldIndex }}]" value="{{ old('old_wo_photo_file')[$oldIndex] }}">
                                                <a class="btn btn-sm btn-outline-dark" href="{{ old('old_wo_photo_file')[$oldIndex] }}" target="_blank"><i class="mdi mdi-file"></i> {{ explode('/', old('old_wo_photo_file')[$oldIndex])[count(explode('/', old('old_wo_photo_file')[$oldIndex])) - 1] }}</a>
                                            @else
                                                <input type="file" name="wo_photo_file[{{ $oldIndex }}]" class="form-control" id="file_{{ $oldIndex }}">
                                            @endif
                                            @error('wo_photo_file.' . $oldIndex)
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($workOrderProcesess->woDocuments as $index => $woDocument)
                                <tr data-index="{{ $index }}">
                                    <td>
                                        <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowWoPhoto(this.parentElement.parentElement)"
                                        @else
                                        onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                        <input {{ $readonly ? 'disabled' : '' }} type="hidden" name="old_id[{{ $index }}]" value="{{ $woDocument->id }}" class="d-none">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} placeholder="Photo Name" type="text" name="wo_photo_name[{{ $index }}]" class="form-control" id="photo_name_{{ $index }}" value="{{ $woDocument->photo_name }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="file" name="wo_photo_file[{{ $index }}]" id="wo_photo_file[{{ $index }}]" class="d-none">
                                            <input {{ $readonly ? 'disabled' : '' }} type="hidden" name="old_wo_photo_file[{{ $index }}]" value="{{ url('/storage/work-order-process-has-wo-document/file/' . $woDocument->file) }}">
                                            <a class="btn btn-sm btn-outline-dark" href="{{ url('/storage/work-order-process-has-wo-documents/file/' . $woDocument->file) }}" target="_blank"><i class="mdi mdi-file"></i> {{ $woDocument->file }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-index="0">
                                    <td>
                                        <button {{ $readonly ? 'disabled' : '' }} type="button" class="btn btn-sm btn-primary" onclick="addRowWoPhoto(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} placeholder="Photo Name" type="text" name="wo_photo_name[0]" class="form-control" id="photo_name_0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input {{ $readonly ? 'disabled' : '' }} type="file" name="wo_photo_file[0]" class="form-control" id="file_0">
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
