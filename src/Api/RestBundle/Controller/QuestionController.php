<?php

namespace Api\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use Connect\ContactBundle\Entity\Contact;
use Connect\ContactBundle\Form\ContactType;

class QuestionController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConnectContactBundle:Contact:index.html.twig');
    }

    public function newQuestionsAction()
    {
        $contact = new Contact();
        $form   = $this->createForm(new ContactType(), $contact);

        $view = View::create();
        $view->setTemplate('ApiRestBundle:Question:newContacts.html.twig');
        $view->setData(array(
            'contact'   => $contact,
            'form'      => $form->createView()
        ));

        return $view;
    } // "new_questions"    [GET] /questions/new

    public function getQuestionsAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $questions  = $em->getRepository('CoreQuestionBundle:Question')->findAll();

        $view = View::create();
        $handler = $this->get('fos_rest.view_handler');
        if ('html' === $this->getRequest()->getRequestFormat())
            $view->setData(array('questions' => $questions));
        else
            $view->setData($questions);
        $view->setTemplate('ApiRestBundle:Question:getQuestions.html.twig');

        return $view;
    } // "get_questions"    [GET] /questions

    public function postQuestionsAction()
    {
        $request = $this->getRequest();
        
        $values = $request->get('contact', array());
        
        if ('json' === $this->getRequest()->getRequestFormat())
        {
            $values['name']        = $request->get('name');
            $values['email']       = $request->get('email');
            $values['location']    = $request->get('location');
            $values['website']     = $request->get('website');
            $values['tel']         = $request->get('tel');
            $values['mobile']      = $request->get('mobile');
            $values['additional']  = $request->get('additional');
        }
        $contact = new Contact();
        $contact->setName($values['name']);
        $contact->setEmail($values['email']);
        $contact->setLocation($values['location']);
        $contact->setWebsite($values['website']);
        $contact->setTel($values['tel']);
        $contact->setMobile($values['mobile']);
        $contact->setAdditional($values['additional']);

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($contact);
        $em->flush();

        if ('html' === $this->getRequest()->getRequestFormat())
        {
            return $this->redirect($this->generateUrl('get_questions'));
        }

        $view = View::create();
        $view->setData($contact);

        return $view;
    } // "post_questions"   [POST] /questions

    public function getQuestionAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $contact    = $em->getRepository('CoreQuestionBundle:Question')->find($id);

        $view = View::create();
        $view->setData($contact);

        return $view;
    } // "get_question"     [GET] /questions/{$id}

    public function putQuestionAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $contact    = $em->getRepository('CoreQuestionBundle:Question')->find($id);

        $request = $this->getRequest();

        $event->setDone($request->get('done'));
        $em->persist($contact);
        $em->flush();

        $view = View::create();
        $view->setData($event);

        return $view;
    } // "put_question"     [PUT] /questions/{id}

    public function deleteQuestionAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $contact    = $em->getRepository('CoreQuestionBundle:Question')->find($id);

        $em->remove($contact);
        $em->flush();

        if ('html' === $this->getRequest()->getRequestFormat())
        {
            return $this->redirect($this->generateUrl('connect_get_contacts'));
        }
        
        $view = View::create();
        $view->setTemplate('ConnectContactBundle:Contact:deleteContact.html.twig');

        return $view;
    } // "delete_question"  [DELETE] /questions/{$id}

}
