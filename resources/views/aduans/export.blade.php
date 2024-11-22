<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('No') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Nama') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Email') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Judul') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Keterangan') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Tanggal') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Type') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Is Read') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Status') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Token') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->judul }}</td>
                <td>{{ $row->keterangan }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->is_read }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->token }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
