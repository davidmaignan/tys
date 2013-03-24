<?php

namespace Api\OauthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiOauthBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSOAuthServerBundle';
    }
}
