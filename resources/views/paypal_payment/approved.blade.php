@extends('main')

@section('titulo','Tu pago ha sido aprovado')

@section('contenido')

    <h1>El pago ha sido aprovado</h1>

    <h2>Gracias por usar nuestro servicio</h2>

    <a href="{{Session::get('angularBack')}}">Ir a estado del servicio</a>

@endsection