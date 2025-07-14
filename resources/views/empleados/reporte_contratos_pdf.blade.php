<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Contratos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 180px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .mensaje-vacio {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="encabezado">
        @if (isset($logoBase64) && $logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo DemGest" class="logo">
        @else
            <span>Logo DemGest (No disponible)</span>
        @endif
    </div>

    <h1>Reporte de Contratos - {{ $fechaAlerta->format('d/m/Y') }}</h1>
    <hr>

    @if ($empleados->isEmpty())
        <p class="mensaje-vacio">No hay empleados con contratos próximos a finalizar en este periodo.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Fecha Terminación</th>
                    <th>Días Restantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado['nombre_completo'] }}</td>
                        <td>{{ $empleado['numero_documento'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($empleado['fecha_terminacion'])->format('d/m/Y') }}</td>
                        <td>{{ floor($empleado['dias_restantes']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>