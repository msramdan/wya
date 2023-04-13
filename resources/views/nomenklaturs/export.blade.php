<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Code Nomenklatur') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Name Nomenklatur') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->code_nomenklatur }}</td>
                <td>{{ $dt->name_nomenklatur }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
