<?php

namespace User\Controller;

use Exception;
use User\Form\NewPassword;
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
                       __FUNCTION__.'.post',
                       $this,
                       ['data' => $user]
                   );
                  
                   $this->flashMessenger()->addSuccessMessage(
                       sprintf('Confirme seu registro no email "%s"', $data['email'])
                   );
               } catch (Exception $exception){
                $this->flashMessenger()->addErrorMessage(
                    $exception->getMessage()
                );
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
        $form = new NewPassword();

        //se a requeste for um post
        if($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if($form->isValid()){
                $email = $form->getData()['email'];

                $this->getEventManager()->trigger(
                    __FUNCTION__.'.post',
                    $this,
                    ['data' => $email]
                );

                $this->flashMessenger()->addSuccessMessage(
                    'Confirme sua solicitação no email informado'
                );     
                
                return $this->redirect()->refresh();
            }
        }

        return new ViewModel([
            'form' => $form->prepare()
        ]);
    }

    public function newPasswordAction()
    {

       try  {
           $token = $this->params()->fromRoute('token');

           $user = $this->userTable->getUserByToken($token);

            $this->layout()->setTemplate('user/layout/layout');

            if($this->getRequest()->isPost()){
                $this->userForm->setValidationGroup(['password','verifypassword']);
                //populando o formulario
                $this->userForm->setData($this->getRequest()->getPost());
                //verifica se o formulario e valido 
                if($this->userForm->isValid()){
                    $password = $this->userForm->getData()['password'];

                    try{
                        $this->userTable->save([
                            'id' => $user->id,
                            'password' => $password
                        ]);

                        $this->flashMessenger()->addSuccessMessage(
                            'Senha alterado com sucesso!'
                        );

                        return $this->redirect()->toRoute('auth.login');
 
                    } catch (Exception $exception){

                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                        return $this->redirect()->refresh();
                    }
                }

            }

            return new ViewModel([
                'form' => $this->userForm->prepare()
            ]);

       } catch (Exception $exception){

        $this->flashMessenger()->addErrorMessage($exception->getMessage());
       
        return $this->redirect()->toRoute('auth.login');

       }
   
       
    }

    public function confirmedEmailAction()
    {
       $token = $this->params()->fromRoute('token',null);
    
       try {

            $user = $this->userTable->getUserByToken($token);
            $this->userTable->save($user->getArrayCopy());

            $this->flashMessenger()->addSuccessMessage(
                'Conta confirmada com sucesso!'  
            );

       } catch (Exception $exception){

        $this->flashMessenger()->addErrorMessage($exception->getMessage());
        //rota aidna p´recisa ser criada 
        return $this->redirect()->toRoute('auth.login');
       }
    }
}
