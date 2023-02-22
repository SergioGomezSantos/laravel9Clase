@extends('layouts.centers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Detalle del socio</h1>

            <table class="table table-striped text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>

                <tr>
                    <td>{{ $partner->name }}</td>
                    <td>{{ $partner->surnames }}</td>
                    <td>{{ $partner->address }}</td>
                    <td>{{ $partner->phone }}</td>
                    <td>{{ $partner->email }}</td>

                    <td><a class="btn btn-dark" href="{{ route('partners.edit', $partner->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"> Editar</a></i></td>


                    <td>
                        <form action="{{ route('partners.destroy', $partner->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class='fa fa-trash'> Borrar</i></button>
                        </form>
                    </td>

                </tr>
            </table>

            <h1>Tratamientos de {{$partner->name}}</h1>
            @if($message = Session::get('exito'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <table class="table table-striped text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
                @php $totalPrice = 0; $num = 1; @endphp
                @foreach($treatmentList as $treatment)
                <tr>
                    <td>{{ $treatment->name }}</td>
                    <td>{{ $treatment->price }}</td>
                    <td>{{ $treatment->pivot->date }}</td>
                    @php $totalPrice = $totalPrice + $treatment->price; @endphp
                    <td><a class="btn btn-dark" href="{{ route('partners.editPivot', ['id' => $partner->id, 'treatment_id' => $treatment->id, 'pivot_id' => $treatment->pivot->id, 'date' => $treatment->pivot->date]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"> Editar</i></a></td>
                    <td>
                        <form action="{{ route('partners.destroyPivot', ['id' => $partner->id, 'pivot_id' => $treatment->pivot->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class='fa fa-trash'> Borrar</i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="bg-secondary text-center text-white">
                <h3>Dinero total gastado {{$totalPrice}} €</h3>
            </div>

        </div>
    </div>
    <hr>
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
            <form class="form-horizontal" action="{{ route('partners.storePivot', $partner->id) }}" method="post">
                @csrf
                <div class="mt-4">
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label col-sm-12" for="treatment">Tratamiento:</label>
                                <div class="col-sm-12">
                                    <select name="treatment" id="treatment" class="col-sm-12">
                                        <option value="null">Elegir tratamiento</option>
                                        @foreach($treatments as $id => $treatment)
                                        <option value="{{ $id }}" {{ (old('treatment') == $id ? 'selected':'') }}> {{$treatment}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-sm-12" for="date">Fecha:</label>
                                <input type="date" class="form-control col-sm-12" name="date" id="date" value="{{ old('date') }}" placeholder="{{Carbon\Carbon::now()}}">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <p class="text-center">
                    <button type="submit" class="btn btn-dark col-md-2"><i class="fa fa-plus-circle" aria-hidden="true"> Añadir</i></button>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection