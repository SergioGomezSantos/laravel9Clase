@extends('layouts.master')

@section('titulo', 'Página de Información')

@section('widget')
    @parent
    <h4>Added in Widget</h4>
@stop

@section('mainContent')
    @parent
    <table>
        <tr>
            <td>Ciclo</td>
            <td>Módulo</td>
        </tr>
        <tr>
            <td>{{ $ciclo }}</td>
            <td>{{ $modulo }}</td>
        </tr>
    </table>
@stop

@section('secondaryContent')
    Horas: 
    @foreach ( $horas as $hora )
        {{ $hora }}
    @endforeach
@stop