<?php

/*
 * This file is part of the ExamPracticeBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Exam\PracticeBundle\Controller;

/**
 * Controller to list all the test a user is registered for
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        $candidate = $this->get('security.context')->getToken()->getUser();
        
        //Retrieve the list of exams
        $examManager = $this->get('exam_generate.exam_manager.doctrine');
        
        $exams = $examManager->findExamsByCandidates($candidate);
        
        return $this->render('ExamPracticeBundle:List:index.html.twig', array('exams' => $exams));
    }
}