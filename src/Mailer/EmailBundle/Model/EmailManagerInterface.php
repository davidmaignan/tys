<?php

namespace Mailer\EmailBundle\Model;

interface EmailManagerInterface
{
    
    public function createEmail();
    
    public function supportsClass($class);
    
    
}
