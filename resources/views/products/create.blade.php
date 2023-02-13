@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Nuevo Producto</h1>
                <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('products.index') }}">Volver</a>
            </div>

            <form action="{{ route('products.store') }}" method="POST">

                <br>

                @csrf

                <div class="row">
                    <div class="col">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control bg-white" name="nombre">
                    </div>
                    <div class="col-2">
                        <label for="precio">Precio</label>
                        <input type="number" step="any" id="precio" class="form-control bg-white" name="precio">
                    </div>
                </div>
                <br>

                <div class="col">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" class="form-control bg-white" name="descripcion" rows="3"></textarea>
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