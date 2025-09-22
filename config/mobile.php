<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración para Acceso Móvil
    |--------------------------------------------------------------------------
    |
    | Esta configuración permite que las imágenes y otros recursos sean accesibles
    | desde dispositivos móviles en la misma red local.
    |
    */

    // IP de la computadora donde corre el servidor (para acceso desde celular)
    // Importante: Cambia esta valor por la IP real de tu computadora en la red
    'server_ip' => env('MOBILE_SERVER_IP', '192.168.1.100'),

    // Puerto del servidor (normalmente 8000 para Laravel, 80 para XAMPP)
    'server_port' => env('MOBILE_SERVER_PORT', '8000'),

    // Protocolo (http o https)
    'protocol' => env('MOBILE_PROTOCOL', 'http'),

    // Habilitar reemplazo automático de URLs para acceso móvil
    'enable_url_replacement' => env('MOBILE_ENABLE_URL_REPLACEMENT', true),
];
