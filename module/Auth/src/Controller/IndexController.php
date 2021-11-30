<?php

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function loginAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $form = new LoginForm();

        return new ViewModel([
            'form' => $form->prepare()
        ]);
    }

    public function logoutAction()
    {
        return new ViewModel();
    }
}