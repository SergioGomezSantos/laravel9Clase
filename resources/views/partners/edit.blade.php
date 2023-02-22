@extends('layouts.centers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header text-center">
                    <h1>Editar socio</h1>
                </div>

                <div class="card-body">

                    <!-- Mostrar errores -->
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <h6>Por favor corrige los siguientes errores:</h6>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('partners.update', $partner->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $partner->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="surnames">Apellidos:</label>
                                    <input type="text" name="surnames" id="surnames" class="form-control" value="{{ $partner->surnames ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección:</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ $partner->address ?? '' }}">
                        </div>
                        <br>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="phone">Teléfono:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $partner->phone ?? '' }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" id="email" class="form-control" value="{{ $partner->email ?? '' }}" placeholder="Introduce el email">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-dark col-md-3" value="Actualizar">
                            <a class="btn btn-outline-dark col-md-3" href="{{ url()->previous() }}">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection