<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostar Información</title>
</head>
<body>
    Mostar Información

    <table>
        <tr>
            <td>Ciclo</td>
            <td>Modulo</td>
        </tr>
        <tr>
            <td>{{ $ciclo }}</td>
            <td>{{ $modulo }}</td>
        </tr>
    </table>

    <br><br>
    
    <span>Modulo === DWES ? </span>
    @if ( $modulo === 'DWES' )
        Si
    @else
        No
    @endif

    <br><br>

    @foreach ( $horas as $hora )
        {{ $hora }} <br>
    @endforeach

</body>
</html>