<?php

namespace Security\AuthenticateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SecurityAuthenticateBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
