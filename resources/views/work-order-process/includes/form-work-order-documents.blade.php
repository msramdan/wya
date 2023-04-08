<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>Work Order Document</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table" id="table-dokumen">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document Name</th>
                            <th>Description</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($workOrderProcesess->woDocuments as $index => $woDocument)
                            <tr data-index="{{ $index }}">
                                <td>
                                    <button class="btn btn-sm btn-{{ $index == 0 ? 'primary' : 'danger' }}" @if ($index == 0) onclick="addRowWoDocument(this.parentElement.parentElement)"
                                @else
                                onclick="this.parentElement.parentElement.remove()" @endif><i class="fa fa-{{ $index == 0 ? 'plus' : 'trash' }}"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input placeholder="Document Name" type="text" name="document_name[{{ $index }}]" class="form-control" id="document_name_{{ $index }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input placeholder="Description" type="text" name="description[{{ $index }}]" class="form-control" id="description_{{ $index }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="file" name="file[{{ $index }}]" class="form-control" id="file_{{ $index }}">
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr data-index="0">
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="addRowWoDocument(this.parentElement.parentElement)"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input placeholder="Document Name" type="text" name="document_name[0]" class="form-control" id="document_name_0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input placeholder="Description" type="text" name="description[0]" class="form-control" id="description_0">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="file" name="file[0]" class="form-control" id="file_0">
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
