<?php
/**
 * @copyright 2012 testyrskills Inc.
 */

namespace Exam\ManageBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\Form;

/**
 * Component Form Handler
 */
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
     * @var object Service
     */
    protected $service;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Form\Form              $form    Form
     * @param \Symfony\Component\HttpFoundation\Request $request Request
     * @param object                                    $service Service
     */
    public function __construct(Form $form, Request $request, $service)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * Process the form based on request.
     *
     * @param object $model Model
     *
     * @return boolean|null
     */
    public function process($model)
    {
        // Ignore non-POST requests
        if ( ! in_array($this->request->getMethod(), $this->getAllowedMethodList())) {
            return null;
        }
        $this->form->setData($model);
        $this->form->bindRequest($this->request);
        
        $datas = $this->form->getData();  
        
        if ( ! $this->form->isValid()) {
            return null;
        }

        return $this->executeService($model);
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

    /**
     * Return the allowed Component Form submission method list.
     *
     * @return array
     */
    protected function getAllowedMethodList()
    {
        return array('POST');
    }

    /**
     * Execute the service action.
     *
     * @param object $model Model
     *
     * @return boolean
     */
    protected function executeService($model)
    {
        return $this->service->execute($model);
    }
}
