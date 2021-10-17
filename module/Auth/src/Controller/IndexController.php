<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Console\View\ViewModel;

class IndexController extends AbstractActionController
{
    public function loginAction()
    {
        return new ViewModel();
    }

    public function logoutAction()
    {
        return new ViewModel();
    }
}