<?php

namespace Dm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dm\QuestionBundle\Entity\Question;
use Dm\QuestionBundle\Entity\Answer;
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
        
        $answer1 = new Answer();
        $answer1->setQuestion($question);
        
        $answer2 = new Answer();
        $answer2->setQuestion($question);
        
        $answer3 = new Answer();
        $answer3->setQuestion($question);
        
        $answer4 = new Answer();
        $answer4->setQuestion($question);
        
        $question->getAnswers()->add($answer1);
        $question->getAnswers()->add($answer2);
        $question->getAnswers()->add($answer3);
        $question->getAnswers()->add($answer4);
        
        $form = $this->createForm(new QuestionType(), $question);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if ($form->isValid()) {
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($question);
                $em->persist($answer1);
                $em->persist($answer2);
                $em->persist($answer3);
                $em->persist($answer4);
                $em->flush();
                
                
                return $this->redirect($this->generateUrl('DmAdminBundle_homepage'));
            }
        }


        return $this->render('DmAdminBundle:Question:create.html.twig', array('form' => $form->createView()));
    }

}
