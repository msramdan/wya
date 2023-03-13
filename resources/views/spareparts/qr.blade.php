<!DOCTYPE html>
<html>

<style>
    @page {
        margin: 5px 0px 5px 5px
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
    <img style="width: 80px;" src="{{ public_path('qr/qr_sparepart/mollit-aut-corporis.svg') }}">
    <center>
        <span style="font-size: 16px"> <b>Scan Me</b> </span>
    </center>
</body>

</html>
