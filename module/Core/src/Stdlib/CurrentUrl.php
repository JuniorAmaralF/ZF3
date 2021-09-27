<?php
//classe que trabalha com urls
namespace Core\Stdlib;

use Zend\Stdlib\RequestInterface;

trait CurrentUrl
{
    public function getUrl(RequestInterface $request)
    {
        $protocol = 'http://';
        if ($request->getServer('HTTPS') != null) {
            $protocol = 'https://';
        }
        //dentro de um servidor de email voce necessita do http:// ou https://
        return $protocol.$request->getServer('HTTP_HOST');
    }
}