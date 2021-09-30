<?php

namespace User\Form;

use User\Form\Filter\NewPasswordFilter;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Form;

class NewPassword extends Form
{
    public function __construct()
    {
        parent::__construct('new-password',[]);

        $this->setInputFilter(new NewPasswordFilter());
        $this->setAttributes(['method' => 'POST']);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlenght' => 255
        ]);

        $this->add($email);

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