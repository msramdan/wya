<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Hospital') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Barcode') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Sparepart Name') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Merk') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Sparepart Type') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Estimated Price') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Stock') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Unit Item') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->nama_hospital }}</td>
                <td>{{ $dt->barcode }}</td>
                <td>{{ $dt->sparepart_name }}</td>
                <td>{{ $dt->merk }}</td>
                <td>{{ $dt->sparepart_type }}</td>
                <td>{{ $dt->estimated_price }}</td>
                <td>{{ $dt->stock }}</td>
                <td>{{ $dt->unit_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
