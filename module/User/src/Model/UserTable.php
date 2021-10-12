<?php

namespace User\Model;

use Core\Model\AbstractCoreModelTable;
use Zend\Crypt\Password\Bcrypt;

class UserTable extends AbstractCoreModelTable
{
    public function save(array $data)
    {
        $token = null;
        //caso ja tenha o token
        if(isset($data['token'])) {
            $data['email_confirmed'] = true;
            unset($data['password']);
        }else {
          //   $data['email_confirmed'] = 0;
        }

        //criptografia a senha
        if(isset($data['password'])){
            $data['password'] = (new Bcrypt())->create($data['password']); 
        }

        if (!isset($data['id']) || (count($data) ==2  && array_search('email',array_keys($data)))){
            $token = $this->generateToken();
        }

        $data['token'] = $token;


        return parent::save($data);
    }


    //gera token
    public function generateToken()
    {
        return substr(sha1(uniqid(10,20)), 0,32);
    }
    //pegar o usuario pelo token 
    public function getUserByToken($token)
    {
        return $this->getBy(['token' => $token]);

    }
    //pegando usuario por email
    public function getUserByEmail($email)
    {
       return $this->getBy(['email' => $email]);
    }


}