<?php

return [
    'composer_views' => ['partials.druidinfo','partials.gtm.js', 'partials.gtm.body','partials.gtm_events','errors.404'],
    'event_subscriber' => \Genetsis\Druid\Events\DruidSubscriber::class,
    'callback_controller' => \Genetsis\Druid\Controllers\ActionsController::class,

    'cookie_domain' => 'domain.com',
    'hosts' => [
        'dev' => [
            'auth' => '',
            'register' => '',
            'api' => '',
            'graph' => ''
        ],
        'test' => [
            'auth' => '',
            'register' => '',
            'api' => '',
            'graph' => ''
        ],
        'prod' => [
            'auth' => '',
            'register' => '',
            'api' => '',
            'graph' => ''
        ]
    ]
];
