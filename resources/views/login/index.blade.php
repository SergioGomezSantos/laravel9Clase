@extends('layouts.centers')

@section('title')
    Login
@endsection

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="card">

                <div class="card-header text-center">
                    <h1>Introduce tus Credenciales</h1>
                </div>

                <div class="card-body">

                    @if ( Session::has('result') )
                        <div class="alert alert-success boldText alertPosition" role="alert">
                            {{ Session::get('result') }}
                        </div>
                    @elseif ( Session::has('error') )
                        <div class="alert alert-danger boldText alertPosition" role="alert">
                            {{ Str::limit(Session::get('error'), 100) }}
                        </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <h6>Por favor, corrige los siguientes errores:</h6>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="form-horizontal" action="{{ route('login.checkCredentials') }}" method="post">
                        @csrf
                        <div class="mt-4">
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="control-label col-sm-12" for="treatment">Nombre:</label>
                                        <input type="text" id="name" class="form-control bg-white col-sm-12" name="name" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="password">Contraseña</label>
                                        <input type="password" id="password" class="form-control bg-white col-sm-12" name="password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="text-center">
                            <button type="submit" class="btn btn-dark col-md-2">Iniciar Sesión</button>
                        </p>
                    </form>
                </div>
        </div>
        </div>
    </div>
</div>

@endsection