<?php
//vai criar as rotas aqui
namespace User;

use Zend\Db\Sql\Predicate\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'default' => [
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
    ]
];

?>