<?php

namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * Shop\OrderBundle\Entity\Order
 *
 * @ORM\Table(name="order")
 * @ORM\Entity(repositoryClass="Shop\OrderBundle\Entity\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /** @ORM\OneToOne(targetEntity="JMSPaymentCore:PaymentInstruction") */
    private $paymentInstruction;

    /** @ORM\Column(type="string", unique = true) */
    private $orderNumber;

    /** @ORM\Column(type="decimal", precision = 2) */
    private $amount;
    
    /**
     * Constructor
     * @param type $amount
     * @param type $orderNumber 
     */
    public function __construct($amount, $orderNumber)
    {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
    }
    
    /**
     * Get order number
     * @return string 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }
    
    /**
     * Get amount
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
     * Get payement instruction
     * @return PaymentInstruction 
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }
    
    
    /**
     * Set Payement instruction
     * @param PaymentInstruction $instruction 
     */
    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }
    
    
    
    
    
}
