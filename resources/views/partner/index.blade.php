@extends('layouts.centers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if($message = Session::get('exito'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            
            <h1>Lista de socios</h1>
            <h4>Hay {{ sizeof($partnerList) }} socios</h4>

            <a class="btn btn-outline-dark" href="{{ route('partners.create') }}">Nuevo socio</a>

            <table class="table table-striped text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Ver</th>
                    <th>Borrar</th>
                </tr>

                @foreach($partnerList as $partner)
                <tr>
                    <td>{{ $partner->name }}</td>
                    <td>{{ $partner->surnames }}</td>
                    <td>{{ Str::limit($partner->address, 20) }}</td>
                    <td>{{ $partner->phone }}</td>
                    <td>{{ $partner->email }}</td>
                    
                    <td><a class="btn btn-dark" href="{{ route('partners.edit', $partner->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"> Editar</i></a></td>
                    
                    <td> <a class="btn btn-dark" href="{{ route('partners.show', $partner->id) }}"><i class="fa fa-eye" aria-hidden="true"> Ver</i></a></td>
                    
                    <td>
                        <form action="{{ route('partners.destroy', $partner->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"> Borrar</i></button>
                        </form>
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection