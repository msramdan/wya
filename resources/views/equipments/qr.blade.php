<!DOCTYPE html>
<html>

<style>
    @page {
        margin: 5px 0px 0px 0px
    }
</style>

<head>
    <title>Qr Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <center>
        <img style="width: {{ $widthQR }}px;" src="data:image/png;base64, {!! base64_encode(QrCode::generate($barcode)) !!} ">
        <center>
            <p style="font-size:10px;">SN : {{$equipment->serial_number}}</p>
            <p style="font-size:10px; margin-top:-20px">{{$equipment->location_name}}</p>
        </center>
        <img style="width: 90%;margin-top:-15px" src="{{ public_path('logo.png') }}">
    </center>
</body>

</html>
