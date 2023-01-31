<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $setting->invPrefix }} {{ $invoice['invNo'] }} | {{ config('app.name') }}</title>
</head>

<body>
    INV No : {{ $invoice['invNo'] }}
</body>

</html>
