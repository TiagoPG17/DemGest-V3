<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Centros de Costos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 150px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e6f3ff; }
    </style>
</head>
<body>
    <div class="header">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo">
        @endif
        <h1>Reporte de Centros de Costos</h1>
        <p>Fecha de generación: {{ $fecha_generacion }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Código Centro de Costo</th>
                <th>Nombre Centro de Costo</th>
                <th>Cantidad de Trabajadores</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costCenters as $center)
                <tr>
                    <td>{{ $center->centro_costo }}</td>
                    <td>{{ $center->centro_nombre }}</td>
                    <td>{{ $center->cantidad_trabajadores }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total de Trabajadores</td>
                <td>{{ $costCenters->sum('cantidad_trabajadores') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>