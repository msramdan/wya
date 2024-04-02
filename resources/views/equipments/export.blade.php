<table>
    <thead>
        <tr>
            @if (Auth::user()->roles->first()->hospital_id)
                <th style="background-color:#D3D3D3 ">{{ __('Hospital') }}</th>
            @endif
            <th style="background-color:#D3D3D3 ">{{ __('Barcode') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Nomenklatur') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Equipment Category') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Manufacturer') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Type') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Serial Number') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Vendor') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Condition') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Equipment Location') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Financing Code') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Tanggal Pembelian') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Harga Pendapatan') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>

                @if (Auth::user()->roles->first()->hospital_id)
                    <td>{{ $dt->hospital->name }}</td>
                @endif
                <td>{{ $dt->barcode }}</td>
                <td>{{ $dt->nomenklatur->name_nomenklatur }}</td>
                <td>{{ $dt->equipment_category->category_name }}</td>
                <td>{{ $dt->manufacturer }}</td>
                <td>{{ $dt->type }}</td>
                <td>{{ $dt->serial_number }}</td>
                <td>{{ $dt->vendor->name_vendor }}</td>
                <td>{{ $dt->condition }}</td>
                <td>{{ $dt->equipment_location->location_name }}</td>
                <td>{{ $dt->financing_code }}</td>
                <td>{{ $dt->tgl_pembelian }}</td>
                <td>{{ $dt->nilai_perolehan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
