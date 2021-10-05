<?php

namespace User\Form;

use User\Form\Filter\UserFilter;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Db\Adapter\Adapter;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;

class UserForm extends Form
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('user',[]);

        $this->setInputFilter(new UserFilter($adapter));
        $this->setAttributes(['method' => 'POST']);

        $name = new Text ('name');
        $name->setAttributes([
            'placeholder' => 'Full name',
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($name);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlenght' => 255
        ]);

        $this->add($email);

        $password = new Password('password');
        $password->setAttributes([
            'placeholder' => 'Password',
            'class' => 'form-control',
            'maxlenght' => 48
        ]);

        $this->add($password);

        $verifyPassword = new Password('verifypassword');
        $verifyPassword->setAttributes([
            'placeholder' => 'Retype password',
            'class' => 'form-control',
            'maxlenght' => 48
        ]);

        $this->add($verifyPassword);

       /*
        *Csrf é a sigla de cross-site request forgery é um tipo de ataque para injetar script na sua aplicação através de uma formulário.
        *Na prática o Zend injeta um input do tipo hidden com uma hash, esta hash tem um tempo de expiração, caso ela expira os dados do formulário ficará inválido.
        */
        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);

        $this->add($csrf);
    }

}