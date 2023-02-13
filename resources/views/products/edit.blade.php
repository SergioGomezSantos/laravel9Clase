@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Producto {{ $product->id }}</h1>
                <div class="d-flex gap-1">
                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ url()->previous() }}">Volver</a>
                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('products.index') }}">Productos</a>
                </div>
            </div>

            <br>

            <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">

                @csrf
                @method("PUT")

                <div class="row">

                    <div class="col form-group">
                        <label for="id">ID</label>
                        <input type="text" id="id" class="form-control bg-white text-center" name="id" placeholder="{{ $product->id }}" readonly>
                    </div>

                    <div class="col form-group">
                        <label for="created_at">Fecha de Creación</label>
                        <input type="text" id="created_at" class="form-control bg-white text-center" name="created_at" placeholder="{{ $product->created_at }}" readonly>
                    </div>

                    <div class="col form-group">
                        <label for="updated_at">Fecha de Actualización</label>
                        <input type="text" id="updated_at" class="form-control bg-white text-center" name="updated_at" placeholder="{{ $product->updated_at }}" readonly>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-10 form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control bg-white" name="nombre" value="{{ $product->nombre }}">
                    </div>

                    <div class="col-2 form-group">
                        <label for="precio">Precio</label>
                        <input type="number" step="any" id="precio" class="form-control bg-white" name="precio" value="{{ $product->precio }}">
                    </div>

                </div>

                <br>

                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" class="form-control bg-white" name="descripcion" rows="3">{{ $product->descripcion }}</textarea>
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