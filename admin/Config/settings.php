<?php

$settings = [
    'basic' => [
        'form' => [
            'clear' => true,
            'redirect' => false
        ],
        'inputs' => [
            'disabled' => false,
            'highlight' => true
        ]
    ],
    'extend' => [
        'site' => [
            'domain' => 'mvccms.ru'
        ]
    ],
    'core' => [
        'model' => [
            'site' => 'sitemodel',
            'admin' => 'on'
        ],
        'view' => [
            'index' => 'isset',
            'redirect' => 'noallow'
        ]
    ]
];

echo json_encode($settings);