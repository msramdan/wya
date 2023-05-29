<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Hospital') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Name') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Nid Employee') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Employee Type') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Employee Status') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Department') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Position') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Email') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Phone') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Join Date') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Province') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Kabkot') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Kecamatan') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Kelurahan') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Zip Kode') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Address') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->nama_hospital }}</td>
                <td>{{ $dt->name }}</td>
                <td>{{ $dt->nid_employee }}</td>
                <td>{{ $dt->name_employee_type }}</td>
                @if ($dt->employee_status)
                    <td>Aktif</td>
                @else
                    <td>Non Aktif</td>
                @endif
                <td>{{ $dt->name_department }}</td>
                <td>{{ $dt->name_position }}</td>
                <td>{{ $dt->email }}</td>
                <td>{{ $dt->phone }}</td>
                <td>{{ $dt->join_date }}</td>
                <td>{{ $dt->provinsi }}</td>
                <td>{{ $dt->kabupaten_kota }}</td>
                <td>{{ $dt->kecamatan }}</td>
                <td>{{ $dt->kelurahan }}</td>
                <td>{{ $dt->zip_kode }}</td>
                <td>{{ $dt->address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
