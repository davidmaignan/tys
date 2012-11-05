<?php

namespace Shop\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\Payment\CoreBundle\Entity\Payment;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Shop\OrderBundle\Entity\Order2;

class DefaultController extends Controller
{
    
    /** @DI\Inject */
    private $request;

    /** @DI\Inject */
    private $router;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /** @DI\Inject("payment.plugin_controller") */
    private $ppc;

    
    public function indexAction()
    {
        
        $user = $this->get('Security.context')->getToken()->getUser();
        
        $order = new Order2();
        $order->setOrderNumber('test'); 
        $order->setAmount(230.99);
        $order->setUser($user);
        
        $form = $this->get('form.factory')->create('jms_choose_payment_method', null, array(
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
            'default_method' => 'payment_paypal', // Optional
            'predefined_data' => array()
        ));
        
        if ('POST' === $this->request->getMethod()) {
            $form->bindRequest($this->request);

            try{
                $this->em->persist($order);
                $this->em->flush( $order);
            }catch(Exception $e){
                var_dump($e);
            }
 
            $form = $this->get('form.factory')->create('jms_choose_payment_method', null, array(
                'amount'   => $order->getAmount(),
                'currency' => 'EUR',
                'default_method' => 'payment_paypal', // Optional
                'predefined_data' => array(
                    'paypal_express_checkout' => array(
                        'return_url' => $this->router->generate('payment_complete', array(
                            'id' =>$order->getId()
                        ), true),
                        'cancel_url' => $this->router->generate('payment_cancel', array(
                            'id' => $order->getId()
                        ), true)
                    ),
                ),
            ));
 
            $form->bindRequest($this->request);
            
            // Once the Form is validate, you update the order with payment instruction
            if ($form->isValid()) {
                $instruction = $form->getData();
                $this->ppc->createPaymentInstruction($instruction);
                $order->setPaymentInstruction($instruction);
                
                 
                 try{
                    $this->em->persist( $order);
                    $this->em->flush( $order);
                }catch(Exception $e){
                    var_dump($e);
                }
                // now, let's redirect to payment_complete with the order id
                echo 'payement complete';
                exit;
                
                return new RedirectResponse($this->router->generate('payment_complete', array('id' => 1 )));
            }
        }
          
        return $this->render('ShopPaymentBundle:Default:index.html.twig', array('form'=>$form->createView(), 'id'=>1));
    }
}
