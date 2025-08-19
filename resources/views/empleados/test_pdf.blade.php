<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Test PDF</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 0; 
            padding: 10px;
        }
        h1 { 
            font-size: 16px; 
            text-align: center; 
            margin: 0 0 10px 0; 
            padding: 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 5px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
    </style>
</head>
<body>
    <h1>TEST DE PDF</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado['nombre_completo'] ?? 'N/A' }}</td>
                    <td>{{ $empleado['numero_documento'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
