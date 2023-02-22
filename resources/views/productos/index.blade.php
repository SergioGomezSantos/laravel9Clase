@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Lista de Productos</h1>
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
                        Visitas a Pares: {{ Session::get('visitasPares') }}
                    </div>

                    <a class="btn btn-primary d-flex align-items-center boldText" href="{{ route('products.create') }}">Nuevo Producto</a>
                </div>
            </div>

            <br>    

            

        </div>
    </div>
</div>
@endsection