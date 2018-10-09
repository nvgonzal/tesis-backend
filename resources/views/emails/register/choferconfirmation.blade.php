<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>Hola {{$user->nombre}}..</p>
<br>
<p>Se ha registrado una cuenta para ti.</p>
<br>
<p>Para hacer uso de ella ingresa con los siguientes datos</p>
<br>
Email:{{$user->email}}
<br>
Contraseña: {{$password}}
</body>
</html>