<?php

return [
    'custom' => [
        'numero_documento' => [
            'required' => 'El número de documento es obligatorio.',
            'digits' => 'El número de documento debe tener exactamente :digits dígitos.',
            'numeric' => 'El número de documento debe ser numérico.',
        ],
        'email' => [
            'unique' => 'El correo electrónico ya ha sido registrado.',
        ],
    ],
    'attributes' => [
        'numero_documento' => 'número de documento',
        'email' => 'correo electrónico',
    ],
];