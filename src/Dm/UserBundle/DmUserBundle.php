<?php

namespace Dm\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DmUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
