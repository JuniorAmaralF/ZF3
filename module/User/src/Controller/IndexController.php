<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//aqui fica as ações que podem ser executadas
class IndexController extends AbstractActionController
{
    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }

    public function recoveredPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }

    public function newPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }

    public function confirmedEmailAction()
    {
        return new ViewModel();
    }
}
