<?php

namespace User\Form\Filter;

use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class UserFilter extends InputFilter
{
    public function __construct(Adapter $adapter)
    {
        $name = new Input('name');
        //validando em front end
        $name->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')
            ->attachByName('StripTags');
        //validando em back end
        $name->getValidatorChain()->addValidator(new NotEmpty())
        ->addValidator(new StringLength(['max' => 120]));
        $this->add($name);

        $email = new Input('email');
        //validando em front end
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')
            ->attachByName('StripTags');
        //validando em back end
        $email->getValidatorChain()->addValidator(new NotEmpty())
        ->addValidator(new StringLength(['max' => 255]))
        ->addValidator(new NoRecordExists([
            'table' => 'users',
            'field' => 'email',
            'adapter' => $adapter,
            'messages' => [
                'recordFound' => 'Este Email ja esta em uso'
            ]
        ]));
        $this->add($email);

        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')
            ->attachByName('StripTags');

        $password->getValidatorChain()->addValidator(new NotEmpty())
        ->addValidator(new StringLength(['max' => 48 , 'min' => 5]))
        ->addValidator(new Identical([
            'token' => 'verifypassword',
            'messages' => [
                'notSame' => 'As senha fornecidas nao combinam'
            ]
        ]));
        $this->add($password);

        $verifyPassword = new Input('verifypassword');
        $verifyPassword->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')
            ->attachByName('StripTags');
     
        $verifyPassword->getValidatorChain()->addValidator(new NotEmpty())
        ->addValidator(new StringLength(['max' => 48 , 'min' => 5]));
        $this->add($verifyPassword);
    }
}