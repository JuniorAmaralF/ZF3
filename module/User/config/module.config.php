<?php
//vai criar as rotas aqui
namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'=> 'register'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            //meusite.com/user/confirme/token/4085484 (md5)
                            'route' => '[/:action][/token/:token]',
                            'constraints' => [
                                'action' => '[a-zA-z][a-zA-z0-9_-]*',
                                'token' => '[[a-f0-9]{32}]$'
                            ]
                        ]
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'user/layout/layout' => __DIR__.'/../view/layout/layout.phtml',
            
            'user/index/confirmed-email' => __DIR__.'/../view/user/index/confirmed-email.phtml',
            'user/index/new-password' => __DIR__.'/../view/user/index/new-password.phtml',
            'user/index/recovered-password' => __DIR__.'/../view/user/index/recovered-password.phtml',
            'user/index/register' => __DIR__.'/../view/user/index/register.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ]
    ]

];

?>