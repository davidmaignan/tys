<?php

/*
 * This file is part of the QuestionReviewBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Question\ReviewBundle\Form\Handler;

//use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

use Core\CommentBundle\Model\CommentManagerInterface;
use Core\CommentBundle\Entity\CommentInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class CommentFormHandler
{
    
    protected $request;
    protected $form;
    protected $commentManager;
    protected $mailer;
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                CommentManagerInterface $commentManager,
                                SecurityContext $securityContext,
                                $mailer)
    {
        $this->form = $form;
        $this->request = $request;
        $this->commentManager = $commentManager;
        $this->securityContext = $securityContext;
        $this->mailer = $mailer;
    }
    
    public function process($question, $confirmation = false)
    {
        
        $comment =  $this->commentManager->createComment();
       
        if ('POST' === $this->request->getMethod()) {
            
            $this->form->setData($comment);
            
             if( $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY') || 
                $this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){

                $comment->setUser($this->securityContext->getToken()->getUser());
            }

            $comment->setQuestion($question);

            $this->form->bind($this->request);
                     
            if ($this->form->isValid()) {

                $this->onSuccess($comment, $confirmation);               
                return true;
            }
        }

        return false;
    }
    
    /**
     * @param CommentInterface $comment
     * @param boolean $confirmation
     */
    protected function onSuccess(CommentInterface $comment, $confirmation)
    {
                
       $this->commentManager->updateComment($comment);
    }
    
     /**
     * @return QuestionInterface
     */
    protected function createComment()
    {
        return $this->questionManager->createQuestion();
    }
}
