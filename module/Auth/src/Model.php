<?php

namespace Auth;

class Model
{
    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }
}