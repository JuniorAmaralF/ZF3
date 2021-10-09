<?php

namespace User\Controller;

use Exception;
use User\Form\UserForm;
use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//aqui fica as ações que podem ser executadas
class IndexController extends AbstractActionController
{
    private $userForm;
    private $userTable;
    //tudo que esta vindo la da pagina sera jogando dentro do user form
    public function __construct(UserForm $userForm, UserTable $userTable)
    {   
        $this->userForm = $userForm;
        $this->userTable = $userTable;
    }

    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        if($this->getRequest()->isPost()){
           $this->userForm->setData($this->getRequest()->getPost());

           if($this->userForm->isValid()){
               $data = $this->userForm->getData();
            
               try {
                   $user = $this->userTable->save($data);

                   $this->getEventManager()->trigger(
                       __FUNCTION__.'post',
                       $this,
                       ['data' => $user]
                   );
                  
                   $this->flashMessenger()->addSuccessMessage(
                       sprintf('Confirme seu registro no email "%s"', $data['email'])
                   );
               } catch (Exception $exception){
                echo $exception->getTraceAsString();
                die();
               }

               return $this->redirect()->refresh();

           }
        }

        return new ViewModel([
            'form' => $this->userForm->prepare()
        ]);
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
