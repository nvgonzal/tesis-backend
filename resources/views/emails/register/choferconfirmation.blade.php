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
Contraseña: {{$password}}
<p>Ya puedes hacer hacer uso de tu cuenta. Si olvidas tu contraseña se te enviara un link de recuperacion a este correo</p>
</body>
</html>