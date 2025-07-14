<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de No Prórroga</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 40px; 
            color: #222; 
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .linea-divisora {
            border: none;
            border-top: 2px solid red;
            margin: 20px 0;
        }

        .date {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .destinatario { 
            margin-top: 30px; 
        }

        .saludo { 
            margin-top: 30px; 
        }

        .firma { 
            margin-top: 50px; 
        }

        .firma-linea { 
            border-top: 1px solid #222; 
            width: 250px;
            margin-top: 40px; 
        }

        .footer { 
            margin-top: 60px; 
            font-size: 0.95em; 
            color: #555; 
            text-align: center; 
        }

        .footer {
        position: absolute;
        bottom: 40px; /* Ajusta según el margen del PDF */
        left: 0;
        right: 0;
        font-size: 0.60em;
        color: #555;
        text-align: center;
        }

    </style>
</head>
<body>
    <div class="header">
        @if (isset($logoBase64) && $logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo Formacol" class="logo">
        @else
            <span>Logo Formacol (No disponible)</span>
        @endif
    </div>

    <hr class="linea-divisora">

    <div class="date">
        Medellín, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}
    </div>
    <br><br>
    <div class="destinatario">
    <strong>Señor(a)</strong><br>
    {{ $empleado->nombre_completo ?? 'Nombre Empleado' }}<br>
    {{ $empleado->estadoActual?->estadoCargo?->cargo?->nombre_cargo ?? 'Cargo no asignado' }}<br>
    {{ $empresa->nombre_empresa ?? 'Empresa' }}
</div>

    <div class="saludo">
        <strong>Cordial saludo,</strong><br><br>
        Le informamos que la empresa ha tomado la decisión de no prorrogar el contrato de trabajo fijo prorrogable a 
        <strong>{{ $estado->duracion_prorrogas ?? '?' }}</strong> meses que tiene suscrito con usted y el cual vence el día 
        <strong>{{ $fecha_finalizacion ? $fecha_finalizacion->format('d/m/Y') : 'Fecha no disponible' }}</strong>.<br><br>
        
        Favor firmar y devolver la copia en señal del recibido.<br><br><br>
        Atentamente,
    </div>
    <div class="firma">
        <div class="firma-linea"></div>
        <br>
        <strong>Sebastián Núñez Patiño</strong><br>
        Gestión Humana
    </div>
    <div class="footer">
        <strong>Formacol S.A NIT 890.900.331-4</strong><br>
        Oficinas: Calle 4 sur #43 AA 30, Edificio Formacol, Piso 10-Tel: (57 604) 326 69 00<br>
        E-mail: <a href="mailto:formacol@formacol">formacol@formacol</a> &nbsp;|&nbsp; 
        Página WEB: <a href="https://formacol.com">Formacol.com</a><br>
        Medellín - Colombia - Sur América
    </div>
</body>
</html>
