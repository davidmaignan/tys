<?php

namespace Component\ComponentBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class ComponentFormHandler
{
    /**
     * @var \Symfony\Component\Form\Form Form 
     */
    protected $form;
    
    /**
     * @var \Symfony\Component\HttpFoundation\Request Request 
     */
    protected $request;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request Request
     * 
     */
    public function __construct(Request $request)
    {

        $this->request = $request;
        echo 'here';
        
    }
    
    /**
     * Get the form.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }
    
    
}
