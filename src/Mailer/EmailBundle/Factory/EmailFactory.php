<?php

namespace Mailer\EmailBundle\Factory;

use Mailer\EmailBundle\Entity\RegistrationEmail;

class EmailFactory
{
    
    public static $email;
    
    public static function &factory($type)
    {
        if(!is_object(self::$request))
        {
            switch ($type) {
                case 'registration':
                    self::$email = new RegistrationEmail();
                    break;


                default:
                    self::$request = null;
                    break;
            }

            return self::$request;
        }
    }
    
    
}