<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Code Location') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Name Location') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->code_location }}</td>
                <td>{{ $dt->location_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
