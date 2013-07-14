<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Security\AuthenticateBundle\Service;

/**
 * Allows programmatical authentication of user
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

class AuthenticateService implements AuthenticateServiceInterface{
    
/**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface Security Context
     */
    protected $securityContext;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface Session
     */
    protected $session;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface Event Dispatcher
     */
    protected $eventDispatcher;

    /**
     * @var string the default key to the security context of the secured area.
     */
    protected $contextKey;

    /**
     * Define the Security Context
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Define the Session
     *
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Define the Event Dispatcher
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Define the Context Key
     *
     * @param string $contextKey
     */
    public function setContextKey($contextKey)
    {
        $this->contextKey = $contextKey;
    }
    
}
