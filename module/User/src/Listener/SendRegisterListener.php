<?php

namespace User\Listener;

use Core\Stdlib\CurrentUrl;
use User\Controller\IndexController;
use User\Mail\Mail;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;

class SendRegisterListener extends AbstractListenerAggregate
{

    use CurrentUrl;

    private $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }


    //attach sigfica anexar
    //precisa do service manager 
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
            IndexController::class,
            'registerAction.post',
            [$this,'onSendRegister'],
            $priority
        );
    }

    public function onSendRegister(Event $event)
    {
        $controller = $event->getTarget();
        $user = $event->getParams()['data'];

        $transport = $this->serviceManager->get('core.transport.smtp');
        $view = $this->serviceManager->get('View');

        $data = $user->getArrayCopy();
        $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
        $data['host'] = $this->getUrl($controller->getRequest());

        $mail = new Mail($transport,$view,'user/mailer/register');
        $mail->setSubject('Cadastro helpp Desk ZF3 na pratica')
        ->setTo(strtolower(trim($user->email)))
        ->setData($data)
        ->prepare()
        ->send();
        
    }
}