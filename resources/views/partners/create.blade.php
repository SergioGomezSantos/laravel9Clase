@extends('layouts.centers')

@section('title')
    Crear Socio
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Formulario socio</h1>
                </div>

                <div class="card-body">

                    <!-- Mostrar errores -->
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

                    <form action="{{ route('partners.store') }}" method="post">
                        @csrf
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" name="name" id="name" value="{{ old('name')}}" class="form-control" placeholder="Introduce el nombre">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="surnames">Apellidos:</label>
                                    <input type="text" name="surnames" id="surnames" value="{{ old('surnames')}}" class="form-control" placeholder="Introduce los apellidos">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección:</label>
                            <input type="text" name="address" id="address" value="{{ old('address')}}" class="form-control" placeholder="Introduce la dirección">
                        </div>
                        <br>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="phone">Teléfono:</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone')}}" class="form-control" placeholder="Introduce el teléfono">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" id="email" value="{{ old('email')}}" class="form-control" placeholder="Introduce el email">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="treatment">Tratamiento:</label>
                                    <select name="treatment" id="treatment" class="form-select" aria-label="Default select example">
                                        <option value="default">Elegir tratamiento</option>
                                        @foreach($treatments as $id => $treatment)
                                        <option value="{{ $id }}" {{ (old('treatment') == $id ? 'selected':'') }}> {{$treatment}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline form-group">
                                    <label for="date">Fecha:</label>
                                    <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-control" placeholder="{{Carbon\Carbon::now()}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-dark col-md-3"><i class="fa fa-plus-circle" aria-hidden="true"> Añadir</i></button>
                            <a class="btn btn-outline-dark col-md-3" href="{{ url()->previous() }}">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection