@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function() {
        loadDataHtml();
        $("#btnJson").one("click", loadDataJson);
    });

    const loadDataHtml = function() {

        let url = "/productos/html"
        $.get(url, function(data, status) {
            $("#tablahtml").html(data);
        })
        .fail(function(e) {
            console.log("Error" + e.status);
        });
    }

    const loadDataJson = function() {

        let url = "/productos/json"
        $.get(url, function(data, status) {

            Object.keys(data).forEach(function(id) {

                console.log(id);
                console.log(data[id]);

                var tr = document.createElement("tr");
                tr.setAttribute("id", `tr${data[id].id}`);
                let fila = "<td>" + data[id].id + "</td>";
                fila += "<td>" + data[id].nombre + "</td>";
                fila += "<td>" + data[id].descripcion + "</td>";
                fila += "<td>" + data[id].precio + "</td>";
                // fila += "<td>" + data[id].created_at + "</td>";
                // fila += "<td>" + data[id].updated_at + "</td>";
                tr.innerHTML = fila;
                $("#myTbody").append(tr);
            });
        })
        .fail(function(e) {
            console.log("Error" + e.status);
        });

        $("#btnJson").text("Vaciar Tabla");
        $("#btnJson").one("click", resetTable);
    }

    const resetTable = function() {
        $("#myTbody").empty();
        loadDataHtml();

        $("#btnJson").text("Cargar Json");
        $("#btnJson").one("click", loadDataJson);
    }

</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <br>

            <div class="d-flex justify-content-between align-items-center">
                <h1>Lista de Productos</h1>
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

                    <a id="btnJson" class="btn btn-primary d-flex align-items-center boldText">Cargar Json</a>
                </div>
            </div>

            <br>    

            <div id="tablahtml"></div>

        </div>
    </div>
</div>
@endsection