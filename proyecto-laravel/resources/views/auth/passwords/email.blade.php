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
            <div class="card-header">{{ __('Recuperar contraseña') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn" style="background: rgb(255,139,0); background: linear-gradient(198deg, rgba(255,139,0,1) 0%, rgba(255,134,0,1) 50%, rgba(212,44,0,1) 100%);">
                                {{ __('Enviar enlace de recuperación') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>