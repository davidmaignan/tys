<?php

namespace Api\OAuthBundle\Form\Model;

class Authorize
{
    protected $allowAccess;
    
    public function getAllowAccess()
    {
        return $this->allowAccess;
    }

    public function setAllowAccess($allowAccess)
    {
        $this->allowAccess = $allowAccess;
    }
}
