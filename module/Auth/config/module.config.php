<?php

namespace Auth;

use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'auth.login' => [
                'type' => Literal::class,
                'options' =>[
                    'route' => '/login',
                    'default' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'auth.logout' => [
                'type' => Literal::class,
                'options' =>[
                    'route' => '/logout',
                    'default' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'logout'
                    ]
                ]
            ],
        ]
    ]
];

?>