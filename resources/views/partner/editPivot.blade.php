@extends('layouts.centers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Añadir un nuevo tratamiento</h2>
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
                    <form class="form-horizontal" action="{{ route('partners.updatePivot', ['id' => $id, 'treatment_id' => $treatment_id, 'pivot_id' => $pivot_id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label col-sm-12" for="treatment">Tratamiento:</label>
                                        <div class="col-sm-12">
                                            <select name="treatment" id="treatment" class="col-sm-12">
                                                <option value="null">Elegir tratamiento</option>
                                                @foreach($treatments as $id => $treatment)
                                                <option value="{{ $id }}" {{ $id == $treatment_id ? 'selected' : '' }}> {{$treatment}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label col-sm-2" for="newDate">Fecha:</label>
                                        <input type="date" class="form-control" name="newDate" id="newDate" value="{{ $date }}" placeholder="{{Carbon\Carbon::now()}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="text-center"><input type="submit" class="btn btn-dark" value="Actualizar"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection