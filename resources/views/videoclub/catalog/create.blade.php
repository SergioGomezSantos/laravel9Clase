@extends('layouts.videoclub_master')

@section('title', 'Nueva Película')

@section('content')

    <br>

    <h2>Nueva Película</h2>

    <br>

    <form>
        
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>

        <br>

        <div class="form-group">
            <label for="year">Año</label>
            <input type="text" class="form-control" id="year" name="year">
        </div>

        <br>

        <div class="form-group">
            <label for="director">Director</label>
            <input type="text" class="form-control" id="director" name="director">
        </div>

        <br>

        <div class="form-group">
            <label for="poster">Poster</label>
            <input type="text" class="form-control" id="poster" name="poster">
        </div>

        <br>

        <div class="form-group">
            <label for="synopsis">Resumen</label>
            <textarea class="form-control" id="synopsis" name="synopsis" rows="3"></textarea>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Añadir Película</button>
    </form>

@endsection