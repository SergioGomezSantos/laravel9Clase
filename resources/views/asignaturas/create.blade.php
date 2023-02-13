@extends('layouts.asignaturas_master')

@section('titulo', 'Alta de Asignaturas')

@section('home')
    {{ route('asignaturas.index') }}
@stop

@section('encabezado')
    Formulario de Alta de Asignaturas
@stop

@section('cuerpo')

    @parent
    Completa el siguiente formulario

    @if ($errors->any())

        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>

    @endif

    <form method="POST" action="{{ route('asignaturas.store') }}">

        @csrf
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}">

        <br><br>
                
        <label for="curso">Curso</label>
        <input type="text" name="curso" id="curso" value="{{ old('curso') }}">

        <br><br>
        
        <label for="ciclo">Ciclo</label>
        <input type="text" name="ciclo" id="ciclo" value="{{ old('ciclo') }}">

        <br><br>

        <label for="comentario">Comentario</label>
        <br>
        <textarea name="comentario" id="comentario" cols="30" rows="10" placeholder="Escribe aquí">{{ old('comentario') }}</textarea>

@stop

@section('boton')
    @parent

    @section('destino')
        {{ route('asignaturas.store') }}
    @stop

    @section('accionFormulario')
        Enviar
    @stop

    </form>
@stop
