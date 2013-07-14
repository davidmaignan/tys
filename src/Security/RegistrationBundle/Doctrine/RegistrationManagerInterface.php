<?php

/*
 * This file is part of the CoreQuestionBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Security\RegistrationBundle\Doctrine;

/**
 * Interface to be implemented by user manager. This adds an additional level
 * of abstraction between the application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Persistence\ObjectManager;

interface RegistrationManagerInterface
{   
    /**
     * 
     * @param type $class
     */
    public function supportsClass($class);
    
    /**
     * 
     * @param Doctrine\Common\Persistence\ObjectManager $om
     * @param type                                      $class
     */
    public function __construct(ObjectManager $om, $class);

    /**
     * Returns the question's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
    
    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createUser();

}