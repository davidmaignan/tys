<?php

namespace Dm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dm\QuestionBundle\Entity\Question;
use Dm\QuestionBundle\Entity\Answer;
use Dm\QuestionBundle\Form\QuestionType;

class QuestionController extends Controller {

    public function indexAction($page) {

        $em = $this->getDoctrine()->getEntityManager();
        
        
        $dql = "SELECT a FROM DmQuestionBundle:Question a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', $page ),
            10
        );
        

        ///var_dump($this->container->getParameter('knp_paginator'));
        //exit;

        // parameters to template
        //return compact('pagination');
        /*
        $questions = $em->createQueryBuilder()
                ->select('b')
                ->from('DmQuestionBundle:Question', 'b')
                ->getQuery()
                ->getResult();
        
         * 
         */
        
        

        return $this->render('DmAdminBundle:Question:index.html.twig', array('pagination'=>$pagination));
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
    
    
    public function editAction($id, Request $request)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $question = $em->getRepository('DmQuestionBundle:Question')->find($id);
        
        //$question = new Question();
        
        if (!$question) {
            throw $this->createNotFoundException('No question found for is '.$id);
        }
        
        // Create an array of the current Tag objects in the database
        foreach ($question->getTags() as $tag){
            $originalTags[] = $tag;
        }
       
        
        $editForm = $this->createForm(new QuestionType(), $question);
        
        if('POST' === $request->getMethod()){
            
            $editForm->bindRequest($this->getRequest());
            
            if($editForm->isValid()){
                
                foreach ($question->getTags() as $tag) {
                    foreach ($originalTags as $key => $toDel) {
                        if ($toDel->getId() === $tag->getId()) {
                            unset($originalTags[$key]);
                        }
                    }
                }
                
                
                // remove the relationship between the tag and the Task
                foreach ($originalTags as $tag) {
                    // remove the Task from the Tag
                    $tag->getTasks()->removeElement($task);

                    // if it were a ManyToOne relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $em->persist($tag);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $em->remove($tag);
                }

                
                $em->persist($question);
                $em->flush();
                
                
            }
            
            return $this->redirect($this->generateUrl('DmAdminBundle_question_edit', array('id' => $id)));
            
        }
        
        
        
        
        return $this->render('DmAdminBundle:Question:edit.html.twig', array('form' => $editForm->createView(), 'id'=>$id));
        
    }
    
    

}
