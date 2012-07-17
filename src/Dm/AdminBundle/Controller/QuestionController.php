<?php

namespace Dm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dm\QuestionBundle\Entity\Question;
use Dm\QuestionBundle\Form\QuestionType;

class QuestionController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getEntityManager();

        $questions = $em->createQueryBuilder()
                ->select('b')
                ->from('DmQuestionBundle:Question', 'b')
                ->getQuery()
                ->getResult();

        return $this->render('DmAdminBundle:Question:index.html.twig', array('questions' => $questions));
    }

    public function createAction() {


        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if ($form->isValid()) {
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($question);
                $em->flush();
                
                
                return $this->redirect($this->generateUrl('DmAdminBundle_homepage'));
            }
        }

        return $this->render('DmAdminBundle:Question:create.html.twig', array('form' => $form->createView()));
    }

}
