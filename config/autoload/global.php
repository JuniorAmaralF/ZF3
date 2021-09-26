<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'driver' => 'Pdo_Mysql',
        'host' => 'localhost',
        'database' => 'zf3_helpdesk',
        'username' => 'root',
        'password' =>'88313573'
    ],
    'mail' => [
        'name' => 'smtp.mailtrap.io', #SMTP do servidor de e-mail
        'host' => 'smtp.mailtrap.io', #No google so repetir o SMTP
        'port' => 2525, #Porta do servidor de e-mail gmail 465
        'connection_class' => 'login', #Diz que sera feito uma autenticação
        'connection_config' => [
            'from' => '63f4920ef2-0009c0@inbox.mailtrap.io',
            'username' => '0e965980958551',#email de autenticação
            'password' => '5ebabeb7d49ca1',#senha do email para autenticar
            'auth' => 'CRAM-MD5',
        ]
    ]
];
