<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>Hola {{$user->nombre}}..</p>
<br>
<p>Tu empresa ha sido registrada con exito</p>
<br>
<p>Con esta cuenta podras hacer uso de las funcionalidades del sistema:</p>
<br>
Email:{{$user->email}}
<br>
Contraseña: {{$password}}
<p>Ya puedes hacer hacer uso de tu cuenta. Con esta podran acceder a la aplicacion movil</p>
</body>
</html>