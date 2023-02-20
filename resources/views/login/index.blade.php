@extends('layouts.centers')

@section('title')
    Login
@endsection

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">

                <h1>Introduce tus Credenciales</h1>

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
                    
                </div>
            </div>

            <form action="{{ route('login.checkCredentials') }}" method="POST">

                <br>

                @csrf

                <div class="row">
                    <div class="col-4">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="name" class="form-control bg-white" name="name">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-4">
                        <label for="precio">Contraseña</label>
                        <input type="password" id="password" class="form-control bg-white" name="password">
                    </div>
                </div>

                <br>

                <input type="submit" class="btn btn-primary boldText floatRight" value="Iniciar Sesión">
            </form>

            <br>

            @if($errors->any())

                <div class="d-flex gap-1">
                    {!! implode('', $errors->all('<div class="alert alert-danger alertPosition" role="alert">:message</div>')) !!}
                </div>

            @endif
        </div>
    </div>
</div>

@endsection