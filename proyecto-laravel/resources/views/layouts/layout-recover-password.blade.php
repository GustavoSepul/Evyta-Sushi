<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <style type="text/css">
        .fondo-reset-password{
            background-image: url('https://i.pinimg.com/736x/d0/3f/de/d03fde84499e848fa292fe0fd63a367d.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none; /* Chrome, Safari, Edge, Opera */
            margin: 0;
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
    </style>
</head>
<body>
<div class="row m-0 justify-content-center fondo-reset-password" style="padding-bottom:600px; padding-top:300px;">
    <div class="col-md-8">
        <div class="card">
            @yield('content');
        </div>
    </div>
</div>
</body>
</html>