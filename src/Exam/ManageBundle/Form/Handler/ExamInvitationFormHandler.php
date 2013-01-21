<?php

namespace Exam\ManageBundle\Form\Handler;

class ExamInvitationFormHandler {
    
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
    public function __construct(Form $form)
    {
        $this->form    = $form;

    }

    
}
