<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Message</title>
</head>
<body>
    <h1>Order # {{$recibo->id}} has been shipped</h1>
    <h3>Order name: {{$recibo->iva}}</h3>
    <h3>Total price: {{$recibo->nif}}</h3>
</body>
</html>
