@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Cliente {{ $cliente->id }}</h1>
                <div class="d-flex gap-1">
                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ url()->previous() }}">Volver</a>
                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('clientes.index') }}">Clientes</a>
                </div>
            </div>

            <br>

            <form action="{{ route('clientes.update', ['cliente' => $cliente->id]) }}" method="POST">

                @csrf
                @method("PUT")

                <div class="row">

                    <div class="col form-group">
                        <label for="id">ID</label>
                        <input type="text" id="id" class="form-control bg-white text-center" name="id" placeholder="{{ $cliente->id }}" readonly>
                    </div>

                    <div class="col form-group">
                        <label for="created_at">Fecha de Creación</label>
                        <input type="text" id="created_at" class="form-control bg-white text-center" name="created_at" placeholder="{{ $cliente->created_at }}" readonly>
                    </div>

                    <div class="col form-group">
                        <label for="updated_at">Fecha de Actualización</label>
                        <input type="text" id="updated_at" class="form-control bg-white text-center" name="updated_at" placeholder="{{ $cliente->updated_at }}" readonly>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-4 form-group">
                        <label for="DNI">DNI</label>
                        <input type="text" id="DNI" class="form-control bg-white" name="DNI" value="{{ $cliente->DNI }}">
                    </div>

                    <div class="col-4 form-group">
                        <label for="Nombre">Nombre</label>
                        <input type="text" id="Nombre" class="form-control bg-white" name="Nombre" value="{{ $cliente->Nombre }}">
                    </div>

                    <div class="col-4 form-group">
                        <label for="Apellidos">Apellidos</label>
                        <input type="text" id="Apellidos" class="form-control bg-white" name="Apellidos" value="{{ $cliente->Apellidos }}">
                    </div>

                </div>

                <br>

                <div class="row">
                    <div class="col-4">
                        <label for="Telefono">Telefono</label>
                        <input type="text" id="Telefono" class="form-control bg-white" name="Telefono" value="{{ $cliente->Telefono }}">
                    </div>
                    <div class="col-4">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" class="form-control bg-white" name="Email" value="{{ $cliente->Email }}">
                    </div>
                </div>

                <br>

                <input type="submit" class="btn btn-primary boldText floatRight" value="Actualizar">
            </form>

            @if($errors->any())

                <div class="d-flex gap-1">
                    {!! implode('', $errors->all('<div class="alert alert-danger alertPosition" role="alert">:message</div>')) !!}
                </div>

            @endif
        </div>
    </div>
</div>
@endsection