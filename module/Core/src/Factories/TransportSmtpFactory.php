<?php

namespace Core\Factories;


use Zend\Mail\Transport\SmtpOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Interop\Container\ContainerInterface;

class TransportSmtpFactory implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container, $requestName, array $options = null)
    {
        $config = $container->get('config');
        $transport = new SmtpTransport();
        $options = new SmtpOptions($config['mail']);
        $transport->setOptions($options);
        
        return $transport;
    }
}