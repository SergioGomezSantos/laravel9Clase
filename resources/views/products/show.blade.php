@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Producto {{ $product->id }}</h1>
                <div class="d-flex align-items-center gap-1">
                    
                    @if ( Session::has('result') )
                        <div class="alert alert-success boldText alertPosition" role="alert">
                            {{ Session::get('result') }}
                        </div>
                    @elseif ( Session::has('error') )
                        <div class="alert alert-danger boldText alertPosition" role="alert">
                            {{ Str::limit(Session::get('error'), 100) }}
                        </div>
                    @endif

                    <div class="alert alert-info boldText alertPosition">
                        Color: {{ Session::get('color') }}
                    </div>

                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('products.index') }}">Productos</a>
                </div>
            </div>

            <br>

            <table class="table table-striped table-bordered text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>

                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->nombre }}</td>
                    <td id="descripcion">{{ Str::limit($product->descripcion, 50) }}</td>
                    <td>{{ $product->precio }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td><a class="text-decoration-none" href="{{ route('products.edit', $product->id) }}">Editar</a></td>
                    <td class="tdForm">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input class="btn btn-link text-decoration-none p-0 m-0 border-0" type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>

            </table>


        </div>
    </div>
</div>
@endsection