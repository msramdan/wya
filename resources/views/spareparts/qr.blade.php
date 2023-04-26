<!DOCTYPE html>
<html>

<style>
    @page {
        margin: 5px 0px 0px 0px
    }

    /* body {
        margin: 1px 1px 2px 2px
    } */
</style>

<head>
    <title>Qr Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <center>
        <img style="width: {{ $widthQR }}px;" src="data:image/png;base64, {!! base64_encode(QrCode::generate($barcode)) !!} ">
        <img style="width: 90%;" src="{{ public_path('logo.png') }}">
    </center>
</body>

</html>
