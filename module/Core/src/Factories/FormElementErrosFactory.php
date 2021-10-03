<?php
//aqui esta criando um factory de uma helper
namespace Core\Factories;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Form\View\Helper\FormElementErrors;

class FormElementErrosFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new FormElementErrors();
        
        $config = $container->get('config');
        if (isset($config['view_helper_config']['form_element_erros'])) {
            $configHelper = $config['view_helper_config']['form_element_erros'];
            if (isset($configHelper['message_open_format'])){
                $helper->setMessageOpenFormat($configHelper['message_open_format']);
            }
            
            if (isset($configHelper['message_separator_string'])){
                $helper->setMessageSeparatorString($configHelper['message_separator_string']);
            }
            
            if (isset($configHelper['message_close_string'])){
                $helper->setMessageCloseString($configHelper['message_close_string']);
            }
        }
        return $helper;
        
    }

    
}