@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Cliente {{ $cliente->id }}</h1>
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

                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('clientes.index') }}">Clientes</a>
                </div>
            </div>

            <br>

            <table class="table table-striped table-bordered text-center">
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>

                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->DNI }}</td>
                    <td>{{ $cliente->Nombre }}</td>
                    <td>{{ $cliente->Apellidos }}</td>
                    <td>{{ $cliente->Telefono }}</td>
                    <td>{{ $cliente->Email }}</td>
                    <td>{{ $cliente->created_at }}</td>
                    <td>{{ $cliente->updated_at }}</td>
                    <td><a class="text-decoration-none" href="{{ route('clientes.edit', $cliente->id) }}">Editar</a></td>
                    <td class="tdForm">
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input class="btn btn-link text-decoration-none p-0 m-0 border-0" type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>

            </table>

            @if ($cliente->orders->count() > 0)

                <br>

                <div class="d-flex justify-content-between align-items-center">
                    <h1>Pedidos del Cliente {{ $cliente->id }}</h1>
                </div>


                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Actualización</th>
                    </tr>

                    @foreach ($cliente->orders as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->solicitante }}</td>
                        <td>{{ $order->fecha }}</td>
                        <td>{{ Str::limit($order->descripcion, 50) }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                    </tr>

                    @endforeach

                </table>

            @endif

        </div>
    </div>
</div>
@endsection