<?php

namespace Exam\ManageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Exam\ManageBundle\Form\Model\ExamInvitationFormModel;

class InvitationController extends Controller
{
    
    public function indexAction($examId = null)
    {
        $formModel = new ExamInvitationFormModel();
        $formModel->setExamId($examId);
        
        $formHandler = $this->get('csr.pit.form_handler.user_status_create');
        $form = $formHandler->getForm();
        $form->setData($formModel);
           
        if('POST' == $this->getRequest()->getMethod()){
             
            if($formHandler->process($formModel)){
                return $this->redirect($this->generateUrl('exam_send_invitation_confirmed')); 
            }
        }
        
        return $this->render('ExamManageBundle:Invitation:index.html.twig', 
                array('form'=>$form->createView(), 'examId' => $examId));
    }
    
    /**
     * Invitation confirmed
     * @return \Symfony\Component\HttpFoundation\JsonResponse 
     */
    public function confirmedAction(){
        return new JsonResponse('invitation sent successfully');
    }
}
