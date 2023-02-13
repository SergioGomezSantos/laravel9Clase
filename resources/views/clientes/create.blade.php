@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Nuevo Cliente</h1>
                <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('products.index') }}">Volver</a>
            </div>

            <form action="{{ route('clientes.store') }}" method="POST">

                <br>

                @csrf

                <div class="row">
                    <div class="col-4">
                        <label for="DNI">DNI</label>
                        <input type="text" id="DNI" class="form-control bg-white" name="DNI">
                    </div>

                    <div class="col-4">
                        <label for="Nombre">Nombre</label>
                        <input type="text" id="Nombre" class="form-control bg-white" name="Nombre">
                    </div>
                    <div class="col-4">
                        <label for="Apellidos">Apellidos</label>
                        <input type="text" id="Apellidos" class="form-control bg-white" name="Apellidos">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-4">
                        <label for="Telefono">Telefono</label>
                        <input type="text" id="Telefono" class="form-control bg-white" name="Telefono">
                    </div>
                    <div class="col-4">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" class="form-control bg-white" name="Email">
                    </div>
                </div>

                <br>

                <input type="submit" class="btn btn-primary boldText floatRight" value="Crear">
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