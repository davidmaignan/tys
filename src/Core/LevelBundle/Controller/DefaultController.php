<?php

namespace Core\LevelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Component\ComponentBundle\Controller\ComponentController;

use Core\LevelBundle\Entity\Level;


class DefaultController extends ComponentController
{
    public function indexAction()
    {
        
        $levelFormView = $this->getComponentFormView();
        
        return $this->render('CoreLevelBundle:Default:index.html.twig',
                array('form'    => $levelFormView
                    )
               );
    }
    
    /*
     * 
     * $authenticationFormView = $this->getComponentFormView(new AuthenticationFormModel());
        $session                = $request->getSession();

        return $this->render(
            'ICCoreSecurityBundle:Authentication:login.html.twig',
            array(
                'form'                => $authenticationFormView,
                'authenticationError' => $this->getErrorMessage($request, $session),
                'lastUsername'        => $session->get(SecurityContext::LAST_USERNAME)
            )
        );
     */
    
    /**
     * {@inheritdoc} 
     */
    protected function getComponentName() {
        return 'core.level.form_handler.index';
    }
    
    /**
     * {@inheritdoc} 
     */
    protected function getSuccessRoute() {
        return '';
    }
}
