@extends('layouts.videoclub_master')

@section('title', 'Película')

@section('content')

<div class="row">

    <div class="col-sm-4">
        <img src="{{$pelicula['poster']}}"/>
    </div>

    <div class="col-sm-8">

        <h1>{{$pelicula['title']}}</h1>
        <h4>Año: {{$pelicula['year']}}</h4>
        <h4>Director: {{$pelicula['director']}}</h4>

        <br>

        <p>
            <b>Resumen: </b> {{$pelicula['synopsis']}}
        </p>

        <br>

        <p> 
            <b>Estado: </b>
            @if ($pelicula['rented'])
                Película actualmente alquilada
            @else
                Película disponible
            @endif
        </p>

        <br>

        @if ($pelicula['rented'])
                <button type="button" class="btn btn-danger">Devolver película</button>
        @else
                <button type="button" class="btn btn-primary">Alquilar película</button>
        @endif


        <button type="button" class="btn btn-warning" style="color: white">
            <i class="fa fa-pencil"></i>
            Editar película
        </button>

        <button type="button" class="btn btn-light">
            <i class="fa fa-chevron-left"></i>
            Volver al listado
        </button>

    </div>

</div>

@endsection