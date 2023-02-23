@extends('layouts.centers')

@section('title')
    Socio
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">

                <h1>Detalle de {{ $partner->name }}</h1>

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

                    <a class="btn btn-outline-dark" href="{{ url()->previous() }}">Volver</a>
                </div>
            </div>
            
            <br>

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
            <table class="table table-striped text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
                @foreach($partner->treatments as $treatment)
                <tr>
                    <td>{{ $treatment->name }}</td>
                    <td>{{ $treatment->price }}</td>
                    <td>{{ $treatment->pivot->date }}</td>
                    <td><a class="btn btn-dark" href="{{ route('partners.editPivot', ['partner_id' => $partner->id, 'pivot_id' => $treatment->pivot->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"> Editar</i></a></td>
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
                <h3>Dinero total gastado {{ $totalPrice }} €</h3>
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
                <h6>Por favor, corrige los siguientes errores:</h6>
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
                                        <option value="default">Elegir tratamiento</option>
                                        @foreach($treatments as $id => $treatment)
                                        <option value="{{ $id }}" {{ (old('treatment') == $id ? 'selected':'') }}> {{$treatment}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-sm-12" for="date">Fecha:</label>
                                <input type="date" class="form-control" name="date" id="date" value = "{{ date('Y-m-d', strtotime('+1 day'))}}">
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