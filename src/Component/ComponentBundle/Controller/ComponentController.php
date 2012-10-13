<?php

namespace Component\ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Component Controller
 *  
 */
abstract class ComponentController extends Controller
{
    /**
     * @var \IC\Bundle\Core\SecurityBundle\Form\Handler\ComponentFormHandler
     */
    private $componentFormHandler;
    
    /**
     * Process Component submission
     * 
     * @param object $componentFormModel
     * 
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    protected  function process($componentFormModel)
    {
        $componentFormHandler = $this->getComponentFormHandler();
        $componentResponse = $componentFormHandler->process($componentFormModel);
        
        return $this->handleResponse($componentResponse);
    }
    
    /**
     * Retrieve associated Component Form View
     * 
     * @param object $componentFormModel    Component form model
     * @param integer $componentSuffix      Unique suffix when multiple form with the same name are present
     * 
     * @return \Symfony\Component\Form\FormView 
     */
    protected function getComponentFormView($componentSuffix = null)
    {
        $sessionService         = $this->container->get('session');
        
        //$componentName          = $this->getComponentName() . $componentSuffix;
        //$componentFormHandler   = $this->getComponentFormHandler();
        //$componentForm          = $componentFormHandler->getForm();
        $form = $this->createForm(new \Core\LevelBundle\Form\LevelType(), new \Core\LevelBundle\Entity\Level());
        return $form->createView();
    }
    
    /**
     * Retrieve associated Component Form Handler
     * 
     * @return  
     */
    protected function getComponentFormHandler()
    {
        if ( ! $this->componentFormHandler )
        {
            $this->componentFormHandler = $this->container->get($this->getComponentName());
        }
        
        return $this->componentFormHandler;
    }

    /**
     * Retrieve component name
     * 
     * @abstract
     * 
     * @return string
     */
    abstract protected function getComponentName();
    
    /**
     * Retrieve the Component Form submission success redirection route
     * 
     * @abstract
     * 
     * @return string
     *   
     */
    abstract protected function getSuccessRoute();
    
}
