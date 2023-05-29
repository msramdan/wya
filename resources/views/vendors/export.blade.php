<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Hospital') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Code Vendor') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Name Vendor') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Category Vendor') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Email') }}</th>
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
                <td>{{ $dt->code_vendor }}</td>
                <td>{{ $dt->name_vendor }}</td>
                <td>{{ $dt->name_category_vendors }}</td>
                <td>{{ $dt->email }}</td>
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
